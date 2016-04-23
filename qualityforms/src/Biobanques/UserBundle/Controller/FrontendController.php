<?php

namespace Biobanques\UserBundle\Controller;

use Biobanques\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sokil\Mongo\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FrontendController extends Controller
{

    /**
     *
     * @return Collection
     */
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
     * @Route("/login",name="login")
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




        return $this->render('UserBundle:forms:loginForm.html.twig', [

                    'last_username' => $lastUsername,
                    'error' => $error,
                    'username' => $this->getUser() != null ? $this->getUser()->username : null
        ]);
    }

    /**
     *
     * @Route("/user/transform",name="transform")
     */
    public function transformAction(Request $request) {

        $encoder = $this->container->get('security.password_encoder');
        $users = $this->getCollection()->find()
        // ->where('username', 'matth')
        ;
        foreach ($users as $dbuser) {
            $user = new User($this->getCollection(), $dbuser->username, $dbuser->password, null, ['ROLE_ADMIN']);
//            foreach($user->attributes as $attributeName=>$attributeValue)

            $oldpassword = $user->password;
            $newpassword = $encoder->encodePassword($user, $oldpassword);

            $dbuser->password = $newpassword;
            $dbuser->roles = ['ROLE_ADMIN'];
            $dbuser->save();
        }
        return new Response($newpassword);
    }

//    /**
//     *
//     * @Route("/logout",name="logout")
//     */
//    public function logoutAction(Request $request) {
//
//    }
}