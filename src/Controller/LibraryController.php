<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) NEOTIC and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Entity\Document;
use App\Form\DocumentType;
use App\Repository\ClassRepository;
use App\Repository\DocumentCategoryRepository;
use App\Repository\DocumentRepository;
use App\Repository\SubjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LibraryController extends AbstractController
{
    /**
     * The library homepage.
     *
     * @param DocumentRepository            The document repository
     * @param DocumentCategoryRepository    Document category repository
     * @param SubjectRepository             Subject repository
     * @param ClassRepository               Class repository
     *
     * @return Response
     */
    public function index(
        DocumentRepository $documentRep,
        DocumentCategoryRepository $documentCategoryRep,
        SubjectRepository $subjectRepository,
        ClassRepository $classRepository)
    {
        return $this->render('library/index.html.twig', [
            'documents' => $documentRep->findBy(['enabled' => true]),
            'categories' => $documentCategoryRep->findAll(),
            'subjects' => $subjectRepository->findAll(),
            'classes' => $classRepository->findAll(),
        ]);
    }

    /**
     * Return list of document filtered by the 'filter query'.
     *
     * @param Request            The request
     * @param DocumentRepository The document repository
     */
    public function filter(Request $request, DocumentRepository $documentRepository): Response
    {
        $documents = $documentRepository->filter($request->query);

        return $this->render('library/_documents.html.twig', [
            'documents' => $documents,
        ]);
    }

    /**
     * Upload document from user.
     */
    public function upload(Request $request, EntityManagerInterface $entityManager): Response
    {
        $document = new Document();
        $form = $this->createForm(DocumentType::class, $document);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $document->setClientIp($request->getClientIp());

            $entityManager->persist($document);
            $entityManager->flush();

            $this->addFlash('success', 'upload.success');

            return $this->redirectToRoute('library_index');
        }

        return $this->render('library/upload.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
