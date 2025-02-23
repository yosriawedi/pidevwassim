<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Form\PanierType;
use App\Repository\PanierRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CourseRepository;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;


#[Route('/panier')]
final class PanierController extends AbstractController
{
    #[Route(name: 'app_panier_index', methods: ['GET'])]
    public function index(PanierRepository $panierRepository): Response
    {
        return $this->render('panier/index.html.twig', [
            'paniers' => $panierRepository->findAll(),
        ]);
    }

    #[Route('/view', name: 'app_panier_view', methods: ['GET'])]
    public function view(
        SessionInterface $session,
        PanierRepository $panierRepository
    ): Response {
        $panierId = $session->get('panier_id');
        $panier = null;
        $total = 0.0;
    
        if ($panierId) {
            $panier = $panierRepository->find($panierId);
            
            if ($panier) {
                foreach ($panier->getCourses() as $course) {
                    $total += $course->getPrice() ?: 0;
                }
            }
        }
    
        return $this->render('panier/view.html.twig', [
            'panier' => $panier,
            'total' => $total,
        ]);
    }

    #[Route('/panier/checkout', name: 'app_panier_checkout', methods: ['GET'])]
    public function checkout(
        SessionInterface $session,
        PanierRepository $panierRepository
    ): Response {
        // 1) Retrieve your Stripe secret key from .env
        $stripeSecretKey = $this->getParameter('stripe_secret_key');
        Stripe::setApiKey($stripeSecretKey);

        // 2) Fetch the user's Panier from session
        $panierId = $session->get('panier_id');
        if (!$panierId) {
            // No panier => redirect or show an error
            $this->addFlash('error', 'No panier found!');
            return $this->redirectToRoute('app_course_index_front');
        }

        $panier = $panierRepository->find($panierId);
        if (!$panier) {
            $this->addFlash('error', 'No panier found in database!');
            return $this->redirectToRoute('app_course_index_front');
        }

        // 3) Build line items from your Panier's courses
        $lineItems = [];
        foreach ($panier->getCourses() as $course) {
            // price in *cents* for Stripe, if the course price is float TND
            // multiply by 100 if you want TND to be treated as "dinars -> cents" 
            // or do your own currency/cents logic
            $priceCents = intval(($course->getPrice() ?: 0) * 100);

            $lineItems[] = [
                'price_data' => [
                    'currency'     => 'usd',      // or 'eur', 'TND' might require custom setup
                    'product_data' => [
                        'name' => $course->getTitle(),
                    ],
                    'unit_amount'  => $priceCents,
                ],
                'quantity' => 1, // or if you have quantity logic
            ];
        }

        if (count($lineItems) === 0) {
            $this->addFlash('error', 'Your panier is empty!');
            return $this->redirectToRoute('app_course_index_front');
        }

        // 4) Create a Checkout Session
        $checkoutSession = CheckoutSession::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode'       => 'payment',
            // The URL Stripe redirects to when payment is successful
            'success_url' => $this->generateUrl('app_panier_payment_success', [], 
                                \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL),
            // The URL Stripe redirects to if the user cancels
            'cancel_url'  => $this->generateUrl('app_panier_payment_cancel', [], 
                                \Symfony\Component\Routing\Generator\UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        // 5) Redirect to the Stripe Checkout page
        return $this->redirect($checkoutSession->url, 303);
    }

    #[Route('/panier/payment-success', name: 'app_panier_payment_success', methods: ['GET'])]
    public function paymentSuccess(SessionInterface $session, PanierRepository $panierRepository): Response
    {
        // Here you could mark the Panier as "paid" or empty the Panier
        $panierId = $session->get('panier_id');
        if ($panierId) {
            $panier = $panierRepository->find($panierId);
            $session->remove('panier_id');
        }

        return $this->render('panier/payment_success.html.twig', [
            'message' => 'Payment completed successfully!',
        ]);
    }

    #[Route('/panier/payment-cancel', name: 'app_panier_payment_cancel', methods: ['GET'])]
    public function paymentCancel(): Response
    {
        return $this->render('panier/payment_cancel.html.twig', [
            'message' => 'Payment was canceled.',
        ]);
    }

    #[Route('/new', name: 'app_panier_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $panier = new Panier();
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($panier);
            $entityManager->flush();

            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('panier/new.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_panier_show', methods: ['GET'])]
    public function show(Panier $panier): Response
    {
        return $this->render('panier/show.html.twig', [
            'panier' => $panier,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_panier_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PanierType::class, $panier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('panier/edit.html.twig', [
            'panier' => $panier,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_panier_delete', methods: ['POST'])]
    public function delete(Request $request, Panier $panier, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panier->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($panier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_panier_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/panier/add/{courseId}', name: 'app_panier_add_course', methods: ['GET', 'POST'])]
    public function addCourse(
        int $courseId,
        CourseRepository $courseRepository,
        PanierRepository $panierRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // 1) Find the Course
        $course = $courseRepository->find($courseId);
        if (!$course) {
            throw $this->createNotFoundException('Course not found');
        }
        
        // 2) Find or create the Panier
        //    a) If you store one Panier per User, you might look it up by $this->getUser().
        //    b) Or you can create a new Panier each time for demonstration.
        $panier = new Panier();
        
        // 3) Add the course to the Panier
        $panier->addCourse($course);
        
        // 4) Persist and flush
        $entityManager->persist($panier);
        $entityManager->flush();

        // 5) Redirect somewhere (e.g. to your Panier index or back to courses)
        return $this->redirectToRoute('app_panier_index');
    }

    #[Route('/toggle/{courseId}', name: 'app_panier_toggle_course', methods: ['GET','POST'])]
    public function toggleCourse(
        int $courseId,
        Request $request,
        SessionInterface $session,
        CourseRepository $courseRepository,
        PanierRepository $panierRepository,
        EntityManagerInterface $entityManager
    ): Response {
        // 1) Get or create the user's Panier from session
        $panierId = $session->get('panier_id'); // retrieve from session
        if ($panierId) {
            // we have a Panier ID stored
            $panier = $panierRepository->find($panierId);
        } else {
            // no Panier in session, create a new one
            $panier = new Panier();
            $entityManager->persist($panier);
            $entityManager->flush(); // so it has an ID
            // store it in the session
            $session->set('panier_id', $panier->getId());
        }

        // 2) Find the Course to toggle
        $course = $courseRepository->find($courseId);
        if (!$course) {
            $this->addFlash('warning', 'Course not found');
            return $this->redirectToRoute('app_course_index_front');
        }

        // 3) Check if this course is already in the Panier
        if ($panier->getCourses()->contains($course)) {
            // It's there => remove it
            $panier->removeCourse($course);
            $this->addFlash('success', 'Course removed from Panier!');
        } else {
            // It's not there => add it
            $panier->addCourse($course);
            $this->addFlash('success', 'Course added to Panier!');
        }

        // 4) Persist changes
        $entityManager->flush();

        // 5) Redirect back or to the same page
        // For example, redirect to the course listing:
        return $this->redirectToRoute('app_course_index_front');
    }

    
    

}
