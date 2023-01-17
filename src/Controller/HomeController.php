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
    //options for the info controller
    const FORM_SUBMITTED = 0,
        INVALID_REALISATION = 1;
    const INFO_OPTIONS = [
        [
            'title' => 'Merci à vous',
            'message' => 'Votre message a bien été envoyé. Je vous répondrai sous peu.'
        ],
        [
            'title' => 'Réalisation indisponible',
            'message' => "Désolé, cette réalisation n'est pas disponible pour le moment. Cela peut être pour cause de maintenance, ou tout simplement car elle n'existe pas."
        ]
    ];

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

            return $this->redirectToRoute('info', ["msgId" => self::FORM_SUBMITTED]);
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
            return $this->redirectToRoute('info', ["msgId" => self::INVALID_REALISATION]);
        }

        return $this->render('main/realisation.html.twig', [
            'realisation' => $repository->find($id)
        ]);
    }

    /**
     * @Route("/info/{msgId}", name="info")
     * @param $msgId
     * @return Response
     */
    public function info($msgId): Response
    {
        return $this->render('main/info.html.twig', [
            'title' => self::INFO_OPTIONS[$msgId]['title'],
            'message' => self::INFO_OPTIONS[$msgId]['message']
        ]);
    }
}
