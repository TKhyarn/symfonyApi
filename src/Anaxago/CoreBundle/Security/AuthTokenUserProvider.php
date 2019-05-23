<?php
/********************************
 * Created by ktroufleau.
 * Date: 20/05/2019
 * Time: 23:08
 ********************************/


namespace Anaxago\CoreBundle\Security;

use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Doctrine\ORM\EntityRepository;

/**
 * Class AuthTokenUserProvider
 * @package Anaxago\CoreBundle\Security
 */
class AuthTokenUserProvider implements UserProviderInterface
{
    protected $authTokenRepository;
    protected $userRepository;

    /**
     * AuthTokenUserProvider constructor.
     * @param EntityRepository $authTokenRepository
     * @param EntityRepository $userRepository
     */
    public function __construct(EntityRepository $authTokenRepository, EntityRepository $userRepository)
    {
        $this->authTokenRepository = $authTokenRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param $authTokenHeader
     *
     * @return mixed
     */
    public function getAuthToken($authTokenHeader)
    {
        return $this->authTokenRepository->findOneByValue($authTokenHeader);
    }

    /**
     * @param string $email
     *
     * @return UserInterface
     */
    public function loadUserByUsername($email)
    {
        return $this->userRepository->findByEmail($email);
    }

    /**
     * @param UserInterface $user
     *
     * @return UserInterface|void
     */
    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    /**
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return 'AppBundle\Entity\User' === $class;
    }
}