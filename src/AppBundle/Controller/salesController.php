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
 * Class SalesController
 * @Route("/sales")
 * @package AppBundle\Controller
 */
class SalesController extends Controller
{
    /**
     * @Route("/order/{basket}/{userid}/{secret}", name="orderBasketForUser")
     * @Method("GET")
     */
    public function orderBasketForUser($basket,$userid,$secret){
        try {
            if ($userid == ''){
                return new JsonResponse('2');
            }
            if ($basket == ''){
                return new JsonResponse('3');
            }
            $em = $this->get('doctrine.orm.entity_manager');//getDoctrine()->getEntityManager();
            $user = $em->find('AppBundle\Entity\User', $userid);
            if ($secret != $user->getSecret()) {
                return new JsonResponse('4'); //unathorized
            }

            $order = new Order;
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
