<?php

namespace App\Controller;

use App\Entity\Cat;
use App\Form\CatType;
use App\Repository\CatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/cat")
 */
class AdminCatController extends AbstractController
{
    /**
     * @Route("/", name="admin_cat_index", methods={"GET"})
     */
    public function index(CatRepository $catRepository): Response
    {
        return $this->render('admin_cat/index.html.twig', [
            'cats' => $catRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_cat_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $cat = new Cat();
        $form = $this->createForm(CatType::class, $cat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($cat);
            $entityManager->flush();

            return $this->redirectToRoute('admin_cat_index');
        }

        return $this->render('admin_cat/new.html.twig', [
            'cat' => $cat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_cat_show", methods={"GET"})
     */
    public function show(Cat $cat): Response
    {
        return $this->render('admin_cat/show.html.twig', [
            'cat' => $cat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_cat_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cat $cat): Response
    {
        $form = $this->createForm(CatType::class, $cat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_cat_index');
        }

        return $this->render('admin_cat/edit.html.twig', [
            'cat' => $cat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admin_cat_delete", methods={"POST"})
     */
    public function delete(Request $request, Cat $cat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_cat_index');
    }
}
