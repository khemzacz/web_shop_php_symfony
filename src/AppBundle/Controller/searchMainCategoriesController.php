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


}
