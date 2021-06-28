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
            // on stock tous les chats qui n'ont pas d'entité review associé
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
    // on décode l'objet javascript du corps de la requête pour l'utiliser avec PHP
    $data = json_decode($request->getContent(), true);
    // on créer un objet Inspection
    $review = new Review();
    // on lie le chat à l'Inspection nouvellement créée
    $review->setCat($cat);
    // on lie le représentant à l'Inspection nouvellement créée
    $review->setValidator($this->getUser());
    // En fonction du booléen validated du json de la requête 
    // on déclare le chat comme approuvé ou refusé dans l'inspection
    $review->setValidated($data['validated']);
    // si un commentaire est présent dans l'objet json
    //  on l'ajoute à l'inspection
    if (array_key_exists('comment',$data)) {
        $review->setComment($data['comment']);
    }
    // on sauvegarde l'inspection en base de données
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($review);
    $entityManager->flush();

    // on construit le mail pour l'utilisateur
    $signature = "<br/><br/>Cordialement,<br/>l'équipe de scratch.";

    if ($data['validated']) {
        $subject = 'Félicitation !';
        $body = "Bonjour, <br/> Votre chat a été approuvé par l'un de nos représentants." . $signature;
    } else {
        $subject = 'Encore un pas à faire';
        $body = "Bonjour, <br/> Malheureusement l'inscription de votre chat n'a pas été approuvée par notre représentant qui a laissé le commentaire suivant : <br/>\"" . $data['comment'] . '"' . $signature;
    }

    // on construit l'email
    $message = (new \Swift_Message($subject))
        ->setFrom('no-reply@les-aristoscratch.fr')
        ->setTo($cat->getOwner()->getEmail())
        ->setBody($body, 'text/html');
        // on envoi l'email
    $mailer->send($message);
    // on envoi la réponse HTTP à l'utilisateur
    $response = new Response(
        '',
        Response::HTTP_OK,
        ['content-type' => 'text/html']
    );
    return $response;
}
}
