<?php

namespace App\Controller;

use App\Entity\FormMessage;
use App\Entity\Realisation;
use App\Form\ContactFormType;
use App\Repository\RealisationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param RealisationRepository $repository
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function index(RealisationRepository $repository, Request $request, EntityManagerInterface $entityManager): Response
    {
        $realisations = $repository->findAll();
        $form = $this->createForm(ContactFormType::class, new FormMessage());

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $message = $form->getData();

            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('info', ["msg" => 1]);
        }

        return $this->render('main/home.html.twig', [
            'realisations' => $realisations,
            'contactForm' => $form->createView()
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
            return $this->redirectToRoute('info', ["msg" => 2]);
        }

        return $this->render('main/realisation.html.twig', [
            'realisation' => $repository->find($id)
        ]);
    }

    /**
     * @Route("/info/{msg}", name="info")
     * @param $msg
     * @return Response
     */
    public function info($msg): Response
    {
        return $this->render('main/info.html.twig', [
            'message' => $msg
        ]);
    }
}
