<?php

namespace Biobanques\UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sokil\Mongo\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FrontendController extends Controller
{

    /**
     * @codeCoverageIgnore
     * @return Collection
     */
    public function getCollection() {

        return $this->get('mongo')->getCollection('user');
    }

    /**
     * @Route("/login",name="login")
     */
    public function loginAction(Request $request) {
        $authenticationUtils = $this->get('security.authentication_utils');

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        //  $user = new User($this->getCollection());

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
//    public function transformAction(Request $request) {
//
//        $encoder = $this->container->get('security.password_encoder');
//        $users = $this->getCollection()->find()
//        // ->where('username', 'matth')
//        ;
//        $i = 0;
//        foreach ($users as $dbuser) {
//            $i++;
//            $user = new User($this->getCollection(), $dbuser->username, $dbuser->password, null, []);
////            foreach($user->attributes as $attributeName=>$attributeValue)
//            $dbuser->roles = ['ROLE_USER'];
//            $oldpassword = $dbuser->password;
//            $newpassword = $encoder->encodePassword($user, $oldpassword);
//            $dbuser->clearPassword = $oldpassword;
//            $dbuser->password = $newpassword;
//            if ($i % 37 == 4)
//                $dbuser->roles = ['ROLE_USER', 'ROLE_ADMIN'];
//
//
//            $dbuser->save();
//        }
//        // return new Response($newpassword);
//    }
//    /**
//     *
//     * @Route("/logout",name="logout")
//     */
//    public function logoutAction(Request $request) {
//
//    }
}