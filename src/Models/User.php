<?php namespace professionalweb\IntegrationHub\IntegrationHub\Models;

use Illuminate\Support\Collection;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model as BaseModel;
use professionalweb\IntegrationHub\IntegrationHubCommon\Interfaces\Models\Model;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models\User as IUser;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models\Token as IToken;

/**
 * User
 * @package professionalweb\IntegrationHub\IntegrationHub\Models
 *
 * @property string     $id
 * @property string     $login
 * @property string     $password
 * @property bool       $is_active
 * @property array      $settings
 * @property string     $created_at
 * @property string     $updated_at
 *
 * @property Collection $tokens
 */
class User extends BaseModel implements Model, IUser, Authenticatable
{
    use \Illuminate\Auth\Authenticatable;

    protected $table = 'users';

    protected $keyType = 'string';

    protected $fillable = ['login', 'password'];

    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * Generate token
     *
     * @return Token
     */
    public function generateToken(): IToken
    {
        $token = new Token();
        $this->tokens()->save($token);

        return $token;
    }

    /**
     * @param string $password
     *
     * @return bool
     */
    public function validatePassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    /**
     * @param string $password
     */
    public function setPasswordAttribute(?string $password): void
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * @return HasMany
     */
    public function tokens(): HasMany
    {
        return $this->hasMany(Token::class, 'user_id');
    }
}