<?php

namespace App\Controller;

use App\Entity\Course;
use App\Form\CourseType;
use App\Repository\CourseRepository;
use App\Repository\RessourceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PanierRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/course')]
final class CourseController extends AbstractController{
    #[Route(name: 'app_course_index', methods: ['GET'])]
    public function index(Request $request, CourseRepository $courseRepository): Response
    {
        // 1) Read GET parameters (or default to empty string)
        $searchTerm = $request->query->get('search', '');
        $domain     = $request->query->get('domain', '');
        $type       = $request->query->get('type', '');

        // 2) Query the repository with these filters
        $courses = $courseRepository->findByFilters(
            $searchTerm !== '' ? $searchTerm : null,
            $domain     !== '' ? $domain : null,
            $type       !== '' ? $type : null
        );

        // 3) Render the template
        return $this->render('course/index.html.twig', [
            'courses'  => $courses,
            'search'   => $searchTerm,
            'domain'   => $domain,
            'type'     => $type,
        ]);
    }

    #[Route('/front', name: 'app_course_index_front', methods: ['GET'])]
    public function indexfront(
        CourseRepository $courseRepository,
        PanierRepository $panierRepository,
        SessionInterface $session,
        Request $request
    ): Response {
        $searchTerm = $request->query->get('search', '');
        $domain     = $request->query->get('domain', '');
        $type       = $request->query->get('type', '');
        $courses = $courseRepository->findByFilters(
            $searchTerm !== '' ? $searchTerm : null,
            $domain     !== '' ? $domain : null,
            $type       !== '' ? $type : null
        );

        // Attempt to get the user's Panier
        $panierId = $session->get('panier_id');
        $panier = null;
        if ($panierId) {
            $panier = $panierRepository->find($panierId);
        }

        return $this->render('Front/Courses.html.twig', [
            'courses'  => $courses,
            'search'   => $searchTerm,
            'domain'   => $domain,
            'type'     => $type,
            'panier' => $panier,
        ]);
    }
    #[Route('/front/{id}', name: 'app_course_show_front', methods: ['GET'])]
    public function showCourse(CourseRepository $courseRepository, RessourceRepository $ressourceRepository, int $id): Response
    {
        // Récupérer le cours correspondant à l'ID
        $course = $courseRepository->find($id);

        // Vérifier si le cours existe
        if (!$course) {
            throw $this->createNotFoundException('Course not found.');
        }

        // Récupérer les ressources associées au cours sélectionné
        $ressources = $ressourceRepository->findBy(['courses' => $course]);  // Use 'courses' instead of 'course'

        return $this->render('Front/CourseDetail.html.twig', [
            'course' => $course,
            'ressources' => $ressources,
        ]);
    }

    #[Route('/export-pdf', name: 'app_course_export_pdf', methods: ['GET'])]
    public function exportPdf(
        CourseRepository $courseRepository
    ): Response {
        // 1) Get your data
        $courses = $courseRepository->findAll();

        // 2) Render the main content (HTML) with Twig
        //    This file can reference external CSS/images either absolutely or relatively
        $html = $this->renderView('course/pdf.html.twig', [
            'courses' => $courses,
        ]);

        // 3) Configure Dompdf
        $pdfOptions = new Options();
        $pdfOptions->setIsRemoteEnabled(true);        // allow external CSS, images, etc.
        $pdfOptions->setChroot($this->getParameter('kernel.project_dir') . '/public');
        $pdfOptions->set('enable_css_float', true);

        // 4) Instantiate Dompdf
        $dompdf = new Dompdf($pdfOptions);

        // 5) Load the rendered HTML
        $dompdf->loadHtml($html);

        // 6) If your template references local assets with relative paths, set a base path:
        $dompdf->setBasePath($this->getParameter('kernel.project_dir') . '/public');

        // 7) Paper settings
        $dompdf->setPaper('A4', 'portrait');

        // 8) Render
        $dompdf->render();

        // 9) Stream the PDF
        $dompdf->stream('courses.pdf', [
            'Attachment' => true
        ]);

        return new Response();
    }




    #[Route('/new', name: 'app_course_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $course = new Course();
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($course);
            $entityManager->flush();

            return $this->redirectToRoute('app_course_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('course/new.html.twig', [
            'course' => $course,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_course_show', methods: ['GET'])]
    public function show(Course $course): Response
    {
        return $this->render('course/show.html.twig', [
            'course' => $course,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_course_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Course $course, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CourseType::class, $course);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_course_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('course/edit.html.twig', [
            'course' => $course,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_course_delete', methods: ['POST'])]
    public function delete(Request $request, Course $course, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$course->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($course);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_course_index', [], Response::HTTP_SEE_OTHER);
    }

    
}
