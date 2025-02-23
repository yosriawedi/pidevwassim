<?php

namespace App\Controller;

use App\Entity\Internship;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class BackOfficeController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard(): Response
    {
        return $this->render('Back/index.html.twig');
    }

    #[Route('/users', name: 'users')]
    public function users(): Response
    {
        return $this->render('Back/DashBoardUser.html.twig');
    }

    #[Route('/courses', name: 'courses')]
    public function courses(): Response
    {
        return $this->render('Back/Courses.html.twig');
    }

    #[Route('/add-course', name: 'add_course')]
    public function addCourse(): Response
    {
        return $this->render('Back/AddCourse.html.twig');
    }

    #[Route('/internships', name: 'internships')]
    public function internships(): Response
    {
        return $this->render('Back/internship.html.twig');
    }
    
    #[Route('/internship/create', name: 'create_internship')]
    public function createInternship(): Response
    {
        return $this->render('Back/CreateInternship.html.twig');
    }

    // Utilisation de la même route pour la modification d'un stage
    #[Route('/internship/modify/{id}', name: 'modify_internship')]
    public function modifyInternship($id, EntityManagerInterface $entityManager): Response
    {
        $internship = $entityManager->getRepository(Internship::class)->find($id);

        if (!$internship) {
            throw $this->createNotFoundException('Stage non trouvé');
        }

        // Passer l'internship à la vue
        return $this->render('Back/ModifyInternship.html.twig', [
            'internship' => $internship,
        ]);
    }

    #[Route('/complaints', name: 'complaints')]
    public function complaints(): Response
    {
        return $this->render('Back/Complaints.html.twig');
    }

    #[Route('/events', name: 'events')]
    public function events(): Response
    {
        return $this->render('Back/tableEvents.html.twig');
    }

    #[Route('/add-event', name: 'add_event')]
    public function addEvent(): Response
    {
        return $this->render('Back/addEvent.html.twig');
    }

    #[Route('/modify-event', name: 'modify_event')]
    public function modifyEvent(): Response
    {
        return $this->render('Back/modifyEvent.html.twig');
    }

    #[Route('/resources', name: 'resources')]
    public function resources(): Response
    {
        return $this->render('Back/AddRessource.html.twig');
    }

    #[Route('/add-resource', name: 'add_resource')]
    public function addResource(): Response
    {
        return $this->render('Back/AddRessource.html.twig');
    }

    #[Route('/chart', name: 'chart')]
    public function chart(): Response
    {
        return $this->render('Back/chartjs.html.twig');
    }
}
