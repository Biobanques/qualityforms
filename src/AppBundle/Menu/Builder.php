<?php

namespace AppBundle\Menu;

use Biobanques\UserBundle\Entity\User;
use Knp\Menu\FactoryInterface;
use LogicException;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{

    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options) {
        $menu = $factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav');

        $menu->addChild('Home', array('route' => 'homepage'))
                ->setAttribute('icon', 'glyphicon glyphicon-home');
        // access services from the container!
        //$em = $this->container->get('doctrine')->getManager();
        // findMostRecent and Blog are just imaginary examples
        // $blog = $em->getRepository('AppBundle:Blog')->findMostRecent();
        if ($this->getUser() == null) {
            $menu->addChild('login', array(
                'route' => 'login',
                    // 'routeParameters' => array('id' => $blog->getId())
            ));
        } else {

//            $menu->addChild('Manage users', ['route' => 'userIndex']);
            $menu->addChild('ManageUsers', ['label' => 'Manage users'])->setAttribute('dropdown', true)->setAttribute('icon', 'fa fa-list');
            $menu['ManageUsers']->addChild('Manage existing users', ['route' => 'userIndex']);
            $menu['ManageUsers']->addChild('Create new user', ['route' => 'userCreate']);
//            $menu['users']->addChild('Manage existing users', ['route' => 'userIndex']);
//            $menu['users']->addChild('Create a new user', ['route' => 'userCreate']);
            $menu->addChild("logout (" . $this->getUser()->username . ")", array(
                'route' => 'logout',
                    // 'routeParameters' => array('id' => $blog->getId())
            ));
        }
        // create another menu item
        // $menu->addChild('About Me', array('route' => 'about'));
        // you can also add sub level's to your menu's as follows
        //$menu['About Me']->addChild('Edit profile', array('route' => 'edit_profile'));
        // ... add more children

        return $menu;
    }

    /**
     *
     * @return User
     * @throws LogicException
     */
    protected function getUser() {
        if (!$this->container->has('security.token_storage')) {
            throw new LogicException('The SecurityBundle is not registered in your application.');
        }

        if (null === $token = $this->container->get('security.token_storage')->getToken()) {
            return;
        }

        if (!is_object($user = $token->getUser())) {
            // e.g. anonymous authentication
            return;
        }

        return $user;
    }

}