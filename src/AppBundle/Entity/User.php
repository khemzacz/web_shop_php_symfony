<?php
/**
 * Created by PhpStorm.
 * User: Konrad
 * Date: 2/25/2016
 * Time: 10:25 AM
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\OneToMany(targetEntity="Order", mappedBy="user")
     */
    protected $orders;
//
//    /**
//     * @ORM\OneToMany(targetEntity="Opinion", mappedBy="user")
//     */
//    protected $opinions;

    /**
     * @ORM\Column(type="text")
     */
    protected $secret;

    /**
     * User constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $cl = strlen($characters);
        $genSecret = '';
        $strength = 60;
        for ($i = 0;$i<$strength;$i++){
            $genSecret .= $characters[rand(0,$cl-1)];
        }
        $this->secret = $genSecret;

    }


    /**
     * Add order
     *
     * @param \AppBundle\Entity\Order $order
     *
     * @return User
     */
    public function addOrder(\AppBundle\Entity\Order $order)
    {
        $this->orders[] = $order;

        return $this;
    }

    /**
     * Remove order
     *
     * @param \AppBundle\Entity\Order $order
     */
    public function removeOrder(\AppBundle\Entity\Order $order)
    {
        $this->orders->removeElement($order);
    }

    /**
     * Get orders
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    public function getId(){
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param mixed $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }


}
