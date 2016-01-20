<?php

namespace Acme\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

use Acme\SecurityBundle\Form\UserType;
use Acme\SecurityBundle\Entity\User;

class SecurityController extends Controller{
    
    public function loginAction( Request $request, $_controller )
    {

        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'AcmeSecurityBundle:Security:login.html.twig',
            array(
                // last username entered by the user
                'last_username' => $lastUsername,
                'error'         => $error,
                'controller' => $_controller,
            )
        );        
    }
    
    public function registrationAction( Request $request, $_controller )
    {
        // 1) build the form
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            // ... do any other work - like send them an email, etc
            // maybe set a "flash" success message for the user

            return $this->redirectToRoute('acme_store_homepage');
        }

        return $this->render(
            'AcmeSecurityBundle:Security:register.html.twig',
            array('form' => $form->createView(), 'controller' => $_controller,)
        );        
    }
}
