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

use App\Entity\Classe;
use App\Entity\Course;
use App\Entity\ExcelFile;
use App\Entity\Subject;
use App\Entity\VideoSource;
use App\Form\Admin\ExcelFileType;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use Doctrine\ORM\EntityManagerInterface;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date as PhpOfficeDate;
use SplFileInfo;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/course")
 */
class CourseController extends AbstractController
{
    /**
     * The courses listing page.
     *
     * @Route("/", name="admin_courses", methods={"GET"})
     */
    public function index(Request $request, CourseRepository $courseRepository): Response
    {
        $courses = $courseRepository->findAll();

        return $this->render('admin/course/index.html.twig', [
            'courses' => $courses,
        ]);
    }

    /**
     * Retrieve the lateste course from the database.
     */
    public function latest(): Response
    {
        $courses = $this->getDoctrine()->getRepository(Course::class)->getLatest();

        return $this->render('admin/course/table.html.twig', [
            'courses' => $courses,
        ]);
    }

    /**
     * Create new course.
     *
     * @param Request $request The Request
     *
     * @Route("/new", name="admin_course_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('admin_courses');
        }

        return $this->render('admin/course/new.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * The course details page.
     *
     * @param Course $course The course, identified by it's (feteched by doctrine)
     *
     * @Route("/{id}", name="admin_course_show", methods={"GET"})
     */
    public function show(Course $course): Response
    {
        return $this->render('admin/course/show.html.twig', [
            'course' => $course,
        ]);
    }

    /**
     * Edit a course.
     *
     * @param Request $request The Request
     * @param Course  $course  The course to edit, identified by it's (feteched by doctrine)
     *
     * @Route("/{id}/edit", name="admin_course_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Course $course): Response
    {
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_courses');
        }

        return $this->render('admin/course/edit.html.twig', [
            'course' => $course,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Delete a course from the database.
     *
     * @param Request $request The Request
     * @param Course  $course  The course to delete, identified by it's (feteched by doctrine)
     *
     * @Route("/{id}", name="admin_course_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Course $course): Response
    {
        if ($this->isCsrfTokenValid('delete' . $course->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($course);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_courses');
    }

    /**
     * @Route("/load/excel", name="load_courses_from_excel")
     */
    public function loadCourses(Request $request, EntityManagerInterface $entityManager): Response
    {
        $excelFile = new ExcelFile();
        $form = $this->createForm(ExcelFileType::class, $excelFile);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $excelFile->getFile();

            if (!in_array($file->guessClientExtension(), ['csv', 'xlsx', 'xls'])) {
                $this->addFlash('danger', 'Le fichier excel est invalide: ' . $file->guessClientExtension());

                return $this->redirectToRoute('admin_course_new');
            }

            $fileName = md5(uniqid()) . '.' . $file->guessClientExtension();
            $directory = dirname(__FILE__) . '/tmp/';

            try {
                $file->move($directory, $fileName);
            } catch (FileException $e) {
                $this->addFlash('danger', $e->getMessage());

                return $this->redirectToRoute('admin_course_new');
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
                        "A$rowIt:G$rowIt",  // The worksheet range that we want to retrieve
                        null,               // Value that should be returned for empty cells
                        true,               // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
                        true,               // Should values be formatted (the equivalent of getFormattedValue() for each cell)
                        true                // Should the array be indexed by cell row and cell column
                    )[$rowIt];

                    if (null != $data['A'] && null != $data['B'] && null != $data['C'] && null != $data['D'] && null != $data['E'] && null != $data['F']) {
                        $course = (new Course())
                            ->setTitle($data['A'])
                            ->setVideoUrl($data['D'] ?? '');

                        if ($publishedDate = $data['E'] ?? null) {
                            $course->setPublishedAt(PhpOfficeDate::excelToDateTimeObject($publishedDate));
                        }

                        try {
                            if ($startTime = $data['G'] ?? null) {
                                $startTime = explode(':', $startTime);
                                $datetime = new \DateTime('0-0-0 0:0:0');
                                switch (count($startTime)) {
                                    case 1:
                                        $datetime->modify("+ $startTime[0] minutes");

                                        break;
                                    case 2:
                                        $datetime->modify("+ $startTime[0] minutes");
                                        $datetime->modify("+ $startTime[1] second");

                                        break;
                                    case 3:
                                        $datetime->modify("+ $startTime[0] hours");
                                        $datetime->modify("+ $startTime[1] minutes");
                                        $datetime->modify("+ $startTime[2] second");

                                        break;
                                    default:
                                        // code...
                                        break;
                                }
                                $course->setStartTime($datetime);
                            }
                        } catch (\Exception $e) {
                            throw $e;
                        }

                        $class = $entityManager->getRepository(Classe::class)->findOneBy(['name' => $data['B'] ?? null]);

                        if ($class) {
                            $class->addCourse($course);
                        }

                        $source = $entityManager->getRepository(VideoSource::class)->findOneBy(['name' => $data['F'] ?? null]);

                        if ($source) {
                            $course->setSource($source);
                        }

                        $subject = $entityManager->getRepository(Subject::class)->findOneBy(['code' => 'subject.' . $data['C'] ?? null]);

                        if ($subject) {
                            $course->setSubject($subject);
                        }

                        $entityManager->persist($course);
                    }
                }
            } catch (\Exception $e) {
                throw $e;
                // $this->addFlash('danger', $e->getMessage());

                // return $this->redirectToRoute('admin_course_new');
            } finally {
                unlink($fileName);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Le fichier a été importé.');

            return $this->redirectToRoute('admin_courses');
        }

        return $this->render('admin/common/upload-excel-file.html.twig', [
            'form' => $form->createView(),
            'path' => 'load_courses_from_excel',
        ]);
    }

    public function getFileExtension(string $filename): ?string
    {
        $article = new SplFileInfo($filename);

        return $article->getExtension();
    }
}
