<?php

namespace App\Controller;

use App\Entity\Realisation;
use App\Form\RealisationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("/realisations/ajout", name="admin_add_realisation")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function addRealisation(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger): Response
    {
        $realisation = new Realisation();

        $form = $this->createForm(RealisationType::class, $realisation);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            /** @var Realisation $realisation */
            $realisation = $form->getData();

            $introImageFile = $form->get('introImage')->getData();

            if($introImageFile) {
                $originalFilename = pathinfo($introImageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$introImageFile->guessExtension();

                try {
                    $introImageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    echo $e;
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $realisation->setIntroImageFilename($newFilename);
            }

            $manager->persist($realisation);
            $manager->flush();

            return $this->redirectToRoute("home");
        }

        return $this->renderForm('admin/add_realisation.html.twig', [
            "form" => $form
        ]);
    }
}
