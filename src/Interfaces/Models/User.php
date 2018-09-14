<?php namespace professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models;

use professionalweb\IntegrationHub\IntegrationHubDB\Interfaces\Model;

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
}