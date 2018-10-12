<?php namespace professionalweb\IntegrationHub\IntegrationHub\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use professionalweb\IntegrationHub\IntegrationHubDB\Abstractions\UUIDModel;

/**
 * Permanent token
 * @package professionalweb\IntegrationHub\IntegrationHub\Models
 *
 * @property string      $id
 * @property string      $application_id
 * @property string      $since
 * @property string      $till
 *
 * @property Application $application
 */
class PermanentToken extends UUIDModel
{
    protected $table = 'permanent_access_tokens';

    /**
     * @return BelongsTo
     */
    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class, 'application_id');
    }
}