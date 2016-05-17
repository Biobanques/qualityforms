<?php

namespace Biobanques\UserBundle\Entity;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class WebserviceUserProvider implements UserProviderInterface
{
    protected $container;

    public function loadUserByUsername($username) {
        // make a call to your webservice here
        // $userData =
        // pretend it returns an array on success, false if there is no user
//        global $kernel;
//@codeCoverageIgnoreStart
//        if ('AppCache' == get_class($kernel)) {
//            $kernel = $kernel->getKernel();
//        }
//@codeCoverageIgnoreEnd
//        if ($serviceProvided == null)
//            $service = $kernel->getContainer()->get('mongo');
//        else
//            $service = $serviceProvided;
        $service = $this->container->get('mongo');
        $userData = $service->getCollection('user')->find()->where('username', $username)->findOne();
        $data = [];
        if ($userData) {
            $password = $userData->password;
            $data['password'] = $password;
            $username = $userData->username;
            $data['username'] = $username;
            $salt = $userData->salt;
            $data['salt'] = $salt;
            $roles = $userData->roles;
            $data['roles'] = $roles;
            // ...

            return new User($service->getCollection('user'), $data);
        }

        throw new UsernameNotFoundException(
        sprintf('Username "%s" does not exist.', $username)
        );
    }

    public function refreshUser(UserInterface $user) {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(
            sprintf('Instances of "%s" are not supported.', get_class($user))
            );
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class) {
        return $class === 'Biobanques\UserBundle\Entity\User';
    }

    public function __construct($container) {
        $this->container = $container;
    }

}