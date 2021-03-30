<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Course
 *
 * @ORM\Table(name="courses")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CourseRepository")
 */
class Course
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\Length(
     *     min = 10,
     *     max = 40,
     *     minMessage="Title min length is 10",
     *     maxMessage="Title max length is 40"
     * )
     *
     * @Assert\Regex(
     *     pattern = "/^[A-Za-z0-9-+ ]+$/",
     *     match=true,
     *     message="Title contains letters, digit, space, '+' and '-'"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @Assert\Length(
     *     min = 20,
     *     max = 100,
     *     minMessage="Description min length is 20",
     *     maxMessage="Description max length is 100"
     * )
     *
     * @Assert\Regex(
     *     pattern = "/^[A-Za-z0-9.!?, ]+$/",
     *     match=true,
     *     message="Description contains letters, digit, '.', '!', '?', ',' and space"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @Assert\Date
     *
     * @var \DateTime
     *
     * @ORM\Column(name="startDate", type="date")
     */
    private $startDate;

    /**
     * @Assert\Date
     *
     * @var \DateTime
     *
     * @ORM\Column(name="finishDate", type="date")
     */
    private $finishDate;
    
    /**

    /**
     * @Assert\Regex(
     *     pattern = "/^[0-9]{3,4}.[0-9]{2}$/",
     *     match=true,
     *     message="The price must be a three-digit or four-digit floating point number to 2 digits after the floating point"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;
    
    /**
     * @Assert\Length(
     *     min = 10,
     *     max = 40,
     *     minMessage="Price text min length is 10",
     *     maxMessage="Price text max length is 40"
     * )
     *
     * @Assert\Regex(
     *     pattern = "/^[A-Za-z0. ]+$/",
     *     match=true,
     *     message="Price text contains letters, '.' and space"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="priceText", type="string", length=255)
     */
    private $priceText;
    
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Enrolling", mappedBy="courses")
     */
    private $enrollings;

    public function __construct()
    {
        $this->enrollings = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitle(); 
    }
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Course
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Course
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
     * Set startDate
     *
     * @param string $startDate
     *
     * @return Course
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return string
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set finishDate
     *
     * @param string $finishDate
     *
     * @return Course
     */
    public function setFinishDate($finishDate)
    {
        $this->finishDate = $finishDate;

        return $this;
    }

    /**
     * Get finishDate
     *
     * @return string
     */
    public function getFinishDate()
    {
        return $this->finishDate;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Course
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
     * Set priceText
     *
     * @param string $priceText
     *
     * @return Course
     */
    public function setPriceText($priceText)
    {
        $this->priceText = $priceText;

        return $this;
    }

    /**
     * Get priceText
     *
     * @return string
     */
    public function getPriceText()
    {
        return $this->priceText;
    }
    
    /**
     * @return ArrayCollection
     */
    public function getEnrollings()
    {
        return $this->enrollings;
    }

    /**
     * @param ArrayCollection $enrollings
     */
    public function setEnrollings(ArrayCollection $enrollings)
    {
        $this->enrollings = $enrollings;
    } 
    
}

