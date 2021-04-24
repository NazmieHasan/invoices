<?php

namespace AppBundle\Service\Enrollings;

use AppBundle\Entity\Enrolling;
use AppBundle\Repository\EnrollingRepository;
use AppBundle\Service\Students\StudentServiceInterface;
use AppBundle\Service\Courses\CourseServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;

class EnrollingService implements EnrollingServiceInterface
{
    /**
     * @var StudentServiceInterface
     */
    private $studentService;
    
    /**
     * @var CourseServiceInterface
     */
    private $courseService;
    
    private $enrollingRepository;

    /**
     * EnrollingService constructor.
     * @param EnrollingRepository $enrollingRepository
     */
    public function __construct(enrollingRepository $enrollingRepository,
            StudentServiceInterface $studentService,
            CourseServiceInterface $courseService)
    {
        $this->enrollingRepository = $enrollingRepository;
        $this->studentService = $studentService;
        $this->courseService = $courseService;
    }

    /**
     * @param Request $request
     * @param Enrolling $enrolling
     * @param int $studentId
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Enrolling $enrolling, int $studentId): bool
    {
        $enrolling
            ->setStudent($this->studentService->findOneById($studentId));

        return $this->enrollingRepository->insert($enrolling);
    }
    
    /**
     * @param Enrolling $enrolling
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Enrolling $enrolling): bool
    {
        return $this->enrollingRepository->remove($enrolling);
    }

    /**
     * @param int $id
     * @return Enrolling|null|object
     */
    public function findOneById(int $id): ?Enrolling
    {
        return $this->enrollingRepository->find($id);
    }

    /**
     * @param Enrolling $enrolling
     * @return Enrolling|null|object
     */
    public function findOne(Enrolling $enrolling): ?Enrolling
    {
        return $this->enrollingRepository->find($enrolling);
    }

    /**
     * @return Enrolling[]|array
     */
    public function getAll()
    {
      return $this->enrollingRepository->findBy([], ['id' => 'DESC']);
    }
    
    /**
     * @param int $studentId
     * @return Enrolling[]
     */
    public function getAllByStudentId(int $studentId)
    {
        $student = $this->studentService->findOneById($studentId);
        return $this
            ->enrollingRepository
            ->findBy(['student' => $student], ['dateAdded' => 'DESC']);
    }
    
    /**
     * @param int $courseId
     * @return Enrolling[]
     */
    public function getAllByCourseId(int $courseId)
    {
        $course = $this->courseService->findOneById($courseId);
        return $this
            ->enrollingRepository
            ->findBy(['course' => $course], ['dateAdded' => 'DESC']);
    }

}