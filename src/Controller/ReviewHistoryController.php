<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewHistoryController extends AbstractController
{
    /**
     * @Route("/review/history", name="review_history")
     */
    public function index(): Response
    {
        return $this->render('review_history/index.html.twig', [
            'controller_name' => 'ReviewHistoryController',
        ]);
    }
}
