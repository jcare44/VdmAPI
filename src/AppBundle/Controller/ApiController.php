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
    public function messagesAction($pageNumber = 1)
    {
        $posts = $this->getDoctrine()
            ->getRepository('AppBundle:Post')
            ->findByPage($pageNumber);

        $response = new JsonResponse();
        $response->setData($posts);
        return $response;
    }
}
