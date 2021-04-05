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
     * @Assert\NotBlank(message="Това поле не може да бъде празно")
     *
     * @Assert\Regex(
     *     pattern = "/^[0-9]{10}$/",
     *     match=true,
     *     message="ЕГН-то трябва да съдържа само десет цифри"
     * )
     * @var string
     *
     * @ORM\Column(name="personalNumber", type="string", length=255, unique=true)
     */
    private $personalNumber;

    /**
     * @Assert\NotBlank(message="Това поле не може да бъде празно")
     *
     * @Assert\Length(
     *     min = 3,
     *     max = 12,
     *     minMessage="Минималната дължина на това поле е 3",
     *     maxMessage="Максималната дължина на това поле е 12"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="firstName", type="string", length=255)
     */
    private $firstName;
    
    /**
     * @Assert\NotBlank(message="Това поле не може да бъде празно")
     *
     * @Assert\Length(
     *     min = 3,
     *     max = 12,
     *     minMessage="Минималната дължина на това поле е 3",
     *     maxMessage="Максималната дължина на това поле е 12"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="fathersName", type="string", length=255)
     */
    private $fathersName;

    /**
     * @Assert\NotBlank(message="Това поле не може да бъде празно")
     *
     * @Assert\Length(
     *     min = 3,
     *     max = 12,
     *     minMessage="Минималната дължина на това поле е 3",
     *     maxMessage="Максималната дължина на това поле е 12"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="lastName", type="string", length=255)
     */
    private $lastName;
    
    /**
     * @Assert\NotBlank(message="Това поле не може да бъде празно")
     *
     * @Assert\File(
     *     mimeTypes = {"image/jpeg", "image/jpg"},
     *     mimeTypesMessage = "Снимката може да е jpeg или jpg с максимален размер 1MB"
     * )
     *
     * @Assert\File(
     *     maxSize = "1024k",
     *     maxSizeMessage = "Снимката може да е jpeg или jpg с максимален размер 1MB"
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Enrolling", mappedBy="student")
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
     * Get fathersName
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
    public function getEnrollings(): ArrayCollection
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