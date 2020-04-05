<?php

/*
 * This file is part of the COURAT application.
 *
 * (c) Bechir Ba and contributors
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Controller;

use App\Repository\ClassRepository;
use App\Repository\DocumentCategoryRepository;
use App\Repository\DocumentRepository;
use App\Repository\SubjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class LibraryController extends AbstractController
{
    public function index(
        DocumentRepository $documentRep,
        DocumentCategoryRepository $documentCategoryRep,
        SubjectRepository $subjectRepository,
        ClassRepository $classRepository)
    {
        return $this->render('library/index.html.twig', [
            'documents' => $documentRep->findAll(),
            'categories' => $documentCategoryRep->findAll(),
            'subjects' => $subjectRepository->findAll(),
            'classes' => $classRepository->findAll(),
        ]);
    }

    public function filter(Request $request, DocumentRepository $documentRepository): Response
    {
        sleep(1);
        $documents = $documentRepository->filter($request->query);

        return $this->render('library/_documents.html.twig', [
            'documents' => $documents,
        ]);
    }

    public function upload(): Response
    {
        return $this->render('library/upload.html.twig');
    }
}
