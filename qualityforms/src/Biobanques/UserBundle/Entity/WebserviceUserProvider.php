<?php

namespace Biobanques\UserBundle\Entity;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

class WebserviceUserProvider implements UserProviderInterface
{

    public function loadUserByUsername($username) {
        // make a call to your webservice here
        // $userData =
        // pretend it returns an array on success, false if there is no user
        global $kernel;

        if ('AppCache' == get_class($kernel)) {
            $kernel = $kernel->getKernel();
        }

        $service = $kernel->getContainer()->get('mongo');
        $userData = $service->getCollection('user')->find()->where('username', $username)->findOne();
        //$kernel->
        if ($userData) {
            $password = $userData->password;
            $username = $userData->username;
            $salt = $userData->salt;
            $roles = $userData->roles;

            // ...

            return new User($service->getCollection('user'), $username, $password, $salt, $roles);
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

}