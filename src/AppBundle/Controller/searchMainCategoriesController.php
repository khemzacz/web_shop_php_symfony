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
            $categoriesArray[$i]['nazwaKategori'] = $category->getName();
            $categoriesArray[$i]['idKategori'] = $category->getId();
            $i++;
        }
        return new JsonResponse(array('categories' =>$categoriesArray));
    }

    /**
     * @Route("/getSubCategoriesById/{id}", name="getSubCategoriesById")
     * @Method("GET")
     */
    public function getSubCategoriesById($id)
    {
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
            $categoriesArray[$i]['nazwaKategori'] = $category->getName();
            $categoriesArray[$i]['idKategori'] = $category->getId();
            $i++;
        }
        return new JsonResponse(array('categories' =>$categoriesArray));
    }



}
