<?php

namespace App\Controller;

use App\Entity\Argonaute;
use App\Form\ArgonauteType;
use App\Repository\ArgonauteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArgonauteController extends AbstractController
{
    /**
     * Fetch all the crew members and logic for adding more
     * 
     * @Route("/", name="home")
     * @param ArgonauteRepository $repository
     * @param Request $request
     * @return Response
     */
    public function index(ArgonauteRepository $repository, Request $request): Response
    {
        // Fetch all the crewmembers
        $argonautes = $repository->findAll();

        // Initialize a new instance of the Argonaute entity
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

            // Prevent refreshing
            return $this->redirectToRoute('home');
        }

        return $this->render('argonaute/index.html.twig', [
            'argonautes' => $argonautes,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Logic for deleting a crew member
     * 
     * @Route("/{id}", name="delete")
     * @param Request $request
     * @param Argonaute $argonaute
     * @return Response
     */
    public function delete(Request $request, Argonaute $argonaute): Response
    {
        if ($this->isCsrfTokenValid(
            'delete'.$argonaute->getId(), 
            $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($argonaute);
                $entityManager->flush();
        }

        return $this->redirectToRoute('home');
    }
}
