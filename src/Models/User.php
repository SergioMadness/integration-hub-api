<?php namespace professionalweb\IntegrationHub\IntegrationHub\Models;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model as BaseModel;
use professionalweb\IntegrationHub\IntegrationHubDB\Interfaces\Model;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models\User as IUser;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models\Token as IToken;

/**
 * User
 * @package professionalweb\IntegrationHub\IntegrationHub\Models
 */
class User extends BaseModel implements Model, IUser, Arrayable, Authenticatable
{
    use \Illuminate\Auth\Authenticatable;

    /**
     * Generate token
     *
     * @return Token
     */
    public function generateToken(): IToken
    {
        return new Token();
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     *
     * @return $this
     */
    public function setLogin(?string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }
}