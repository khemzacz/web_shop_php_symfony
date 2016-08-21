<?php
/**
 * Created by PhpStorm.
 * User: Konrad
 * Date: 20/08/2016
 * Time: 19:59
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_products")
 */
class OrderProducts
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="order_products")
     */
    protected $product;

    /**
     * @ORM\Column(type="integer")
     */
    protected $number;

    /**
     * @ORM\ManyToOne(targetEntity="Order", inversedBy="order_products")
     */
    protected $order;
}