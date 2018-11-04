<?php namespace professionalweb\IntegrationHub\IntegrationHub\Traits;

use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Repositories\UserRepository;

/**
 * Trait for classes use UserController
 * @package professionalweb\IntegrationHub\IntegrationHub\Traits
 */
trait UseUserRepository
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Get user repository
     *
     * @return UserRepository
     */
    public function getUserRepository(): UserRepository
    {
        return $this->userRepository;
    }

    /**
     * Set user repository
     *
     * @param UserRepository $userRepository
     *
     * @return $this
     */
    public function setUserRepository(UserRepository $userRepository): self
    {
        $this->userRepository = $userRepository;

        return $this;
    }
}