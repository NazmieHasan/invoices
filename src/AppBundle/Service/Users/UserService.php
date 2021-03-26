<?php


namespace AppBundle\Service\Users;


use AppBundle\Entity\User;
use AppBundle\Repository\UserRepository;
use AppBundle\Service\Encryption\BCryptService;
use AppBundle\Service\Encryption\EncryptionServiceInterface;
use Symfony\Component\Security\Core\Security;

class UserService implements UserServiceInterface
{

    private $security;
    private $userRepository;
    private $encryptionService;

    public function __construct(Security $security,
                                UserRepository $userRepository,
                                BCryptService $encryptionService)
    {
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->encryptionService = $encryptionService;
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function save(User $user): bool
    {
        $passwordHash =
            $this->encryptionService->hash($user->getPassword());
        $user->setPassword($passwordHash);

        return $this->userRepository->insert($user);
    }

    public function findOneByEmail(string $email): ?User
    {
        return $this->userRepository->findOneBy(['email' => $email]);
    }
}