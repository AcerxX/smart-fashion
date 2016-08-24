<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * AppBundle\Entity\Characteristics
 * @package AppBundle\Entity
 * @ORM\Entity
 * @ORM\Table(name="characteristics")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CharacteristicsRepository")
 */
class Characteristics
{
    /** @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(name="gender", type="string")
     */
    protected $gender;

    /**
     * @var string
     * @ORM\Column(name="category", type="string")
     */
    protected $category;

    /**
     * @var string
     * @ORM\Column(name="color", type="string")
     */
    protected $color;

    /**
     * @var string
     * @ORM\Column(name="pattern", type="string")
     */
    protected $pattern;

    /**
     * @var string
     * @ORM\Column(name="age", type="string")
     */
    protected $age;

    /**
     * @var Products
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\Products", mappedBy="characteristic")
     */
    protected $product;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Characteristics
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return Characteristics
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     * @return Characteristics
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return Characteristics
     */
    public function setColor($color)
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * @param string $pattern
     * @return Characteristics
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * @return string
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param string $age
     * @return Characteristics
     */
    public function setAge($age)
    {
        $this->age = $age;
        return $this;
    }

    /**
     * @return Products
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * @param Products $product
     * @return Characteristics
     */
    public function setProduct($product)
    {
        $this->product = $product;
        return $this;
    }
}
