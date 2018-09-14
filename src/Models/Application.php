<?php namespace professionalweb\IntegrationHub\IntegrationHub\Models;

use professionalweb\IntegrationHub\IntegrationHubDB\Interfaces\Model;
use professionalweb\IntegrationHub\IntegrationHubDB\Abstractions\UUIDModel;

/**
 * Application
 * @package App\Models
 *
 * @property string $id
 * @property string $client_id
 * @property string $client_secret
 * @property string $created_at
 * @property string $updated_at
 */
class Application extends UUIDModel implements Model
{
    protected $table = 'applications';

    protected $fillable = [
        'name',
    ];
}