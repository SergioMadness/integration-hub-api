<?php namespace professionalweb\IntegrationHub\IntegrationHub\Interfaces\Services;

/**
 * Interface for service to work with navigation items
 * @package professionalweb\IntegrationHub\IntegrationHub\Interfaces\Services
 */
interface Navigation
{
    /**
     * Register items
     *
     * @param string $group
     * @param string $item
     * @param string $link
     *
     * @return Navigation
     */
    public function register(string $group, string $item, string $link): self;

    /**
     * Get all items
     *
     * @return array
     */
    public function get(): array;
}