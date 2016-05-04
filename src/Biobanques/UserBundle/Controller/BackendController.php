<?php

namespace Biobanques\UserBundle\Controller;

use DatatableBundle\datatable\DatatableQueries;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sokil\Mongo\Collection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BackendController extends Controller
{

    /**
     *
     * @return Collection
     *      */
    public function getCollection() {
        /*
         * Map to custom user class.
         * TODO : upgrade sokil bundle to load map parameters, and do map in yml settings files.
         */

        $this->get('mongo')->map(['qualityformsdb' => ['user' => ['documentClass' => '\Biobanques\UserBundle\Entity\User']]]);
        /*
         *
         */
        return $this->get('mongo')->getCollection('user');
    }

    /**
     *
     * @Route("/admin/users/index",name="userIndex")
     */
    public function indexAction(Request $request) {

        $columns = [];
        $columns[] = ['data' => '_id'];
        $columns[] = ['data' => 'username', 'searchable' => true, 'orderable' => true,];


        $columns[] = [
            //  "className" => 'glyphicon glyphicon-edit ',
            "orderable" => false,
            'title' => 'Manage',
            "data" => '_id',
            "defaultContent" => ''
        ];
        $headersList = '';
        return $this->render('UserBundle:Default:index.html.twig', [
                    'table_id' => 'usersTable',
                    'ajaxUrl' => '/admin/users/getUsers',
                    'columns' => $columns,
        ]);
    }

    /**
     *
     * @Route("/admin/users/getUsers",name="getUsers")
     */
    public function getUsersAction(Request $request) {
        $query = new DatatableQueries($this->getCollection(), $request->request->getIterator());
        $result = $query->getData();
        return JsonResponse::create($result);
    }

    /**
     *
     * @Route("/admin/users/{id}/view",name="userView")
     */
    public function viewAction(Request $request, $id) {
        $user = $this->getCollection()->getDocument($id);
        return $this->render('UserBundle:forms:detailForm.html.twig', [
                    'action' => 'view',
                    'user' => $user,
        ]);
    }

    /**
     *
     * @Route("/admin/users/{id}/update",name="userUpdate")
     */
    public function updateAction(Request $request, $id) {
        $user = $this->getCollection()->getDocument($id);
        $post = $request->request;
        foreach ($post as $attributeKey => $attributeValue) {
            $user->$attributeKey = $attributeValue;
        }
        $user->save();
        return $this->render('UserBundle:forms:detailForm.html.twig', [
                    'action' => 'update',
                    'user' => $user,
        ]);
    }

    /**
     *
     * @Route("/admin/users/create",name="userCreate")
     */
    public function createAction(Request $request) {
        $user = new \Biobanques\UserBundle\Entity\User($this->getCollection());
        $post = $request->request;
        foreach ($post as $attributeKey => $attributeValue) {
            if ($attributeKey != 'password')
                $user->$attributeKey = $attributeValue;
            else if ($attributeValue != null && $attributeValue != '') {
                $encoder = $this->container->get('security.password_encoder');
                $user->$attributeKey = $encoder->encodePassword($user, $attributeValue);
            }
        }
        $user->save();
        return $this->render('UserBundle:forms:detailForm.html.twig', [
                    'action' => 'create',
                    'user' => $user,
        ]);
    }

    /**
     *
     * @Route("/admin/users/{id}/delete",name="userDelete")
     */
    public function deleteAction(Request $request, $id) {
        $user = $this->getCollection()->getDocument($id);
        $user->delete();
        return $this->redirectToRoute('userIndex');
    }

}