<?php

namespace App\Controller;

use App\Repository\ArgonauteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArgonauteController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ArgonauteRepository $repository): Response
    {
        $argonautes = $repository->findAll();

        return $this->render('argonaute/index.html.twig', [
            'argonautes' => $argonautes,
        ]);
    }
}
