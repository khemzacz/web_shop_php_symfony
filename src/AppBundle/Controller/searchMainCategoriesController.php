<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\User;
use AppBundle\Entity\Product;

/**
 * Class SearchMainCategoriesController
 * @Route("/search")
 * @package AppBundle\Controller
 */
class SearchMainCategoriesController extends Controller
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
        $em = $this->get('doctrine.orm.entity_manager');
//        $repository = $this->getDoctrine()->getRepository('AppBundle:Product');
//        $qb= $repository->createQueryBuilder('c');
//        $qb->select('c')
//            ->where('c.id =:productid')
//            ->setParameter('productid', $id);
//        $query = $qb->getQuery();
//        $product = $query -> getResult();
        $product = $em->find('AppBundle\Entity\Product', $id);
//        $productArray = array();


            $productArray['id'] = $product->getId();
            $productArray['nazwa'] = $product->getName();
            $productArray['cena'] = $product->getPrice();
            $productArray['dostepnosc'] = $product->getAmount();
            $productArray['opis'] = $product->getDescription();
            $productArray['picture_path'] = $product->getPicturePath();


        return new JsonResponse(array('product' =>$productArray));
    }

    /**
     * @Route("/getProductsMatchingToName/{chain}", name="getProductsMatchingToName")
     * @Method("GET")
     */
    public function getProductsMatchingToName($chain){
        if (strlen($chain)<2){
            return new JsonResponse(array('productsArray' => 1)); //argument to short
        }
        $em = $this->get('doctrine.orm.entity_manager');
        $chain = '%'.$chain.'%';
        $query = $em->createQuery('SELECT p FROM AppBundle\Entity\Product p WHERE p.name LIKE :chain');
        $query->setParameter('chain', $chain);
        $query->setMaxResults(10);
        $products = $query->getResult();
        //exit(dump($products));

        $productsArray = array();
        $i=0;
        foreach($products as $product){
            $productsArray[$i]['id'] = $product->getId();
            $productsArray[$i]['name'] = $product->getName();
            $productsArray[$i]['price'] = $product->getPrice();
            $productsArray[$i]['description'] = $product->getDescription();
            $productsArray[$i]['category'] = $product->getCategory()->getName();
            $productsArray[$i]['amount'] = $product->getAmount();
            $productsArray[$i]['picture_path'] = $product->getPicturePath();
            $i++;
        }

        return new JsonResponse(array('productsArray' => $productsArray));
    }

    /**
     * @Route("/getAllProductsMatchingToName/{chain}", name="getAllProductsMatchingToName")
     * @Method("GET")
     */
    public function getAllProductsMatchingToName($chain){
        if (strlen($chain)<2){
            return new JsonResponse(array('productsArray' => 1)); //argument to short
        }
        $em = $this->get('doctrine.orm.entity_manager');
        $chain = '%'.$chain.'%';
        $query = $em->createQuery('SELECT p FROM AppBundle\Entity\Product p WHERE p.name LIKE :chain');
        $query->setParameter('chain', $chain);
        $products = $query->getResult();
        //exit(dump($products));

        $productsArray = array();
        $i=0;
        foreach($products as $product){
            $productsArray[$i]['id'] = $product->getId();
            $productsArray[$i]['name'] = $product->getName();
            $productsArray[$i]['price'] = $product->getPrice();
            $productsArray[$i]['description'] = $product->getDescription();
            $productsArray[$i]['category'] = $product->getCategory()->getName();
            $productsArray[$i]['amount'] = $product->getAmount();
            $productsArray[$i]['picture_path'] = $product->getPicturePath();
            $i++;
        }

        return new JsonResponse(array('productsArray' => $productsArray));
    }


    /**
     * @Route("/getOrdersByUserId/{userid}/{secret}", name="getOrdersByUserId")
     * @Method("GET")
     */
    public function getOrdersByUserId($userid, $secret){
        $repository = $this->getDoctrine()->getRepository('AppBundle:Order');
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->find('AppBundle\Entity\User',$userid);
        if ($secret != $user->getSecret()) {
            return new JsonResponse('4'); //unathorized
        }
        $qb= $repository->createQueryBuilder('o');
        $qb->select('o')
            ->where('o.user =:user')
            ->setParameter('user',$user);
        $query = $qb->getQuery();
        $orders= $query -> getResult();

        $ordersArray = array();

        $repository = $this->getDoctrine()->getRepository('AppBundle:Opinion');
        $qb = $repository->createQueryBuilder('o');


        $i=0; $j=0;
        foreach($orders as $order){
            $ordersArray[$i]['id'] = $order->getId();
            $placingDate = $order->getPlacingDate();
            if($placingDate)
            {
                //$placingDate->format('d-m-Y H:i');
                $placingDate = $placingDate->format('d-m-Y H:i');
            }

            $ordersArray[$i]['placingDate'] = $placingDate;
            $completionDate = $order->getCompletionDate();
            if($completionDate)
            {
                $completionDate = $completionDate->format('Y-m-d H:i:s');
                //$completionDate = $completionDate->date;
            }
            $ordersArray[$i]['completionDate'] = $completionDate;
            $ordersArray[$i]['stateid'] = $order->getState()->getId();
            $ordersArray[$i]['state'] = $order->getState()->getName();
            $ordersArray[$i]['value'] = 0;
            $price = 0;
            $orderProducts = $em->getRepository('AppBundle\Entity\OrderProducts')->findBy(array('order' => $order));



            foreach($orderProducts as $orderProduct){
                $product = $orderProduct->getProduct();
                $ordersArray[$i]['products'][$j]['id'] = $product->getId();
                $ordersArray[$i]['products'][$j]['name'] = $product->getName();
                $ordersArray[$i]['products'][$j]['amount'] = $orderProduct->getNumber();
                $price += $ordersArray[$i]['products'][$j]['price'] = $orderProduct->getNumber() * $product->getPrice();

                $qb -> select('o')
                    -> where('o.product = :p')
                    -> andWhere('o.user = :u')
                    -> setParameter('p',$product)
                    -> setParameter('u',$user);
                $query= $qb->getQuery();
                if( count($query->getResult())>0 ) {
                    $ordersArray[$i]['products'][$j]['reviewed'] = true;
                }
                else
                    $ordersArray[$i]['products'][$j]['reviewed'] = false;

                $j++;
            }
            $ordersArray[$i]['value'] = $price;
            $ordersArray[$i]['showProducts'] = false;
            $i++;
        }

        //exit(dump($ordersArray));

        return new JsonResponse(array('ordersArray' => $ordersArray));
    }

}
