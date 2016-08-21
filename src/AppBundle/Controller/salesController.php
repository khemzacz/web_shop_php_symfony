<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Order;
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
     * @Route("/order/{basket}/{userid}", name="orderBasketForUser")
     * @Method("GET")
     */
    public function orderBasketForUser($basket,$user){
        //$repository = $this->getDoctrine()->getRepository('AppBundle:Order');
        //$gb = $repository->createQueryBuilder('o');
        //$gb->insert
        try {
            $em = $this->get('doctrine.orm.entity_manager');//getDoctrine()->getEntityManager();
            $order = new Order();
            $user = $em->find('AppBundle\Entity\User', $user->getId());
            $order->setUser($user);
            $repository = $this->getDoctrine()->getRepository('AppBundle:State');
//            $qb= $repository->createQueryBuilder('s');
//            $qb->select('s')
//                ->where('s.id =:stateid')
//                ->setParameter('stateid', 1);
//            $query = $qb->getQuery();
//            $state= $query -> getResult();
            $state = $em->find('AppBundle\Entity\State',1);
            $order->setState($state);
            $order->setPlacingDate(time());
            foreach ($basket as $product){
               // $order->addProduct($product);
            }
            $em->persist($order);
            $em->flush();

        } catch (Exception $e)
        {
            return new JsonResponse('1');
        }


        return new JsonResponse('0');

    }


}
