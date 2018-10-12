<?php namespace professionalweb\IntegrationHub\IntegrationHub\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
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

    /**
     * @return HasMany
     */
    public function permanentTokens(): HasMany
    {
        return $this->hasMany(PermanentToken::class, 'application_id');
    }
}