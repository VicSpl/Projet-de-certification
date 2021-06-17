<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordFormType;
use App\Form\User1Type;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/", name="profile_show", methods={"GET"})
     */
    public function show(): Response
    {
        $user = $this->getUser();
        return $this->render('profile/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/edit", name="profile_edit", methods={"GET","POST"})
     */
    public function edit(Request $request): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile_show');
        }

        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/password", name="profile_update_password", methods={"GET","POST"})
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {

        // The token is valid; allow the user to change their password.
        $form = $this->createForm(ChangePasswordFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            // Encode the plain password, and set it.
            $encodedPassword = $passwordEncoder->encodePassword(
                $user,
                $form->get('plainPassword')->getData()
            );

            $user->setPassword($encodedPassword);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile_show');
        }

        return $this->render('reset_password/reset.html.twig', [
            'title' => 'Modifier votre mot de passe',
            'updateForm' => $form->createView(),
        ]);
    }


    // /**
    //  * @Route("/", name="profile_delete", methods={"POST"})
    //  */
    // public function delete(Request $request): Response
    // {
    //     $user = $this->getUser();
    //     if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
    //         $entityManager = $this->getDoctrine()->getManager();
    //         $entityManager->remove($user);
    //         $entityManager->flush();
    //     }

    //     return $this->redirectToRoute('app_login');
    // }
}
