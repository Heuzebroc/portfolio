<?php

namespace App\Controller;

use App\Entity\Link;
use App\Entity\Realisation;
use App\Entity\Screenshot;
use App\Form\LinkType;
use App\Form\RealisationType;
use App\Form\ScreenshotType;
use App\Repository\RealisationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_ADMIN")
     * @param RealisationRepository $repository
     * @return Response
     */
    public function index(RealisationRepository $repository): Response
    {
        $realisations = $repository->findAll();

        return $this->render('admin/index.html.twig', [
            'realisations' => $realisations,
        ]);
    }

    /**
     * @Route("admin/realisation/ajout", name="admin_add_realisation")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param SluggerInterface $slugger
     * @return Response
     * @IsGranted("ROLE_ADMIN")
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

                $realisation->setIntroImageFilename($newFilename);
            }

            $manager->persist($realisation);
            $manager->flush();

            return $this->redirectToRoute("admin");
        }

        return $this->renderForm('admin/add_realisation.html.twig', [
            "form" => $form
        ]);
    }

    /**
     * @Route("admin/realisation/{id}", name="realisation_admin")
     * @IsGranted("ROLE_ADMIN")
     * @param RealisationRepository $repository
     * @param $id
     * @return Response
     */
    public function details(RealisationRepository $repository, $id): Response
    {
        $realisation = $repository->find($id);

        return $this->render('admin/details.html.twig', [
            'realisation' => $realisation,
        ]);
    }

    /**
     * @Route("admin/realisation/modifier/{id}", name="admin_edit_realisation")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param SluggerInterface $slugger
     * @param RealisationRepository $repository
     * @param $id
     * @return Response
     * @IsGranted("ROLE_ADMIN")
     */
    public function editRealisation(Request $request, EntityManagerInterface $manager, SluggerInterface $slugger, RealisationRepository $repository, $id): Response
    {
        $realisation = $repository->find($id);

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

                $realisation->setIntroImageFilename($newFilename);
            }

            $manager->persist($realisation);
            $manager->flush();

            return $this->redirectToRoute("admin");
        }

        return $this->renderForm('admin/add_realisation.html.twig', [
            "form" => $form
        ]);
    }

    /**
     * @Route("admin/lien/ajout/{realisationId}", name="admin_add_link")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param $realisationId
     * @param RealisationRepository $repository
     * @return Response
     * @IsGranted("ROLE_ADMIN")
     */
    public function addNewLink(Request $request, EntityManagerInterface $manager, $realisationId, RealisationRepository $repository): Response
    {
        $link = new Link();
        $form = $this->createForm(LinkType::class, $link);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $realisation = $repository->find($realisationId);

            $link = $form->getData();

            $realisation->addLink($link);
            $manager->persist($link);
            $manager->flush();

            return $this->redirectToRoute("realisation_admin", ["id" => $realisationId]);
        }

        return $this->renderForm('admin/add_link.html.twig', [
            "form" => $form
        ]);
    }

    /**
     * @Route("admin/screenshot/ajout/{realisationId}", name="admin_add_screenshot")
     * @param Request $request
     * @param EntityManagerInterface $manager
     * @param $realisationId
     * @param RealisationRepository $repository
     * @param SluggerInterface $slugger
     * @return Response
     * @IsGranted("ROLE_ADMIN")
     */
    public function addScreenshot(Request $request, EntityManagerInterface $manager, $realisationId, RealisationRepository $repository, SluggerInterface $slugger): Response
    {
        $screenshot = new Screenshot();
        $form = $this->createForm(ScreenshotType::class, $screenshot);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $realisation = $repository->find($realisationId);

            /** @var Screenshot $screenshot */
            $screenshot = $form->getData();

            $imageFile = $form->get('image')->getData();

            if($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    echo $e;
                }

                $screenshot->setImageFilename($newFilename);
            }

            $realisation->addScreenshot($screenshot);
            $manager->persist($screenshot);
            $manager->flush();

            return $this->redirectToRoute("realisation_admin", ["id" => $realisationId]);
        }

        return $this->renderForm('admin/add_screenshot.html.twig', [
            "form" => $form
        ]);
    }
}
