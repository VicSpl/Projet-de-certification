<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(): Response
    {
        // write message in database
        // ...

        // send mail to all admin
        // $message = (new \Swift_Message('Bienvenu chez nous !'))
        //     ->setFrom($user->getEmail())
        //     ->setTo(.....) -----> all email address admin role
        //     ->setBody(....., 'text/html'); -------> message of textarea
        // $mailer->send($message);

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}
