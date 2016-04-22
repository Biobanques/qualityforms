<?php

namespace Biobanques\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \Biobanques\UserBundle\Entity\User;

class BackendController extends Controller
{
    private $collection;
//    public function __construct() {
//        $this->collection = $this->get('mongo')->getCollection('user');
//    }

    /**
     *
     * @return \MongoCollection
     */
    public function getCollection() {
        return $this->get('mongo')->getCollection('user');
    }

    /**
     *
     * @param type $username
     * @return boolean|array
     */
    public function getByUsername($username) {

        $result = $this->getCollection()->findOne(['username' => $username]);
        if ($result != null)
            return $result;
        return false;
    }

}