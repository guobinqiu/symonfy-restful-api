<?php

namespace AppBundle\Controller\api\v1;

use AppBundle\Entity\User;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations\Delete;
use FOS\RestBundle\Controller\Annotations\Head;
use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\Patch;
use FOS\RestBundle\Controller\Annotations\Options;
use FOS\RestBundle\Controller\Annotations\Post;
use FOS\RestBundle\Controller\Annotations\Put;

class CommentsController extends FOSRestController
{
    //嵌套路由 GET /users/{id}/comments
    public function getCommentsAction($id){}

    //嵌套路由 GET /users/{uid}/comments/{cid}
    public function getCommentAction($uid, $cid){}
}