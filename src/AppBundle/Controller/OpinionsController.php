<?php
/**
 * Created by PhpStorm.
 * User: Konrad
 * Date: 03/09/2016
 * Time: 19:52
 */

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Opinion;

/**
 * Class salesController
 * @Route("/opinions")
 * @package AppBundle\Controller
 */
class OpinionsController extends Controller{
    /**
     * @Route("/listOpinionsForProductById/{productid}", name="listOpinionsForProductById")
     * @Method("GET")
     */
    public function listOpinionsForProductById($productid){
        $repository = $this->getDoctrine()->getRepository('AppBundle:Opinion');
        $gb = $repository->createQueryBuilder('o');
        $gb -> select('o')
            -> where('o.product = :p')
            -> setParameter('p',$productid);
        $query= $gb->getQuery();
        $opinions = $query->getResult();

        $opinionsArray = array();

        $em = $this->get('doctrine.orm.entity_manager');

        $i=0;
        foreach ($opinions as $opinion){
            $opinionsArray[$i]['user'] = $opinion->getUser()->getUsername();
            $opinionsArray[$i]['body'] = $opinion->getBody();
            $i++;
        }
        return new JsonResponse(array('opinionsArray' => $opinionsArray));

    }

    /**
     * @Route("/editOpinion/{productid}/{userid}/{body}/{secret}", name="editOpinion")
     * @Method("GET")
     */
    public function editOpinion($productid, $userid, $body,$secret){
        try {
            if ($userid == ''){
                return new JsonResponse('2');
            }
            if ($productid == ''){
                return new JsonResponse('3');
            }
            if ($body == ''){
                return new JsonResponse('4');
            }
            $em = $this->get('doctrine.orm.entity_manager');
            $user = $em->find('AppBundle\Entity\User', $userid);
            if ($secret != $user->getSecret()) {
                return new JsonResponse('4'); //unathorized
            }
            $body = '\''.$body.'\'';
            $product = $em->find('AppBundle\Entity\Product', $productid);
            $repository = $this->getDoctrine()->getRepository('AppBundle:Opinion');
            $qb = $repository->createQueryBuilder('o');
            $qb->update('AppBundle\Entity\Opinion','o')
                -> set('o.body', $body)
                -> where('o.product = :p')
                -> andWhere('o.user = :u')
                -> setParameter('p',$product)
                -> setParameter('u',$user);
            $query= $qb->getQuery();
            if(count($query->getResult())>0){
                return new JsonResponse('0');
            }
            else{
                return new JsonResponse('5'); // didn't update
            }



        } catch (Exception $e){
            return new JsonResponse('1'); //DB error
        }
    }

    /**
     * @Route("/addOpinion/{productid}/{userid}/{body}/{secret}", name="addOpinion")
     * @Method("GET")
     */
    public function addOpinion($productid, $userid, $body, $secret){
        try {
            if ($userid == ''){
                return new JsonResponse('2');
            }
            if ($productid == ''){
                return new JsonResponse('3');
            }
            if ($body == ''){
                return new JsonResponse('3');
            }
            $em = $this->get('doctrine.orm.entity_manager');
            $user = $em->find('AppBundle\Entity\User', $userid);
            if ($secret != $user->getSecret()) {
                return new JsonResponse('4'); //unathorized
            }
            $opinion = new Opinion;
            $product = $em->find('AppBundle\Entity\Product', $productid);
            $opinion->setUser($user);
            $opinion->setProduct($product);
            $opinion->setBody($body);
            $em->persist($opinion);
            $em->flush();

            return new JsonResponse('0');

        } catch (\Exception $e){
            return new JsonResponse('1'); //DB error
        }








    }

}