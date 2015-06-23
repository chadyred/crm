<?php

namespace AppBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

class Render {

    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container) {
        $this->container  = $container;
    }

    /**
     * @param bool $success
     * @param string $content
     * @param array $message
     * @return Response
     */
    public function render ($content, $success = true, $message = array()) {

        if($this->container->get('request')->isXmlHttpRequest())
            $response = new Response(json_encode(array(
                'success'   => $success,
                'content'   => $content,
                'message'   => $message,
                'url'       => $this->container->get('request')->getRequestUri(),
            )), 200, array('Content-Type' => 'application/json'));
        else {
            $response = new Response($content);
        }

        return $response;
    }

}