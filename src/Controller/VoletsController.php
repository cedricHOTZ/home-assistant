<?php

namespace App\Controller;

use App\Service\HomeAssistantService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class VoletsController extends AbstractController
{
    #[Route('/volets', name: 'volets')]
    public function index(HomeAssistantService $ha): Response
    {
        $volet = $ha->getEntityState('cover.vr_cuisine'); // ton entity_id

        return $this->render('volets/index.html.twig', [
            'volet' => $volet
        ]);
    }

    #[Route('/volets/open', name: 'volets_open')]
    public function open(HomeAssistantService $ha): Response
    {
        $ha->openCover('cover.vr_cuisine');
        return $this->redirectToRoute('volets');
    }

    #[Route('/volets/close', name: 'volets_close')]
    public function close(HomeAssistantService $ha): Response
    {
        $ha->closeCover('cover.vr_cuisine');
        return $this->redirectToRoute('volets');
    }
}
