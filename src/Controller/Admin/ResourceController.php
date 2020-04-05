<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller\Admin;

use App\Entity\ExcelFile;
use App\Entity\Resource;
use App\Form\Admin\ExcelFileType;
use App\Form\ResourceType;
use App\Repository\ResourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use SplFileInfo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/resource")
 */
class ResourceController extends AbstractController
{
    const BLOCK_PREFIX = 'resource';
    const BASE_ROUTE = 'admin_' . self::BLOCK_PREFIX;
    const BASE_PATH = 'admin/';

    /**
     * @Route("/", name="admin_resource", methods={"GET"})
     */
    public function index(ResourceRepository $resourceRepository): Response
    {
        return $this->render(self::BASE_PATH . self::BLOCK_PREFIX . '/index.html.twig', [
            'resources' => $resourceRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_resource_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $resource = new Resource();
        $form = $this->createForm(ResourceType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($resource);
            $entityManager->flush();

            return $this->redirectToRoute(self::BASE_ROUTE);
        }

        return $this->render(self::BASE_PATH . self::BLOCK_PREFIX . '/new.html.twig', [
            'resource' => $resource,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_resource_show", methods={"GET"})
     */
    public function show(Resource $resource): Response
    {
        return $this->render(self::BASE_PATH . self::BLOCK_PREFIX . '/show.html.twig', [
            'resource' => $resource,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_resource_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Resource $resource): Response
    {
        $form = $this->createForm(ResourceType::class, $resource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(self::BASE_ROUTE);
        }

        return $this->render(self::BASE_PATH . self::BLOCK_PREFIX . '/edit.html.twig', [
            'resource' => $resource,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_resource_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Resource $resource): Response
    {
        if ($this->isCsrfTokenValid('delete' . $resource->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($resource);
            $entityManager->flush();
        }

        return $this->redirectToRoute(self::BASE_ROUTE);
    }

    /**
     * @Route("/load/excel", name="load_from_excel")
     */
    public function loadResources(Request $request, EntityManagerInterface $entityManager): Response
    {
        $excelFile = new ExcelFile();
        $form = $this->createForm(ExcelFileType::class, $excelFile);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $excelFile->getFile();

            if (!in_array($file->guessClientExtension(), ['csv', 'xlsx', 'xls'])) {
                $this->addFlash('danger', 'Le fichier excel est invalide: ' . $file->guessClientExtension());

                return $this->redirectToRoute('admin_resource_new');
            }

            $fileName = md5(uniqid()) . '.' . $file->guessClientExtension();
            $directory = dirname(__FILE__) . '/tmp/';

            try {
                $file->move($directory, $fileName);
            } catch (FileException $e) {
                $this->addFlash('danger', $e->getMessage());

                return $this->redirectToRoute('admin_resource_new');
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
                        $resource = (new Resource())
                            ->setTitle($data['A'])
                            ->setSubtitle($data['B'])
                            ->setSubtitleAR($data['C'])
                            ->setFilename($data['D'])
                            ->setLink($data['E']);

                        $entityManager->persist($resource);
                    }
                }
            } catch (\Exception $e) {
                throw $e;
                // $this->addFlash('danger', $e->getMessage());

                // return $this->redirectToRoute('admin_resource_new');
            } finally {
                unlink($fileName);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Le fichier a été importé.');

            return $this->redirectToRoute('admin_resource');
        }

        return $this->render('admin/common/upload-excel-file.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function getFileExtension(string $filename): ?string
    {
        $info = new SplFileInfo($filename);

        return $info->getExtension();
    }
}
