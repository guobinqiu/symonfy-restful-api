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
use Symfony\Component\HttpFoundation\Response;

//php bin/console debug:route
//  api_v1_get_user_comments             GET      ANY      ANY    /api/v1/users/{id}/comments.{_format}
//  api_v1_get_user_comment              GET      ANY      ANY    /api/v1/users/{uid}/comments/{cid}.{_format}

class CommentsController extends FOSRestController
{
    //嵌套路由 GET /users/{id}/comments
    public function getCommentsAction($id)
    {
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        $view = $this->view($user->getComments(), Response::HTTP_OK);
        return $this->handleView($view);
    }

    //嵌套路由 GET /users/{uid}/comments/{cid}
    public function getCommentAction($uid, $cid)
    {
        $comment = $this->getDoctrine()->getRepository('AppBundle:Comment')->findOneBy(array(
            'user' => $uid,
            'id' => $cid
        ));
        $view = $this->view($comment, Response::HTTP_OK);
        return $this->handleView($view);
    }
}