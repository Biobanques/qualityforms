<?php

namespace Biobanques\UserBundle\Controller;

use Biobanques\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class FrontendController extends Controller
{

    public function getCollection() {
        return $this->get('mongo')->getCollection('user');
    }

//    /**
//     * @Route("user/index")
//     */
//    public function indexAction() {
//        return $this->render('UserBundle:Default:index.html.twig');
//    }

    /**
     * @Route("/user/login",name="login")
     */
    public function loginAction(Request $request) {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $user = new User($this->getCollection());
        $form = $this->createFormBuilder($user)
                ->setMethod('post')
                ->add('username', TextType::class)
                ->add('password', PasswordType::class)
                ->add('submit', SubmitType::class, ['label' => 'login'])
                ->getForm();
//        return $this->render('UserBundle:forms:loginForm.html.twig', [
//                    'form' => $form->createView(),
//                    'last_username' => $lastUsername,
//                    'error' => $error
//        ]);
        return $this->render('UserBundle:forms:loginForm.html.twig', [

                    'last_username' => $lastUsername,
                    'error' => $error
        ]);
    }

}