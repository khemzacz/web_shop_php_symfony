<?php
/**
 * Created by PhpStorm.
 * User: Konrad
 * Date: 2/24/2016
 * Time: 7:21 PM
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="category")
 */

class Category
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    /**
     * @ORM\Column(type="string", length=50)
     */
    protected $name;
    /**
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    protected $upper_category;

    /**
     * @ORM\OneToMany(targetEntity="Product", mappedBy="category")
     */
    protected $products;
    /**
     * @ORM\OneToMany(targetEntity="Category", mappedBy="category")
     */
    protected $sub_categories;


    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->sub_categories = new ArrayCollection();
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
     * @return Category
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
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return Category
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
     * Set upperCategory
     *
     * @param \AppBundle\Entity\category $upperCategory
     *
     * @return Category
     */
    public function setUpperCategory(\AppBundle\Entity\category $upperCategory = null)
    {
        $this->upper_category = $upperCategory;

        return $this;
    }

    /**
     * Get upperCategory
     *
     * @return \AppBundle\Entity\category
     */
    public function getUpperCategory()
    {
        return $this->upper_category;
    }

    /**
     * Add product
     *
     * @param \AppBundle\Entity\Product $product
     *
     * @return Category
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
     * Add subCategory
     *
     * @param \AppBundle\Entity\Category $subCategory
     *
     * @return Category
     */
    public function addSubCategory(\AppBundle\Entity\Category $subCategory)
    {
        $this->sub_categories[] = $subCategory;

        return $this;
    }

    /**
     * Remove subCategory
     *
     * @param \AppBundle\Entity\Category $subCategory
     */
    public function removeSubCategory(\AppBundle\Entity\Category $subCategory)
    {
        $this->sub_categories->removeElement($subCategory);
    }

    /**
     * Get subCategories
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getSubCategories()
    {
        return $this->sub_categories;
    }
}
