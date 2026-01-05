<?php

namespace App\Controller;

use App\Form\CvDownloadFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Attribute\Route;

final class DownloadController extends AbstractController
{
    #[Route('/download-cv', name: 'app_download_cv')]
    public function form(Request $request): Response
    {
        $form = $this->createForm(CvDownloadFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            return $this->downloadPdf();
        }

        return $this->render('cv/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function downloadPdf(): Response
    {
        $pdfPath = $this->getParameter('kernel.project_dir') . '/public/documents/CV_Mehdi_MOUMITE.pdf';
        
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
}
