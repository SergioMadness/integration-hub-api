<?php namespace professionalweb\IntegrationHub\IntegrationHub\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use professionalweb\IntegrationHub\IntegrationHubDB\Abstractions\UUIDModel;
use professionalweb\IntegrationHub\IntegrationHubCommon\Interfaces\Models\Model;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models\Token as IToken;

/**
 * Token
 * @package professionalweb\IntegrationHub\IntegrationHub\Models
 *
 * @property string $id
 * @property string $token
 * @property string $refresh_token
 * @property string $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property User   $user
 */
class Token extends UUIDModel implements Model, IToken
{
    protected $table = 'user_access_tokens';

    protected $keyType = 'string';

    public static function boot()
    {
        parent::boot();

        static::creating(function (Token $model) {
            if (empty($model->token)) {
                $model->generateToken();
            }
        });
    }

    /**
     * Generate tokens
     *
     * @return string
     */
    public function generateToken(): string
    {
        $this->refresh_token = str_random();

        return $this->token = str_random();
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return string
     */
    public function getRefreshToken(): string
    {
        return $this->refresh_token;
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}