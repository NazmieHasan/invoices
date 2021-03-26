<?php

namespace AppBundle\Service\Courses;

use AppBundle\Entity\Course;
use AppBundle\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;

class CourseService implements CourseServiceInterface
{

    private $courseRepository;

    /**
     * CourseService constructor.
     * @param CourseRepository $courseRepository
     */
    public function __construct(courseRepository $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    /**
     * @param Course $course
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Course $course): bool
    {

        return $this->courseRepository->insert($course);
    }

    /**
     * @param int $id
     * @return Course|null|object
     */
    public function findOneById(int $id): ?Course
    {
        return $this->courseRepository->find($id);
    }

    /**
     * @param Course $course
     * @return Course|null|object
     */
    public function findOne(Course $course): ?Course
    {
        return $this->courseRepository->find($course);
    }


    /**
     * @param Course $course
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Course $course): bool
    {
        return $this->courseRepository->update($course);
    }

    /**
     * @return Course[]|array
     */
    public function getAll()
    {
      return $this->courseRepository->findAll();
    }

    /**
     * @param Course $course
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Course $course): bool
    {
        return $this->courseRepository->remove($course);
    }

    public function findOneByTitle(string $title): ?Course
    {
        return $this->courseRepository->findOneBy(['title' => $title]);
    }
    
}