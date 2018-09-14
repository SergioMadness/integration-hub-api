<?php namespace professionalweb\IntegrationHub\IntegrationHub\Interfaces\Repositories;

use professionalweb\IntegrationHub\IntegrationHub\Models\Application;
use professionalweb\IntegrationHub\IntegrationHubDB\Interfaces\Repository;

/**
 * Interface for application repository
 * @package professionalweb\IntegrationHub\IntegrationHub\Interfaces\Repositories
 */
interface ApplicationRepository extends Repository
{
    /**
     * Get application by clientId
     *
     * @param string $clientId
     *
     * @return Application|null
     */
    public function getByClientId(string $clientId): ?Application;

    /**
     * Generate new tokens
     *
     * @param Application $model
     *
     * @return Application
     */
    public function generateKeys(Application $model): Application;
}