<?php

namespace AppBundle\Service\Students;

use AppBundle\Entity\Student;

interface StudentServiceInterface
{
    public function save(Student $student) : bool;
    public function update(Student $student) : bool;
    public function delete(Student $student) : bool;
    public function findOneById(int $id) : ?Student;
    public function findOne(Student $student) : ?Student;
    public function getAll();
    public function findOneByPersonalNumber(string $personalNumber) : ?Student;
}