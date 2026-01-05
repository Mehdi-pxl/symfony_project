<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class CvController extends AbstractController
{
    #[Route('/cv', name: 'app_cv')]
    public function cv(): Response
    {
        return $this->render('cv/index.html.twig');
    }

}