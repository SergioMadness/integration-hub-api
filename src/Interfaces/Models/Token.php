<?php namespace professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models;

/**
 * Interface for token model
 * @package professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models
 */
interface Token
{
    /**
     * Get token
     *
     * @return string
     */
    public function getToken(): string;

    /**
     * Get refresh token
     *
     * @return string
     */
    public function getRefreshToken(): string;

    /**
     * Generate token
     *
     * @return string
     */
    public function generateToken(): string;
}