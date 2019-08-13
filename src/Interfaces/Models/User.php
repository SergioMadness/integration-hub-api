<?php namespace professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models;

use professionalweb\IntegrationHub\IntegrationHubCommon\Interfaces\Models\Model;

/**
 * Interface for user model
 * @package professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models
 */
interface User extends Model
{
    /**
     * Generate token
     *
     * @return Token
     */
    public function generateToken(): Token;

    /**
     * @param string $password
     *
     * @return bool
     */
    public function validatePassword(string $password): bool;
}