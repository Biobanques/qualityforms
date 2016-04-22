<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SiteController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request) {
        $collection = '';
        /**
         * @var \Sokil\Mongo\Client Description
         */
        $cli = $this->getCli();
        // $cli->useDatabase('interop');
        // $cli->useDatabase('interop');
        $collection = $cli->getCollection('questionnaire')->find()->findRandom();
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
                    'base_dir' => $collection,
                    'database_name' => $cli->getDatabase()->getName(),
        ]);
    }

    /**
     *
     * @return \Sokil\Mongo\Client
     */
    public function getCli() {
        return $this->get('mongo');
    }

}