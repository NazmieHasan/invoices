<?php

namespace AppBundle\Service\Courses;

use AppBundle\Entity\Course;

interface CourseServiceInterface
{
    public function save(Course $course) : bool;
    public function update(Course $course) : bool;
    public function delete(Course $course) : bool;
    public function findOneById(int $id) : ?Course;
    public function findOne(Course $course) : ?Course;
    public function getAll();
    public function findOneByTitle(string $title) : ?Course;
}