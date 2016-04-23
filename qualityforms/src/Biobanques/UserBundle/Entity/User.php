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

class User extends Document implements UserInterface, EquatableInterface
{
    private $username;
    private $password;
    private $salt;
    private $roles;

    public function __construct($collection = null, $username = null, $password = null, $salt = null, array $roles = [], $options = []) {
        if ($collection == null)
            $collection = Yii::$app->db->getCollection('user');
        $data = ['username' => $username,
            'password' => $password,
            'salt' => $salt,
            'roles' => $roles];

        parent::__construct($collection, $data, $options);

        /*
         * use to fetch/save data
         */
//        $this->set('username', $username);
//        $this->set('password', $password);
//        $this->set('salt', $salt);
//        $this->set('roles', $roles);
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
        if (!$user instanceof WebserviceUser) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->salt !== $user->getSalt()) {
            return false;
        }

        if ($this->username !== $user->getUsername()) {
            return false;
        }

        return true;
    }

}