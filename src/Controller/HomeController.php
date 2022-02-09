<?php

namespace App\Controller;

use App\Repository\RealisationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param RealisationRepository $repository
     * @return Response
     */
    public function index(RealisationRepository $repository): Response
    {
        $realisations = $repository->findAll();

        return $this->render('main/home.html.twig', [
            'realisations' => $realisations
        ]);
    }

    /**
     * @Route("/formation", name="education")
     */
    public function formation(): Response
    {
        return $this->render('main/formation.html.twig', [

        ]);
    }

    /**
     * @Route("/a-propos-de-moi", name="about")
     */
    public function about(): Response
    {
        return $this->render('main/about.html.twig', [

        ]);
    }
}
