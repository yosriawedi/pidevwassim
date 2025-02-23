<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class HomeController extends AbstractController
{
    #[Route('/Home', name: 'home')]
    public function home(): Response
    {
        return $this->render('Front/index.html.twig');
    }

    #[Route('/about', name: 'about')]
    public function about(): Response
    {
        return $this->render('Front/About.html.twig');
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('Front/Contact.html.twig');
    }

    #[Route('/courses', name: 'courses')]
    public function courses(): Response
    {
        return $this->render('Front/Courses.html.twig');
    }

    #[Route('/course-details', name: 'course_details')]
    public function courseDetails(): Response
    {
        return $this->render('Front/Course-details.html.twig');
    }

    #[Route('/events', name: 'events')]
    public function events(): Response
    {
        return $this->render('Front/Events.html.twig');
    }

    #[Route('/internships', name: 'internships')]
    public function internships(): Response
    {
        return $this->render('Front/Internship.html.twig');
    }

    #[Route('/postuler', name: 'postuler')]
    public function postuler(): Response
    {
       return $this->render('Front/postuler.html.twig');
    }

    #[Route('/reservation', name: 'reservation')]
    public function reservation(): Response
    {
        return $this->render('Front/Reservation.html.twig');
    }

    #[Route('/reservation/submit', name: 'reservation_submit', methods: ['POST'])]
    public function reservationSubmit(Request $request): RedirectResponse
    {
        $date = $request->request->get('date');
        $time = $request->request->get('time');
        $name = $request->request->get('name');
        $phone = $request->request->get('phone');

        // Simuler l'enregistrement en base de données
        $this->addFlash('success', "Réservation confirmée pour $name le $date à $time.");

        return $this->redirectToRoute('reservation');
    }

    #[Route('/sign-in', name: 'sign_in')]
    public function signIn(): Response
    {
        return $this->render('Front/Sign_In.html.twig');
    }

    #[Route('/sign-up-agent', name: 'sign_up_agent')]
    public function signUpAgent(): Response
    {
        return $this->render('Front/Sign_Up_Agent.html.twig');
    }

    #[Route('/sign-up-student', name: 'sign_up_student')]
    public function signUpStudent(): Response
    {
        return $this->render('Front/Sign_Up_Student.html.twig');
    }

    #[Route('/tutors', name: 'tutors')]
    public function tutors(): Response
    {
        return $this->render('Front/Tutors.html.twig');
    }

   # #[Route('/applyinternship', name: 'apply_internship')]
    #public function applyInternship(): Response
   # {
     #   return $this->render('base/postuler.html.twig');
   # }

    #[Route('/applyinternship/submit', name: 'apply_internship_submit', methods: ['POST'])]
    public function applyInternshipSubmit(Request $request): RedirectResponse
    {
        $name = $request->request->get('name');
        $email = $request->request->get('email');
        $cv = $request->files->get('cv');

        if ($cv) {
            $cvFilename = uniqid() . '.' . $cv->guessExtension();
            $cv->move($this->getParameter('kernel.project_dir') . '/public/uploads', $cvFilename);
        }

        $this->addFlash('success', "Candidature envoyée par $name ($email).");

        return $this->redirectToRoute('apply_internship');
    }
}
