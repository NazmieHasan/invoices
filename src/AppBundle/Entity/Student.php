<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Student
 *
 * @ORM\Table(name="students")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\StudentRepository")
 */
class Student
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
     * @Assert\Regex(
     *     pattern = "/^[1-9]{10}$/",
     *     match=true,
     *     message="The personal number can contain only 10 digits"
     * )
     * @var string
     *
     * @ORM\Column(name="personalNumber", type="string", length=255, unique=true)
     */
    private $personalNumber;

    /**
     * @Assert\Length(
     *     min = 3,
     *     max = 15,
     *     minMessage="First name min length is 3",
     *     maxMessage="First name max length is 15"
     * )
     *
     * @Assert\Regex(
     *     pattern = "/^[A-Z]{1}[a-z]+$/",
     *     match=true,
     *     message="First name must start with a capital letter, followed by lowercase letters"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;
    
    /**
     * @Assert\Length(
     *     min = 3,
     *     max = 15,
     *     minMessage="Father's name min length is 3",
     *     maxMessage="Father's name max length is 15"
     * )
     *
     * @Assert\Regex(
     *     pattern = "/^[A-Z]{1}[a-z]+$/",
     *     match=true,
     *     message="Father's name must start with a capital letter, followed by lowercase letters"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="fathersName", type="string", length=255)
     */
    private $fathersName;

    /**
     * @Assert\Length(
     *     min = 3,
     *     max = 15,
     *     minMessage="Last name min length is 3",
     *     maxMessage="Last name max length is 15"
     * )
     *
     * @Assert\Regex(
     *     pattern = "/^[A-Z]{1}[a-z]+$/",
     *     match=true,
     *     message="Last name must start with a capital letter, followed by lowercase letters"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;
    
    /**
     * @Assert\File(
     *     mimeTypes = {"image/jpeg", "image/jpg"},
     *     mimeTypesMessage = "File type must be only jpeg or jpg with max size 1MB"
     * )
     *
     * @Assert\File(
     *     maxSize = "1024k",
     *     maxSizeMessage = "File type must be only jpeg or jpg with max size 1MB"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;
    
    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Enrolling", mappedBy="students")
     */
    private $enrollings;

    public function __construct()
    {
        $this->enrollings = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getPersonalNumber();
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
     * Set personalNumber
     *
     * @param string $personalNumber
     *
     * @return Student
     */
    public function setPersonalNumber($personalNumber)
    {
        $this->personalNumber = $personalNumber;

        return $this;
    }

    /**
     * Get personalNumber
     *
     * @return string
     */
    public function getPersonalNumber()
    {
        return $this->personalNumber;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Student
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    /**
     * Set fathersName
     *
     * @param string $fathersName
     *
     * @return Student
     */
    public function setFathersName($fathersName)
    {
        $this->fathersName = $fathersName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFathersName()
    {
        return $this->fathersName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Student
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }
    
    /**
     *
     * @param string $image
     */
    public function setImage(string $image)
    {
        $this->image = $image;
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

