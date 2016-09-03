<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppBundle\Entity\Products
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProductsRepository")
 */
class Products
{
    /** @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var Characteristics
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Characteristics")
     * @ORM\JoinColumn(name="characteristic_id", referencedColumnName="id")
     */
    protected $characteristic;

    /**
     * @var string
     * @ORM\Column(name="name", type="string")
     */
    protected $name;

    /**
     * @var string
     * @ORM\Column(name="picture", type="string")
     */
    protected $picturePath;

    /**
     * @var string
     * @ORM\Column(name="link", type="string")
     */
    protected $productLink;

    /**
     * @var Stores
     * @ORM\ManyToOne(targetEntity="Stores", inversedBy="products")
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id")
     */
    private $store;

    /**
     * @var string
     * @ORM\Column(name="price", type="string")
     */
    protected $price;

    /**
     * @var boolean
     * @ORM\Column(name="updated", type="boolean")
     */
    protected $updated;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Products
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Characteristics
     */
    public function getCharacteristic()
    {
        return $this->characteristic;
    }

    /**
     * @param Characteristics $characteristic
     * @return Products
     */
    public function setCharacteristic($characteristic)
    {
        $this->characteristic = $characteristic;
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
     * @return Products
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPicturePath()
    {
        return $this->picturePath;
    }

    /**
     * @param string $picturePath
     * @return Products
     */
    public function setPicturePath($picturePath)
    {
        $this->picturePath = $picturePath;
        return $this;
    }

    /**
     * @return Stores
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @param Stores $store
     * @return Products
     */
    public function setStore($store)
    {
        $this->store = $store;
        return $this;
    }

    /**
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return Products
     */
    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getProductLink()
    {
        return $this->productLink;
    }

    /**
     * @param string $productLink
     * @return Products
     */
    public function setProductLink($productLink)
    {
        $this->productLink = $productLink;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isUpdated()
    {
        return $this->updated;
    }

    /**
     * @param boolean $updated
     * @return Products
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
        return $this;
    }
}
