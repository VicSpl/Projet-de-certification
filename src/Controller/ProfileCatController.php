<?php

namespace App\Controller;

use App\Entity\Cat;
use App\Entity\Document;
use App\Form\Cat1Type;
use App\Repository\CatRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/profile/cat")
 */
class ProfileCatController extends AbstractController
{
    /**
     * @Route("/", name="profile_cat_index", methods={"GET"})
     */
    public function index(CatRepository $catRepository): Response
    {
        return $this->render('profile_cat/index.html.twig', [
            'cats' => $catRepository->findBy([
                'review' => !null
            ])
        ]);
    }

    /**
     * @Route("/new", name="profile_cat_new", methods={"GET","POST"})
     */
    public function new(Request $request, FileUploader $fileUploader): Response
    {
        $cat = new Cat();
        $cat->setOwner($this->getUser());
        $form = $this->createForm(Cat1Type::class, $cat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $documentFile = $form->get('genealogyFile')->getData();
            if ($documentFile) {
                $documentFilename = $fileUploader->upload($documentFile);
                $cat->setGenealogyFile($documentFilename);
            }

            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFilename = $fileUploader->upload($imageFile);
                $cat->setImageFilename($imageFilename);
            }
            $entityManager->persist($cat);
            $entityManager->flush();

            return $this->redirectToRoute('profile_cat_index');
        }

        return $this->render('profile_cat/new.html.twig', [
            'cat' => $cat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="profile_cat_show", methods={"GET"})
     */
    public function show(Cat $cat): Response
    {
        return $this->render('profile_cat/show.html.twig', [
            'cat' => $cat,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="profile_cat_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Cat $cat): Response
    {
        $form = $this->createForm(Cat1Type::class, $cat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image')->getData();
            if ($imageFile) {
                $imageFilename = $fileUploader->upload($imageFile);
                $cat->setImageFilename($imageFilename);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile_cat_index');
        }

        return $this->render('profile_cat/edit.html.twig', [
            'cat' => $cat,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="profile_cat_delete", methods={"POST"})
     */
    public function delete(Request $request, Cat $cat): Response
    {
        if ($this->isCsrfTokenValid('delete' . $cat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($cat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('profile_cat_index');
    }
}
