<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewCatController extends AbstractController
{
    /**
     * @Route("/review/cat", name="review_cat")
     */
    public function index(): Response
    {
        return $this->render('review_cat/index.html.twig', [
            'controller_name' => 'ReviewCatController',
        ]);
    }
}
