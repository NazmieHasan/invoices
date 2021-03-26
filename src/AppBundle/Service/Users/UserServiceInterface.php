<?php

namespace AppBundle\Service\Users;

use AppBundle\Entity\User;

interface UserServiceInterface
{
    public function findOneByEmail(string $email) : ?User;
    public function save(User $user) : bool;
}