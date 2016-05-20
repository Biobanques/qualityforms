<?php

namespace Biobanques\UserBundle\Controller;

use Biobanques\UserBundle\Entity\User;
use DatatableBundle\datatable\DatatableQueries;
use MongoId;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sokil\Mongo\Client;
use Sokil\Mongo\Collection;
use Sokil\Mongo\Document\InvalidDocumentException;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class BackendController extends Controller
{

    /**
     * @codeCoverageIgnore
     * @return Client
     *      */
    public function getClient() {


        $client = $this->get('mongo');
        return $client;
    }

    /**
     * @codeCoverageIgnore
     * @return Collection
     *      */
    public function getCollection() {

        return $this->getClient()->getCollection('user');
    }

    /**
     *
     * @Route("/admin/users/index",name="userIndex")
     */
    public function indexAction(Request $request) {
        $datatable = new stdClass();
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


        $datatable->columns = $columns;
        /*
         * true or false, in string
         */
        $datatable->useRegex = 'true';
        $datatable->table_id = 'usersTable';
        $datatable->ajaxUrl = '/admin/users/getUsers';
        $datatable->crud = ['view' => true, 'update' => true, 'delete' => true];


        return $this->render('UserBundle:Default:index.html.twig', [
                    'datatable' => $datatable
        ]);
    }

    /**
     * Action used for ajax datatable
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

        $collection = $this->getCollection('user');
        $document = $collection->createDocument();

        $user = $this->getCollection()->find()->where('_id', $id)->findOne();
        if (!$user)
            $user = $this->getCollection()->find()->where('_id', new MongoId($id))->findOne();


        $post = $request->request;
        $errors = [];
        if ($post != null && $post->count() != 0) {
            foreach ($post as $attributeKey => $attributeValue) {
                if ($attributeKey != 'password') {
                    if ($attributeValue != '' && $attributeValue != []) {
                        $user->$attributeKey = $attributeValue;
                    } else {
                        $user->unsetField($attributeKey);
                    }
                } else if ($attributeValue != null && $attributeValue != '') {
                    $encoder = $this->container->get('security.password_encoder');
                    $user->$attributeKey = $encoder->encodePassword($user, $attributeValue);
                }
            }try {
                if ($user->save())
                    return $this->redirectToRoute("userView", ['id' => $user->getId()]);
            } catch (InvalidDocumentException $e) {
                $errors = $e->getDocument()->getErrors();
            }
        }
        return $this->render('UserBundle:forms:detailForm.html.twig', [
                    'action' => 'update',
                    'user' => $user,
                    'errors' => $errors
        ]);
    }

    /**
     *
     * @Route("/admin/users/create",name="userCreate")
     */
    public function createAction(Request $request) {
        $user = new User($this->getCollection());
        $post = $request->request;
        $errors = [];
        if ($post != null && $post->count() != 0) {
            foreach ($post as $attributeKey => $attributeValue) {
                if ($attributeKey != 'password')
                    $user->$attributeKey = $attributeValue;
                else if ($attributeValue != null && $attributeValue != '') {
                    $encoder = $this->container->get('security.password_encoder');
                    $user->$attributeKey = $encoder->encodePassword($user, $attributeValue);
                }
            }try {
                if ($user->save())
                    return $this->redirectToRoute("userView", ['id' => $user->getId()]);
            } catch (InvalidDocumentException $e) {
                $errors = $e->getDocument()->getErrors();
            }
        }
        return $this->render('UserBundle:forms:detailForm.html.twig', [
                    'action' => 'create',
                    'user' => $user,
                    'errors' => $errors
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