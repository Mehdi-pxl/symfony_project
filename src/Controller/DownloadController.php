<?php

namespace App\Controller;

use App\Form\CvDownloadFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

final class DownloadController extends AbstractController
{
    #[Route('/download-cv', name: 'app_download_cv')]
    public function form(Request $request): Response
    {
        $form = $this->createForm(CvDownloadFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            $this->addFlash('success', 'Merci ' . $data['prenom'] . ' ! Votre CV va être téléchargé.');
            
            return $this->generatePdf($data);
        }

        return $this->render('cv/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    private function generatePdf(array $data): Response
    {
        $html = $this->renderView('cv/pdf.html.twig', [
            'demandeur' => $data
        ]);

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response(
            $dompdf->output(),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="CV_Mehdi_MOUMITE.pdf"'
            ]
        );
    }
}