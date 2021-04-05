<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User implements UserInterface
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
     * @Assert\Email(
     *     message="Невалиден имейл",
     *     checkMX=false
     * )
     *
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @Assert\NotBlank(message="Това поле не може да бъде празно")
     *
     * @Assert\Length(
     *     min = 5,
     *     max = 15,
     *     minMessage="Минималната дължина на това поле е 5",
     *     maxMessage="Максималната дължина на това поле е 15"
     * )
     *
     *  * @Assert\Regex(
     *     pattern = "/^[А-яа-я0-9]+$/",
     *     match=true,
     *     message="Паролата може да съдържа само букви и цифри"
     * )*
     
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
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
     * @return User
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
     * @return User
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
    
    public function getRoles()
    {
        return [];
    }

    public function getSalt()
    {
        // TODO: Implement getSalt() method.
    }

    public function getUsername()
    {
        return $this->email;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

}

