<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


/**
 * Class salesController
 * @Route("/sales")
 * @package AppBundle\Controller
 */
class salesController extends Controller
{
    /**
     * @Route("/order/{basket}/{user}", name="orderBasketForUser")
     * @Method("GET")
     */
    public function orderBasketForUser(){
        //$repository = $this->getDoctrine()->getRepository('AppBundle:Order');
        //$gb = $repository->createQueryBuilder('o');
        //$gb->insert
        $em = $this->get('doctrine.orm.entity_manager');//getDoctrine()->getEntityManager();


    }


}
