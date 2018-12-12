<?php namespace professionalweb\IntegrationHub\IntegrationHub\Repositories;

use professionalweb\IntegrationHub\IntegrationHub\Models\Application;
use professionalweb\IntegrationHub\IntegrationHub\Models\PermanentToken;
use professionalweb\IntegrationHub\IntegrationHubCommon\Interfaces\Models\Model;
use professionalweb\IntegrationHub\IntegrationHubDB\Repositories\BaseRepository;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Repositories\ApplicationRepository as IApplicationRepository;

/**
 * Application repository
 * @package App\Repositories
 */
class ApplicationRepository extends BaseRepository implements IApplicationRepository
{

    public function __construct()
    {
        $this->setModelClass(Application::class);
    }

    /**
     * Get application by clientId
     *
     * @param string $clientId
     *
     * @return Application|null
     */
    public function getByClientId(string $clientId): ?Application
    {
        return Application::query()->where('client_id', $clientId)->first();
    }

    /**
     * Create model
     *
     * @param array $attributes
     *
     * @return Model
     */
    public function create(array $attributes = []): Model
    {
        $model = parent::create($attributes);

        $this->setNewKeys($model);

        return $model;
    }

    /**
     * Set new keys to model
     *
     * @param Application $model
     *
     * @return Application
     */
    protected function setNewKeys(Application $model): Application
    {
        $model->client_id = md5(time() . str_random());
        $model->client_secret = md5(time() . str_random());

        return $model;
    }

    /**
     * Generate new tokens
     *
     * @param Application $model
     *
     * @return Application
     */
    public function generateKeys(Application $model): Application
    {
        $this->setNewKeys($model)->save();

        return $model;
    }

    /**
     * Get application by permanent token
     *
     * @param string $token
     *
     * @return null|Application
     */
    public function getByPermanentToken(string $token): ?Application
    {
        $time = time();
        /** @var PermanentToken $token */
        if (($token = PermanentToken::query()->find($token)) !== null && strtotime($token->till) >= $time && strtotime($token->since) <= $time) {
            return $token->application;
        }

        return null;
    }
}