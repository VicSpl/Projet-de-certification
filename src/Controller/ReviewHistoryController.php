<?php

namespace App\Controller;

use App\Repository\CatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewHistoryController extends AbstractController
{
    /**
     * @Route("/review/history", name="review_history")
     */
    public function index(CatRepository $catRepository): Response

    {
        $reviews = $this->getUser()->getReviews();

        $cats = [];
        foreach ($reviews as $review) {
            $cats[] = $review->getCat();
        }
        return $this->render('review_history/index.html.twig', [
            'cats' => $cats
        ]);
    }
}
