<?php

namespace App\Controller;

use App\Repository\ContentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ContentRepository $contentRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'contents' => $contentRepository->findBy([
                'page' => 'ACCUEIL'
            ]),
            'carouselItems' => $contentRepository->findBy([
                'page' => 'CAROUSEL'
            ]),
        ]);
    }
}
