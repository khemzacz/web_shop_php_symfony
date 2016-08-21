<?php
/**
 * Created by PhpStorm.
 * User: Konrad
 * Date: 2/24/2016
 * Time: 7:38 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM; # looks like "#define" from c++

/**
 * @ORM\Entity
 * @ORM\Table(name="order")
 */

class Order
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="orders" )
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;
    /**
     * @ORM\Column(type="date")
     */
    protected $placing_date;
    /**
     * @ORM\Column(type="date")
     */
    protected $completion_date;
    /**
     * @ORM\OneToOne(targetEntity="State")
     * @ORM\JoinColumn(name="state_id", referencedColumnName="id")
     */
    protected $state;

    /**
     * @ORM\OneToMany(targetEntity="OrderProducts", mappedBy="order")
     */
    protected $order_products;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fosUserId
     *
     * @param integer $fosUserId
     *
     * @return Order
     */
    public function setFosUserId($fosUserId)
    {
        $this->fos_user_id = $fosUserId;

        return $this;
    }

    /**
     * Get fosUserId
     *
     * @return integer
     */
    public function getFosUserId()
    {
        return $this->fos_user_id;
    }

    /**
     * Set placingDate
     *
     * @param \DateTime $placingDate
     *
     * @return Order
     */
    public function setPlacingDate($placingDate)
    {
        $this->placing_date = $placingDate;

        return $this;
    }

    /**
     * Get placingDate
     *
     * @return \DateTime
     */
    public function getPlacingDate()
    {
        return $this->placing_date;
    }

    /**
     * Set completionDate
     *
     * @param \DateTime $completionDate
     *
     * @return Order
     */
    public function setCompletionDate($completionDate)
    {
        $this->completion_date = $completionDate;

        return $this;
    }

    /**
     * Get completionDate
     *
     * @return \DateTime
     */
    public function getCompletionDate()
    {
        return $this->completion_date;
    }

    /**
     * Set stateId
     *
     * @param integer $stateId
     *
     * @return Order
     */
    public function setStateId($stateId)
    {
        $this->state_id = $stateId;

        return $this;
    }

    /**
     * Get stateId
     *
     * @return integer
     */
    public function getStateId()
    {
        return $this->state_id;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Order
     */
    public function addProduct(\AppBundle\Entity\Product $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \AppBundle\Entity\Product $product
     */
    public function removeProduct(\AppBundle\Entity\Product $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set state
     *
     * @param \AppBundle\Entity\State $state
     *
     * @return Order
     */
    public function setState(\AppBundle\Entity\State $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \AppBundle\Entity\State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Order
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
