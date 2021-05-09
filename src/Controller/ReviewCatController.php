<?php

namespace App\Controller;

use App\Repository\CatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReviewCatController extends AbstractController
{
    /**
     * @Route("/review/cat", name="review_cat")
     */
    public function index(CatRepository $catRepository): Response
    {
        return $this->render('review_cat/index.html.twig', [
            'cats' => $catRepository->findBy([
                'review' => null
            ])
        ]);
    }
}
