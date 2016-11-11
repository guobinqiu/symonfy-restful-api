<?php

namespace AppBundle\Controller\api\v2;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Head;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Options;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;

class UsersController extends FOSRestController
{
    //显示所有用户 GET /users
    public function getUsersAction()
    {
        $users = array('a','b','c');
        $view = $this->view($users, 200);
        return $this->handleView($view);
    }

    //显示新建用户的表单 GET /users/new
    public function newUsersAction(){}

    // 新建用户 POST /users
    public function postUsersAction(){}

    //显示指定的用户 GET /users/{id}
    public function getUserAction($id){}

    //显示编辑用户的表单 GET /users/{id}/edit
    public function editUserAction($id){}

    //更新指定的用户 PUT /users/{id}
    public function putUserAction($id){}

    //删除指定的用户 DELETE /users/{id}
    public function deleteUserAction($id){}

    //嵌套路由 GET /users/{id}/comments
    //public function getUserCommentsAction($id){}

    //嵌套路由 GET /users/{uid}/comments/{cid}
    //public function getUserCommentAction($uid, $cid){}

    /**
     * 自定义路由
     *
     * @Post("/users/register")
     */
    public function postUsersRegisterAction(){}
}