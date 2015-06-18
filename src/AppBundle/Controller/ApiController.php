<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api/v1")
 */
class ApiController extends Controller
{
    /**
     * @Route("/posts/{pageNumber}", name="api_posts", requirements={"_method"="GET", "pageNumber"="[1-9][0-9]*"})
     */
    public function getPostsAction($pageNumber = 1)
    {
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findByPage($pageNumber);

        $response = new JsonResponse();

        if($posts) {
            $response->setData($posts);
        } else {
            $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        }

        return $response;
    }

    /**
     * @Route("/post/{postId}", name="api_post", requirements={"_method"="GET", "postId"="[1-9][0-9]*"})
     */
    public function getPostAction($postId)
    {
        $post = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->find($postId);

        $response = new JsonResponse();

        if($post) {
            $response->setData($post);
        } else {
            $response->setStatusCode(JsonResponse::HTTP_NO_CONTENT);
        }

        return $response;
    }
}
