<?php

namespace App\Controller;

use App\Entity\Document;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\LoginFormAuthenticator;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, FileUploader $fileUploader, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator, \Swift_Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $documentFile = $form->get('licenceJudge')->getData();
            if ($documentFile) {
                $user->setRoles(["ROLE_VALIDATOR"]);
                $documentFilename = $fileUploader->upload($documentFile);
                $document = new Document();
                $document->setTitle($documentFilename);
                $document->setUser($user);
            }

            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            if ($documentFile) {

                $entityManager->persist($document);
                $entityManager->flush();
            }
            // do anything else you need here, like send an email

            $message = (new \Swift_Message('Bienvenu chez nous !'))
                ->setFrom('no-reply@les-aristoscratch.fr')
                ->setTo($user->getEmail())
                ->setBody('Bonjour, <br/> je vous souhaites la bienvenue sur mon site ! ', 'text/html');
            $mailer->send($message);

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
