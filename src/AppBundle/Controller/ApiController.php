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
     * Get a piece of the stored VDM posts
     * Each call get a page of 100 VDM posts maximum
     * For more data, iterate over the pages
     *
     * @Route("/posts/{pageNumber}", name="api_posts", requirements={"_method"="GET", "pageNumber"="[1-9][0-9]*"})
     *
     * @param  integer $pageNumber The optional page number (starting at 1)
     * @return JsonResponse        The asked page of data (100/page max) in JSON format
     *                             Returns "304 No Content" when there is no data in the page
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
     * Get a specific VDM post
     *
     * @Route("/post/{postId}", name="api_post", requirements={"_method"="GET", "postId"="[1-9][0-9]*"})
     *
     * @param  integer $postId The id of the wanted VDM post
     * @return JsonResponse    The asked VDM post in JSON format
     *                         Returns "404 Not Found" when no corresponding data is found
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
            $response->setStatusCode(JsonResponse::HTTP_NOT_FOUND);
        }

        return $response;
    }
}
