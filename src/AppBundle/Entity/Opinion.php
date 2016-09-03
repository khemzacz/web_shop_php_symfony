<?php
/**
 * Created by PhpStorm.
 * User: Konrad
 * Date: 03/09/2016
 * Time: 19:24
 */


namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="opinion")
 */
class Opinion{
    /**
     * @ORM\Id @ORM\ManyToOne(targetEntity="Product", inversedBy="Opinion")
     */
    protected $product;

    /**
     * @ORM\Id @ORM\ManyToOne(targetEntity="User", inversedBy="Opinion")
     */
    protected $user;

    /**
     * @ORM\Column(name="`body`", type="text")
     */
    protected $body;

    /**
     * @return mixed
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param mixed $product
     */
    public function setProduct($product)
    {
        $this->product = $product;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }





}

