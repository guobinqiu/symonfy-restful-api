<?php

namespace AppBundle\Controller\api\v1;

use AppBundle\Entity\Comment;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Head;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Options;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;
use Symfony\Component\Console\Command\Command;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

//php bin/console debug:route
//  api_v1_get_users                     GET      ANY      ANY    /api/v1/users.{_format}
//  api_v1_new_users                     GET      ANY      ANY    /api/v1/users/new.{_format}
//  api_v1_post_users                    POST     ANY      ANY    /api/v1/users.{_format}
//  api_v1_get_user                      GET      ANY      ANY    /api/v1/users/{id}.{_format}
//  api_v1_edit_user                     GET      ANY      ANY    /api/v1/users/{id}/edit.{_format}
//  api_v1_put_user                      PUT      ANY      ANY    /api/v1/users/{id}.{_format}
//  api_v1_delete_user                   DELETE   ANY      ANY    /api/v1/users/{id}.{_format}
//  api_v1_post_users_register           POST     ANY      ANY    /api/v1/users/register.{_format}

//http://blog.igevin.info/posts/restful-api-get-started-to-write/
class UsersController extends FOSRestController
{
    //YXBpOmRhdGFzcHJpbmc: base64_encode('api:dataspring')
    //显示所有用户 GET /users
    //curl -X GET -H 'Authorization: Basic YXBpOmRhdGFzcHJpbmc=' -H 'Content-Type: application/json' -i 'http://localhost:8000/api/v1/users'
    public function getUsersAction()
    {
//        $users = $this->getDoctrine()->getRepository('AppBundle:User')->findAll();
//        or
//        $users = $this->getDoctrine()->getRepository('AppBundle:User')->getUsersWithComments();
//        or
        $users = $this->getDoctrine()->getRepository('AppBundle:User')->getUsersWithComments2();

//        foreach ($users as $user) {
//            foreach ($user->getComments() as $comment) {
//                echo $comment->getContent();
//            }
//        }

        $view = $this->view($users, Response::HTTP_OK);

        //兼容html请求头
        $view->setTemplate("AppBundle:Users:getUsers.html.twig");
        $view->setTemplateVar('users');

        return $this->handleView($view);
    }

    //显示新建用户的表单 GET /users/new
    public function newUsersAction(){
        $form = $this->createForm('AppBundle\Form\UserType');

        $view = $this->view($form);
        $view->setTemplate("AppBundle:Users:new.html.twig");
        $view->setTemplateVar('form');

        return $this->handleView($view);
    }

    // 新建用户 POST /users
    // json submission
    //curl -X POST -H 'Authorization: Basic YXBpOmRhdGFzcHJpbmc=' -H 'Content-Type: application/json' -d '{"user": {"name": "Guobin", "age": 10}}' -i http://localhost:8000/api/v1/users

    // form submission
    //curl -X POST -H 'Authorization: Basic YXBpOmRhdGFzcHJpbmc=' -H 'Content-Type: application/x-www-form-urlencoded' -d 'user[name]=Guobin' -d 'user[age]=10' -i http://localhost:8000/api/v1/users
    //or
    //curl -X POST -H 'Authorization: Basic YXBpOmRhdGFzcHJpbmc=' -d 'user[name]=Guobin&user[age]=10' -i http://localhost:8000/api/v1/users
    //Try error: curl -H 'Authorization: Basic YXBpOmRhdGFzcHJpbmc=' -d 'user[name]=Guobin&user[age]=101' -i http://localhost:8000/api/v1/users
    public function postUsersAction(Request $request){
        $user = new User();
        $form = $this->createForm('AppBundle\Form\UserType', $user);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $view = $this->view($user, Response::HTTP_CREATED);
        } else {
            $view = $this->view($form->getErrors(), Response::HTTP_BAD_REQUEST);
        }
        return $this->handleView($view);
    }

    //显示指定的用户 GET /users/{id}
    public function getUserAction($id){
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);

        $view = $this->view($user, Response::HTTP_OK);
        return $this->handleView($view);
    }

    //显示编辑用户的表单 GET /users/{id}/edit
    public function editUserAction($id){
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);

        if ($user == null) {
            $view = $this->view(null, Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }

        $form = $this->createForm('AppBundle\Form\UserType', $user);

        $view = $this->view($form);
        $view->setTemplate("AppBundle:Users:edit.html.twig");
        $view->setTemplateVar('form');
        $view->setTemplateData(array('user' => $user));

        return $this->handleView($view);
    }

    //更新指定的用户 PUT /users/{id}
    //curl -X PUT -H 'Authorization: Basic YXBpOmRhdGFzcHJpbmc=' -H 'Content-Type: application/x-www-form-urlencoded' -d 'user[name]=a' -d 'user[age]=10' -i http://localhost:8000/api/v1/users/1
    public function putUserAction(Request $request, $id){
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);

        if ($user == null) {
            $view = $this->view(null, Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }

        $form = $this->createForm('AppBundle\Form\UserType', $user, array('method' => 'PUT'));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $view = $this->view($user, Response::HTTP_OK);
        } else {
            $view = $this->view($form->getErrors(), Response::HTTP_BAD_REQUEST);
        }

        return $this->handleView($view);
    }

    //删除指定的用户 DELETE /users/{id}
    //curl -X DELETE -H 'Authorization: Basic YXBpOmRhdGFzcHJpbmc=' -I http://localhost:8000/api/v1/users/4
    public function deleteUserAction($id){
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);

        if ($user == null) {
//            throw $this->createNotFoundException('User id does not exist.');
            $view = $this->view(null, Response::HTTP_NOT_FOUND);
            return $this->handleView($view);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        $view = $this->view(null, Response::HTTP_NO_CONTENT);
        return $this->handleView($view);
    }

    //嵌套路由 GET /users/{id}/comments
    //public function getUserCommentsAction($id){}

    //嵌套路由 GET /users/{uid}/comments/{cid}
    //public function getUserCommentAction($uid, $cid){}
}
