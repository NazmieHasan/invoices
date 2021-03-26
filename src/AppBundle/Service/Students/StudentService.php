<?php


namespace AppBundle\Service\Students;


use AppBundle\Entity\Student;
use AppBundle\Repository\StudentRepository;

class StudentService implements StudentServiceInterface
{

    private $studentRepository;

    public function __construct(studentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    /**
     * @param Student $student
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(Student $student): bool
    {

        return $this->studentRepository->insert($student);
    }

    /**
     * @param int $id
     * @return Student|null|object
     */
    public function findOneById(int $id): ?Student
    {
        return $this->studentRepository->find($id);
    }

    /**
     * @param Student $student
     * @return Student|null|object
     */
    public function findOne(Student $student): ?Student
    {
        return $this->studentRepository->find($student);
    }


    /**
     * @param Student $student
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update(Student $student): bool
    {
        return $this->studentRepository->update($student);
    }

    /**
     * @return Student[]|array
     */
    public function getAll()
    {
      return $this->studentRepository->findBy([], ['id' => 'DESC']);
    }

    /**
     * @param Student $student
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function delete(Student $student): bool
    {
        return $this->studentRepository->remove($student);
    }

    public function findOneByPersonalNumber(string $personalNumber): ?Student
    {
        return $this->studentRepository->findOneBy(['personalNumber' => $personalNumber]);
    }
}