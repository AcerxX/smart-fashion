<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * AppBundle\Entity\Stores
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="stores")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StoresRepository")
 */
class Stores
{
    /** @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * @var ArrayCollection|Products
     * @ORM\OneToMany(targetEntity="Products", mappedBy="store")
     */
    private $products;

    /**
     * @var ArrayCollection|FavoriteProducts
     * @ORM\OneToMany(targetEntity="FavoriteProducts", mappedBy="store")
     */
    private $favoriteProducts;

    /**
     * @var string
     * @ORM\Column(name="link", type="string")
     */
    private $storeLink;

    /**
     * @var string
     * @ORM\Column(name="logo", type="string")
     */
    private $storeImage;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Stores
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Stores
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Products|ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param Products|ArrayCollection $products
     * @return Stores
     */
    public function setProducts($products)
    {
        $this->products = $products;
        return $this;
    }

    /**
     * @return string
     */
    public function getStoreLink()
    {
        return $this->storeLink;
    }

    /**
     * @param string $storeLink
     * @return Stores
     */
    public function setStoreLink($storeLink)
    {
        $this->storeLink = $storeLink;
        return $this;
    }

    /**
     * @return string
     */
    public function getStoreImage()
    {
        return $this->storeImage;
    }

    /**
     * @param string $storeImage
     * @return Stores
     */
    public function setStoreImage($storeImage)
    {
        $this->storeImage = $storeImage;
        return $this;
    }

    /**
     * @return FavoriteProducts|ArrayCollection
     */
    public function getFavoriteProducts()
    {
        return $this->favoriteProducts;
    }

    /**
     * @param FavoriteProducts|ArrayCollection $favoriteProducts
     * @return Stores
     */
    public function setFavoriteProducts($favoriteProducts)
    {
        $this->favoriteProducts = $favoriteProducts;
        return $this;
    }
}
