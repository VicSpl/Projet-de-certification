<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Form\Message1Type;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/message")
 */
class MessageController extends AbstractController
{
    /**
     * @Route("/recieved", name="recieve_index", methods={"GET"})
     */
    public function index(MessageRepository $messageRepository): Response
    {
        return $this->render('message/index.html.twig', [

            'recieved_messages' => $messageRepository->findBy([
                'recipient' => $this->getUser()
                // "receive"=>$user 
            ]),
        ]);
    }

    /**
     * @Route("/sent", name="sent_index", methods={"GET"})
     */
    public function index_sent(MessageRepository $messageRepository): Response
    {
        return $this->render('message/index.html.twig', [
            'sent_messages' => $messageRepository->findBy([
                'sender' => $this->getUser()
                // "sender"=>$user 
            ]),
        ]);
    }

    /**
     * @Route("/new/{id}", name="message_new", methods={"GET","POST"})
     */
    public function new(Request $request, User $user): Response
    {
        $message = new Message();
        $form = $this->createForm(Message1Type::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($this->getUser());
            $message->setRecipient($user);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('sent_index');
        }

        return $this->render('message/new.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="message_show", methods={"GET"})
     */
    public function show(Message $message): Response
    {
        return $this->render('message/show.html.twig', [
            'message' => $message,
        ]);
    }


    /**
     * @Route("/{id}", name="message_delete", methods={"POST"})
     */
    public function delete(Request $request, Message $message): Response
    {
        if ($this->isCsrfTokenValid('delete' . $message->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sent_index');
    }
}
