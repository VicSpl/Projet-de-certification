<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer): Response
    {
        $message = new Message();
        $form = $this->createForm(ContactType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // on construit l'email
            $email = (new \Swift_Message($message->getSubject()))
            ->setFrom($this->getUser()->getEmail())
            ->setTo('contact@les-aristoscratch.fr')
            ->setBody($message->getContent(), 'text/html');
            // on envoi l'email
            $mailer->send($email);

            return $this->redirectToRoute('home');
        }

        return $this->render('contact/index.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }
}
