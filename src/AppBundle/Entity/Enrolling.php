<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enrolling
 *
 * @ORM\Table(name="enrollings")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EnrollingRepository")
 */
class Enrolling
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
     * @var \DateTime
     *
     * @ORM\Column(name="dateAdded", type="datetime")
     */
    private $dateAdded;
    
    
    /**
     * @var int
     *
     * @ORM\Column(name="student_id", type="integer")
     */
    private $studentId;

    /**
     * @var Student
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Student", inversedBy="enrollings")
     * @ORM\JoinColumn(name="student_id", referencedColumnName="id")
     */
    private $student;
    
    /**
     * @var int
     *
     * @ORM\Column(name="course_id", type="integer")
     */
    private $courseId;

    /**
     * @var Student
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Course", inversedBy="enrollings")
     * @ORM\JoinColumn(name="course_id", referencedColumnName="id")
     */
    private $course;
    
    public function __construct()
    {
        $this->dateAdded = new \DateTime('now');
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
     * Set dateAdded
     *
     * @param \DateTime $dateAdded
     *
     * @return Enrolling
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * Get dateAdded
     *
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }
    
    /**
     * @return int
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * @param int $studentId
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;
    }

    /**
     * @return Student
     */
    public function getStudent()
    {
        return $this->student;
    }

    /**
     * @param Student $student
     */
    public function setStudent($student)
    {
        $this->student = $student;
    }
    
    /**
     * @return int
     */
    public function getCoursetId()
    {
        return $this->courseId;
    }

    /**
     * @param int $courseId
     */
    public function setCoursetId($courseId)
    {
        $this->courseId = $courseId;
    }

    /**
     * @return Course
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * @param Course $course
     */
    public function setCourse($course)
    {
        $this->course = $course;
    }
       
}

