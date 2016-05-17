<?php

use Biobanques\UserBundle\Entity\User;
use Biobanques\UserBundle\Entity\WebserviceUserProvider;
use Sokil\Mongo\Collection;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class WebServiceUserProviderTest extends WebTestCase
{
    private $container;
    /**
     *
     * @var Collection
     */
    private $collection;

    public function setUp() {
        self::bootKernel();
        $this->container = self::$kernel->getContainer();
        $this->collection = $this->container->get('mongo')->getCollection('user');
        $client = static::createClient([], ['HTTP_HOST' => 'qualityform_v2.local']);
        $client->followRedirects(true);
    }

    public function initUserDb() {

        $encoder = $this->container->get('security.password_encoder');

        $user = new User($this->collection);
        $user->setId('testUserId');
        $user->username = 'testUserName';
        $user->password = $encoder->encodePassword($user, 'testUserPassword');
        $user->roles = ['ROLE_ADMIN', 'ROLE_USER'];
        $user->save();
    }

    public function resetUserDb() {
        $user = $this->collection->getDocument('testUserId');
        if ($user != null)
            $user->delete();
    }

    public function testLoadUserByUsername() {
        $this->resetUserDb();
        $this->initUserDb();
        $provider = new WebserviceUserProvider($this->container);

        try {
            $user = $provider->loadUserByUsername('testUserNotExists');
        } catch (Exception $ex) {
            $this->assertInstanceOf('Symfony\Component\Security\Core\Exception\UsernameNotFoundException', $ex);
        }
        $user = $provider->loadUserByUsername('testUserName');
        $this->assertTrue($user instanceof User);
        $this->resetUserDb();
    }

    public function testRefreshUser() {
        $this->resetUserDb();
        $this->initUserDb();
        $provider = new WebserviceUserProvider($this->container);
        $encoder = $this->container->get('security.password_encoder');
        $badUser = new \Symfony\Component\Security\Core\User\User('testUserName', 'testUserPasswordOther');


        try {
            $user = $provider->refreshUser($badUser);
        } catch (Exception $ex) {
            $this->assertInstanceOf('Symfony\Component\Security\Core\Exception\UnsupportedUserException', $ex);
        }

        $goodUser = new User($this->collection);
        $goodUser->setId('testUserOtherId');
        $goodUser->username = 'testUserName';
        $goodUser->password = $encoder->encodePassword($goodUser, 'testUserOtherPassword');
        $goodUser->roles = ['ROLE_ADMIN'];

        $referenceUser = new User($this->collection);
        $referenceUser->setId('testUserId');
        $referenceUser->username = 'testUserName';
        $referenceUser->password = $encoder->encodePassword($referenceUser, 'testUserPassword');
        $referenceUser->roles = ['ROLE_ADMIN', 'ROLE_USER'];
        $newUser = $provider->refreshUser($goodUser);


        $this->assertTrue($referenceUser->isEqualTo($newUser));
    }

    public function testSupportsClass() {

        $provider = new WebserviceUserProvider($this->container);
        $this->assertTrue($provider->supportsClass('Biobanques\UserBundle\Entity\User'));
        $this->assertFalse($provider->supportsClass('An\Other\Class'));
    }

}