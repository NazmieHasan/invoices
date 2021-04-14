<?php

namespace AppBundle\Service\Enrollings;

use AppBundle\Entity\Enrolling;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;

interface EnrollingServiceInterface
{
    public function save(Enrolling $enrolling) : bool;
    public function delete(Enrolling $enrolling) : bool;
    public function findOneById(int $id) : ?Enrolling;
    public function findOne(Enrolling $enrolling) : ?Enrolling;
    public function getAll();
    
    /**
     * @param int $studentId
     * @return Enrolling[]
     */
    public function getAllByStudentId(int $studentId);
    
    /**
     * @param int $courseId
     * @return Enrolling[]
     */
    public function getAllByCourseId(int $courseId);

}