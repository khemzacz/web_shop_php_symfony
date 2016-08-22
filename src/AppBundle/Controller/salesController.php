<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Entity\Order;
use AppBundle\Entity\OrderProducts;
use Symfony\Component\Validator\Constraints\DateTime;
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
    public function orderBasketForUser($basket,$userid){
        try {
            $em = $this->get('doctrine.orm.entity_manager');//getDoctrine()->getEntityManager();
            $order = new Order;
            $user = $em->find('AppBundle\Entity\User', $userid);
            $order->setUser($user);
            $state = $em->find('AppBundle\Entity\State',1);
            $order->setState($state);
            $order->setPlacingDate(new \DateTime());

            $em->persist($order);
            $em->flush();
            $basket = json_decode($basket);

            foreach ($basket as $product){
                $order_products = new OrderProducts();
                $order_products->setOrder($order);
                $product_entity = $em->find('AppBundle\Entity\Product',$product->id);
                $order_products->setProduct($product_entity); // probably will need to get product with repository
                $order_products->setNumber($product->ilosc); // probably will need to take amount from $product
                $em->persist($order_products);
                $em->flush();
            }

        } catch (Exception $e)
        {
            return new JsonResponse('1');
        }


        return new JsonResponse('0');

    }


}
