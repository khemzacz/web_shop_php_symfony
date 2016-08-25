<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * Class searchMainCategoriesController
 * @Route("/search")
 * @package AppBundle\Controller
 */
class searchMainCategoriesController extends Controller
{

    /**
     * @Route("/getMainCategories", name="getMainCategories")
     *
     */
    public function getMainCategories(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $qb= $repository->createQueryBuilder('c');
        $qb->select('c')
            ->where('c.upper_category is NULL');
        $query = $qb->getQuery();


        $categories = $query -> getResult();
        $categoriesArray = array();

        $i=0;

        foreach($categories as $category) {
            $categoriesArray[$i]['nazwaKategorii'] = $category->getName();
            $categoriesArray[$i]['idKategorii'] = $category->getId();
            $i++;
        }
        return new JsonResponse(array('categories' =>$categoriesArray));
    }

    /**
     * @Route("/getRecursivelySubCategoriesById/{id}", name="getSubCategoriesById")
     * @Method("GET")
     */
    public function getRecursivelySubCategoriesById($id)
    {
        if ($id == null)
            return null;
        //$id = $request->get('id'); // Tu będzie wyszukiwanie po IDkach

        $repository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $qb= $repository->createQueryBuilder('c');
        $qb->select('c')
            ->where('c.upper_category = :upper')
            ->setParameter('upper', $id);
        $query = $qb->getQuery();


        $categories = $query -> getResult();
        $categoriesArray = array();

        $i=0;

        foreach($categories as $category) {
            $categoriesArray[$i]['nazwaKategorii'] = $category->getName();
            $categoriesArray[$i]['idKategorii'] = $category->getId();
            //if ($category->getSubcategories != null)
                $categoriesArray[$i]['podKategorie'] = $this->getRecursivelySubCategoriesById($category->getId());
            $categoriesArray[$i]['show'] = false;
            $i++;
        }
        return $categoriesArray;
    }


    /**
     * @Route("/getSubCategoriesById/{id}", name="getSubCategoriesById")
     * @Method("GET")
     */
    public function getSubCategoriesById($id)
    {
        if ($id == null)
            return null;
        //$id = $request->get('id'); // Tu będzie wyszukiwanie po IDkach

        $repository = $this->getDoctrine()->getRepository('AppBundle:Category');

        $qb= $repository->createQueryBuilder('c');
        $qb->select('c')
            ->where('c.upper_category = :upper')
            ->setParameter('upper', $id);
        $query = $qb->getQuery();


        $categories = $query -> getResult();
        $categoriesArray = array();

        $i=0;

        foreach($categories as $category) {
            $categoriesArray[$i]['nazwaKategorii'] = $category->getName();
            $categoriesArray[$i]['idKategorii'] = $category->getId();
            $i++;
        }
        return $categoriesArray;
    }


    /**
     * @Route("/getCategoriesTree", name="getCategoriesTree")
     * @Method("GET")
     */
    public function getCategoriesTree(Request $request) {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Category');
        $qb= $repository->createQueryBuilder('c');
        $qb->select('c')
            ->where('c.upper_category is NULL');
        $query = $qb->getQuery();


        $categories = $query -> getResult();
        $mainCategoriesArray = array();
        $i=0;

        foreach($categories as $category) {
            $mainCategoriesArray[$i]['nazwaKategorii'] = $category->getName();
            $mainCategoriesArray[$i]['idKategorii'] = $category->getId();
            $mainCategoriesArray[$i]['podKategorie'] = $this->getRecursivelySubCategoriesById($category->getId()); //
            $i++;
        }

        return new JsonResponse(array('mainCategories' =>$mainCategoriesArray));

    }
    /**
     * @Route("/getProductsByCategory/{id}", name="getProductsByCategory")
     * @Method("GET")
     */
    public function getProductsByCategory($id){
        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');
        $qb= $repository->createQueryBuilder('c');
        $qb->select('c')
            ->where('c.category =:categoryid')
            ->setParameter('categoryid', $id);
        $query = $qb->getQuery();
        $products= $query -> getResult();
        $productsArray = array();
        $i = 0;

        foreach($products as $product){
            $productsArray[$i]['id'] = $product->getId();
            $productsArray[$i]['nazwa'] = $product->getName();
            $productsArray[$i]['cena'] = $product->getPrice();
            $productsArray[$i]['dostepnosc'] = $product->getAmount();


            $i++;
        }

        return new JsonResponse(array('products' =>$productsArray));
    }

    /**
     * @Route("/getProductById/{id}", name="getProductById")
     * @Method("GET")
     */
    public function getProductById($id){
        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');
        $qb= $repository->createQueryBuilder('c');
        $qb->select('c')
            ->where('c.id =:productid')
            ->setParameter('productid', $id);
        $query = $qb->getQuery();
        $products= $query -> getResult();
        $productArray = array();

        $i = 0;

        foreach($products as $product) {
            $productArray[0]['id'] = $product->getId();
            $productArray[0]['nazwa'] = $product->getName();
            $productArray[0]['cena'] = $product->getPrice();
            $productArray[0]['dostepnosc'] = $product->getAmount();
            $productArray[0]['opis'] = $product->getDescription();
            $productArray[0]['picture_path'] = $product->getPicturePath();
            $i++;
        }

        return new JsonResponse(array('product' =>$productArray));
    }

    /**
     * @Route("/getOrdersByUserId/{userid}", name="getOrdersByUserId")
     * @Method("GET")
     */
    public function getOrdersByUserId($userid){
        $repository = $this->getDoctrine()->getRepository('AppBundle:Order');
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->find('AppBundle\Entity\User',$userid);
        $qb= $repository->createQueryBuilder('o');
        $qb->select('o')
            ->where('o.user =:user')
            ->setParameter('user',$user);
        $query = $qb->getQuery();
        $orders= $query -> getResult();

        $ordersArray = array();



        $i=0; $j=0;
        foreach($orders as $order){
            $ordersArray[$i]['id'] = $order->getId();
            $ordersArray[$i]['placingDate'] = $order->getPlacingDate();
            $ordersArray[$i]['completionDate'] = $order->getCompletionDate();
            $ordersArray[$i]['stateid'] = $order->getState()->getId();
            $ordersArray[$i]['state'] = $order->getState()->getName();

            $orderProducts = $em->getRepository('AppBundle\Entity\OrderProducts')->findBy(array('order' => $order));
            foreach($orderProducts as $orderProduct){
                $product = $orderProduct->getProduct();
                $ordersArray[$i]['products'][$j]['id'] = $product->getId();
                $ordersArray[$i]['products'][$j]['name'] = $product->getName();
                $ordersArray[$i]['products'][$j]['amount'] = $orderProduct->getNumber();
                $ordersArray[$i]['products'][$j]['price'] = $orderProduct->getNumber() * $product->getPrice();
                $j++;
            }
            $i++;
        }

        //exit(dump($ordersArray));

        return new JsonResponse(array('ordersArray' => $ordersArray));
    }

}
