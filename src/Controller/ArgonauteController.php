<?php

namespace App\Controller;

use App\Entity\Argonaute;
use App\Form\ArgonauteType;
use App\Repository\ArgonauteRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArgonauteController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArgonauteRepository $repository, Request $request, EntityManagerInterface
     $entityManager): Response
    {
        // Fetch all the crewmembers
        $argonautes = $repository->findAll();

        // Add a new crewmember
        $crewmember = new Argonaute();

        // Create the form
        $form = $this->createForm(ArgonauteType::class, $crewmember);

        // Prepare the form to get the request
        $form->handleRequest($request);

        // Form validation check
        if ($form->isSubmitted() && $form->isValid()) {
            // Store form data
            $crewmember = $form->getData();

            // Save it into the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($crewmember);
            $entityManager->flush();

            return $this->redirectToRoute('success');
        }

        return $this->render('argonaute/index.html.twig', [
            'argonautes' => $argonautes,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/success", name="success")
     */
    public function success(): Response
    {
        return $this->redirectToRoute('home');
    }

    /**
     * @Route("/new", name="new")
     */
    public function new(Request $request, EntityManager $entityManager): Response
    {
        $crewmember = new Argonaute();

        $form = $this->createForm(ArgonauteType::class, $crewmember);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Store form data
            $crewmember = $form->getData();

            // Save it into the database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($crewmember);
            $entityManager->flush();

            return $this->redirectToRoute('new_success');
        }

        return $this->render('argonaute/new.html.twig', [
            'form' => $form,
        ]);
    }
}
