<?php

namespace App\Controller;

use App\Repository\ContentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    /**
     * @Route("/about", name="about")
     */
    public function index(ContentRepository $contentRepository): Response
    {
        return $this->render('about/index.html.twig', [
            // retourne la page et son contenu pour écrire la page à propos
            'content' => $contentRepository->findOneBy([
                'page' => 'A_PROPOS'
            ]),
        ]);
    }
}
