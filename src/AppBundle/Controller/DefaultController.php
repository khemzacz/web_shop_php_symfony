<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 * @Route("/")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("AppBundle:Main:default.html.twig")
     */
    public function indexAction()
    {
        // replace this example code with whatever you need
        return array('Hello World!');
    }

    /**
     * @Route("/bazatest")
     */
    public function createAction()
    {
        // adds Product to database
        $product = new Product();
        $product->setName('crowbar');
        $product->setPrice('333.44');
        $product->setDescription('The Price contains 3 times number 3. Half Life 3 Confirmed. ');

        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();

        return new Response('Created a product with id '.$product->getId());
    }
}
