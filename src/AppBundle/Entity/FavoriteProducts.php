<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AppBundle\Entity\FavoriteProducts
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="products_favorites")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FavoriteProductsRepository")
 */
class FavoriteProducts
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

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
     * @ORM\ManyToOne(targetEntity="Stores", inversedBy="favoriteProducts")
     * @ORM\JoinColumn(name="store_id", referencedColumnName="id")
     */
    private $store;

    /**
     * @var Users
     * @ORM\ManyToOne(targetEntity="Users", inversedBy="favoriteProducts")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var integer
     * @ORM\Column(name="status", type="integer")
     */
    private $status = 1;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return FavoriteProducts
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
     * @return FavoriteProducts
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
     * @return FavoriteProducts
     */
    public function setPicturePath($picturePath)
    {
        $this->picturePath = $picturePath;
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
     * @return FavoriteProducts
     */
    public function setProductLink($productLink)
    {
        $this->productLink = $productLink;
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
     * @return FavoriteProducts
     */
    public function setStore($store)
    {
        $this->store = $store;
        return $this;
    }

    /**
     * @return Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param Users $user
     * @return FavoriteProducts
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return FavoriteProducts
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}
