<?php namespace professionalweb\IntegrationHub\IntegrationHub\Interfaces\Repositories;

use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models\User;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models\Token;
use professionalweb\IntegrationHub\IntegrationHubDB\Interfaces\Repository;

/**
 * Interface for user repository
 * @package App\Interfaces\Repositories
 */
interface UserRepository extends Repository
{
    /**
     * Get user by token
     *
     * @param string $token
     *
     * @return User
     */
    public function getByToken(string $token): ?User;

    /**
     * Refresh user token
     *
     * @param string $token
     * @param string $refreshToken
     *
     * @return Token
     */
    public function refreshToken(string $token, string $refreshToken): ?Token;

    /**
     * Get user by login and password
     *
     * @param string $login
     * @param string $password
     *
     * @return User|null
     */
    public function getByCredentials(string $login, string $password): ?User;
}