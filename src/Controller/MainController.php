<?php

namespace App\Controller;

use App\Form\CvDownloadFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MainController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/galerie', name: 'app_galerie')]
    public function galerie(): Response
    {
        return $this->render('home/galerie.html.twig');
    }

    #[Route('/cv', name: 'app_cv')]
    public function cv(): Response
    {
        return $this->render('cv/index.html.twig');
    }

    #[Route('/portfolio', name: 'app_portfolio')]
    public function portfolio(): Response
    {
        return $this->render('portfolio/index.html.twig');
    }

    #[Route('/download-cv', name: 'app_download_cv')]
    public function downloadCv(Request $request): Response
    {
        $form = $this->createForm(CvDownloadFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pdfPath = $this->getParameter('kernel.project_dir') . '/public/documents/CV.pdf';
            
            if (!file_exists($pdfPath)) {
                $this->addFlash('error', 'Le fichier CV n\'a pas été trouvé. Veuillez contacter l\'administrateur.');
                return $this->redirectToRoute('app_download_cv');
            }

            $fileContent = file_get_contents($pdfPath);
            
            $response = new Response($fileContent);
            $response->headers->set('Content-Type', 'application/pdf');
            $response->headers->set('Content-Disposition', 'attachment; filename="CV_Mehdi_MOUMITE.pdf"');
            $response->headers->set('Content-Length', filesize($pdfPath));

            return $response;
        }

        return $this->render('cv/form.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
