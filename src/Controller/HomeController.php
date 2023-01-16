<?php

namespace App\Controller;

use App\Entity\Realisation;
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
     * @Route("/realisation/{id}", name="realisation")
     * @param RealisationRepository $repository
     * @param $id
     * @return Response
     */
    public function realisation(RealisationRepository $repository, $id): Response
    {
        $realisation = $repository->find($id);

        if(!$realisation) {
            //TODO ERROR PAGE
        }

        return $this->render('main/realisation.html.twig', [
            'realisation' => $repository->find($id)
        ]);
    }
}
