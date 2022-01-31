<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('main/home.html.twig', [
            "top" => $this->educationLink(),
            "right" => ["route" => "", "name" => "Expérience", "url" => "/images/form.png"],
            "bottom" => ["route" => "", "name" => "Me contacter", "url" => "/images/form.png"],
            "left" => $this->aboutLink(),
        ]);
    }

    /**
     * @Route("/formation", name="education")
     */
    public function formation(): Response
    {
        return $this->render('main/formation.html.twig', [
            "top" => $this->homeLink(),
            "right" => ["route" => "", "name" => "Expérience", "url" => ""],
            "bottom" => ["route" => "", "name" => "Me contacter", "url" => ""],
            "left" => $this->aboutLink(),
        ]);
    }

    /**
     * @Route("/a-propos-de-moi", name="about")
     */
    public function about(): Response
    {
        return $this->render('main/about.html.twig', [
            "top" => $this->educationLink(),
            "right" => ["route" => "", "name" => "Expérience", "url" => "/images/form.png"],
            "bottom" => ["route" => "", "name" => "Me contacter", "url" => "/images/form.png"],
            "left" => $this->homeLink(),
        ]);
    }

    //variable presets for the cardinal links
    private function homeLink(): array
    {
        return ["route" => $this->generateUrl('home'), "name" => "Accueil", "url" => "/images/sunset.jpg"];
    }

    private function educationLink(): array
    {
        return ["route" => $this->generateUrl('education'), "name" => "Mon parcours", "url" => "/images/form.png"];
    }

    private function aboutLink(): array
    {
        return ["route" => $this->generateUrl('about'), "name" => "À propos de moi", "url" => "/images/about.jpg"];
    }
}
