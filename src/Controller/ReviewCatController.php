<?php

namespace App\Controller;

use App\Entity\Cat;
use App\Entity\Review;
use App\Repository\CatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
    /**
     * @Route("/review/cat/{id}", name="review_cat_new", methods={"POST"})
     */
    public function new(Request $request, Cat $cat, \Swift_Mailer $mailer): Response
    {
        $data = json_decode($request->getContent(), true);
        $review = new Review();
        $review->setCat($cat);
        $review->setValidator($this->getUser());
        $review->setValidated($data['validated']);
        if (array_key_exists('comment',$data)) {

            $review->setComment($data['comment']);
        }
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($review);
        $entityManager->flush();

        $signature = "<br/><br/>Cordialement,<br/>l'équipe de scratch.";

        if ($data['validated']) {
            $subject = 'Félicitation !';
            $body = "Bonjour, <br/> Votre chat a été approuvé par l'un de nos représentant." . $signature;
        } else {
            $subject = 'Encore un pas à faire';
            $body = "Bonjour, <br/> Malheureursement l'inscription de votre chat n'a pas été approuvé par notre représentant qui a laissé le commentaire suivant : <br/>\"" . $data['comment'] . '"' . $signature;
        }

        $message = (new \Swift_Message($subject))
            ->setFrom('no-reply@les-aristoscratch.fr')
            ->setTo($cat->getOwner()->getEmail())
            ->setBody($body, 'text/html');
        $mailer->send($message);
        $response = new Response(
            '',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );
        return $response;
    }
}
