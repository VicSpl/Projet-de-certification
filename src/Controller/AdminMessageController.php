<?php

namespace App\Controller;

use App\Entity\Message;
use App\Form\MessageType;
use App\Repository\MessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/message")
 */
class AdminMessageController extends AbstractController
{
    /**
     * @Route("/", name="admin_message_index", methods={"GET"})
     */
    public function index(MessageRepository $messageRepository): Response
    {
        return $this->render('admin_message/index.html.twig', [
            'messages' => $messageRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_message_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $message = new Message();
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('admin_message_index');
        }

        return $this->render('admin_message/new.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_message_show", methods={"GET"})
     */
    public function show(Message $message): Response
    {
        return $this->render('admin_message/show.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_message_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Message $message): Response
    {
        $form = $this->createForm(MessageType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_message_index');
        }

        return $this->render('admin_message/edit.html.twig', [
            'message' => $message,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_message_delete", methods={"POST"})
     */
    public function delete(Request $request, Message $message): Response
    {
        if ($this->isCsrfTokenValid('delete'.$message->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($message);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_message_index');
    }
}
