<?php namespace professionalweb\IntegrationHub\IntegrationHub\Interfaces\Services;

/**
 * Interface for service to validate request by secret key
 * @package professionalweb\IntegrationHub\IntegrationHub\Interfaces\Services
 */
interface RequestValidation
{
    /**
     * Validate data by secret key
     *
     * @param array  $data
     * @param string $signature
     * @param string $key
     *
     * @return bool
     */
    public function validate(array $data, string $key, string $signature): bool;
}