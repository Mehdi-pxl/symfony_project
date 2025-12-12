<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class SiteController extends AbstractController
{
    #[Route('/site', name: 'app_site')]
    public function index(): Response
    {
        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
        ]);
    }
    #[Route('/site/home', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('site/home.html.twig', [
            'title' => "bienvenue",
            'age' => 31
        ]);
    }
}
