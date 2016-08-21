<?php
/**
 * Created by PhpStorm.
 * User: Konrad
 * Date: 2/23/2016
 * Time: 5:39 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */

class Product
{
/**
 * @ORM\Column(type="integer")
 * @ORM\Id
 * @ORM\GeneratedValue(strategy="AUTO")
 */
    protected $id;
/**
 * @ORM\Column(type="string", length=100)
 */
    protected $name;
/**
 * @ORM\Column(type="decimal", scale=2)
 */
    protected $price;
/**
 * @ORM\Column(type="text")
 */
    protected $description;
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $category;
    /**
     * @ORM\Column(type="integer")
     */
    protected $amount;
    /**
     * @ORM\Column(type="string", length=255, nullable = true)
     */
    protected $picture_path;

    /**
     * @ORM\OneToMany(targetEntity="OrderProducts", mappedBy="order")
     */
    protected $order_products;

    public function getAbsolutePath(){
        return null === $this->picture_path ? null : $this->getUploadDir().'/'.$this->path;
    }


    public function getWebPath(){
        return null === $this->picture_path ? null : $this->getUploadDir().'/'/$this->path;
    }

    protected function getUploadRootDir(){
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir(){
        return 'products/images';
    }

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return Product
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return Product
     */
    public function setCategoryId($categoryId)
    {
        $this->category_id = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return Product
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set picturePath
     *
     * @param string $picturePath
     *
     * @return Product
     */
    public function setPicturePath($picturePath)
    {
        $this->picture_path = $picturePath;

        return $this;
    }

    /**
     * Get picturePath
     *
     * @return string
     */
    public function getPicturePath()
    {
        return $this->picture_path;
    }

    /**
     * Set category
     *
     * @param \AppBundle\Entity\category $category
     *
     * @return Product
     */
    public function setCategory(\AppBundle\Entity\category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \AppBundle\Entity\category
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
