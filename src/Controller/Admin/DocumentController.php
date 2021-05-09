<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) NEOTIC and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Entity\Classe;
use App\Entity\Document;
use App\Entity\DocumentCategory;
use App\Entity\ExcelFile;
use App\Entity\Subject;
use App\Form\Admin\ExcelFileType;
use App\Form\DocumentType;
use App\Repository\DocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use SplFileInfo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/document")
 */
class DocumentController extends AbstractController
{
    /**
     * @Route("/", name="admin_document_index", methods={"GET"})
     */
    public function index(DocumentRepository $documentRepository): Response
    {
        return $this->render('admin/document/index.html.twig', [
            'documents' => $documentRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_document_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($document);
            $entityManager->flush();

            return $this->redirectToRoute('admin_document_index');
        }

        return $this->render('admin/document/new.html.twig', [
            'document' => $document,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_document_show", methods={"GET"})
     */
    public function show(Document $document): Response
    {
        return $this->render('admin/document/show.html.twig', [
            'document' => $document,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_document_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Document $document): Response
    {
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_document_index');
        }

        return $this->render('admin/document/edit.html.twig', [
            'document' => $document,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_document_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Document $document): Response
    {
        if ($this->isCsrfTokenValid('delete' . $document->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($document);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_document_index');
    }

    /**
     * @Route("/{id}/enabled={enabled}", name="admin_document_toggle_enabled")
     */
    public function toggleEnabled(Document $document, $enabled, EntityManagerInterface $entityManager): Response
    {
        $document->setEnabled($enabled);
        $entityManager->persist($document);
        $entityManager->flush();
        $this->addFlash('success', 'Modifications effectuée.');

        return $this->redirectToRoute('admin_document_show', [
            'id' => $document->getId(),
        ]);
    }

    /**
     * @Route("/load/excel", name="load_documents_from_excel")
     */
    public function loadDocuments(Request $request, EntityManagerInterface $entityManager): Response
    {
        $excelFile = new ExcelFile();
        $form = $this->createForm(ExcelFileType::class, $excelFile);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $excelFile->getFile();

            if (!in_array($file->guessClientExtension(), ['csv', 'xlsx', 'xls'])) {
                $this->addFlash('danger', 'Le fichier excel est invalide: ' . $file->guessClientExtension());

                return $this->redirectToRoute('admin_document_new');
            }

            $fileName = md5(uniqid()) . '.' . $file->guessClientExtension();
            $directory = dirname(__FILE__) . '/tmp/';

            try {
                $file->move($directory, $fileName);
            } catch (FileException $e) {
                $this->addFlash('danger', $e->getMessage());

                return $this->redirectToRoute('admin_document_new');
            }

            $fileName = $directory . '/' . $fileName;
            $extension = $this->getFileExtension($fileName);
            $reader = IOFactory::createReader(ucfirst($extension));

            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($fileName);
            $worksheet = $spreadsheet->getActiveSheet();

            $highestRow = (int) ($worksheet->getHighestDataRow()) - 1;

            try {
                for ($rowIt = 2; $rowIt <= $highestRow; ++$rowIt) {
                    $data = $worksheet->rangeToArray(
                        "A$rowIt:E$rowIt",  // The worksheet range that we want to retrieve
                        null,               // Value that should be returned for empty cells
                        true,               // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
                        true,               // Should values be formatted (the equivalent of getFormattedValue() for each cell)
                        true                // Should the array be indexed by cell row and cell column
                    )[$rowIt];

                    if (null != $data['A'] && null != $data['B'] && null != $data['C'] && null != $data['D'] && null != $data['E']) {
                        $document = (new Document())
                            ->setTitle($data['A'])
                            ->setFileUrl($data['D'])
                            ->setEnabled(true);

                        $class = $entityManager->getRepository(Classe::class)->findOneBy(['name' => $data['B'] ?? null]);
                        if ($class) {
                            $class->addDocument($document);
                        }

                        $subject = $entityManager->getRepository(Subject::class)->findOneBy(['code' => 'subject.' . $data['C'] ?? null]);
                        if ($subject) {
                            $document->setSubject($subject);
                        }

                        $category = $entityManager->getRepository(DocumentCategory::class)->findOneBy(['name' => 'document.category.' . $data['E']]);
                        if ($category) {
                            $document->setCategory($category);
                        }

                        $entityManager->persist($document);
                    }
                }
            } catch (\Exception $e) {
                throw $e;
                // $this->addFlash('danger', $e->getMessage());

                // return $this->redirectToRoute('admin_document_new');
            } finally {
                unlink($fileName);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Le fichier a été importé.');

            return $this->redirectToRoute('admin_document_index');
        }

        return $this->render('admin/common/upload-excel-file.html.twig', [
            'form' => $form->createView(),
            'path' => 'load_documents_from_excel',
        ]);
    }

    public function getFileExtension(string $filename): ?string
    {
        $article = new SplFileInfo($filename);

        return $article->getExtension();
    }
}
