<?php

namespace Biobanques\UserBundle\Entity;

use Sokil\Mongo\Document;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @codeCoverageIgnore
 */
class User extends Document implements UserInterface, EquatableInterface
{
    private $id;
    private $username;
    private $password;
    private $salt;
    private $roles;

    public function rules() {
        return [
            ['username,password,roles', 'required'],
        ];
    }

    public function getId() {
        return (string) $this->_id;
    }

    public function getPassword() {
        return $this->get('password');
    }

    public function setPassword($password) {

        $this->set('password', $password);
    }

    public function getRoles() {
        return $this->get('roles');
    }

    public function getSalt() {
        return $this->get('salt');
    }

    public function getUsername() {
        return $this->get('username');
    }

    public function eraseCredentials() {

    }

    public function isEqualTo(UserInterface $user) {
//        if (!$user instanceof WebserviceUser) {
//            return false;
//        }
//        if ($this->getPassword() !== $user->getPassword()) {
//            return false;
//        }
        if ($this->getSalt() !== $user->getSalt()) {
            return false;
        }

        if ($this->getUsername() !== $user->getUsername()) {
            return false;
        }

        return true;
    }

}