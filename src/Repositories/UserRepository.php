<?php namespace professionalweb\IntegrationHub\IntegrationHub\Repositories;

use professionalweb\IntegrationHub\IntegrationHub\Models\User;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models\Token;
use professionalweb\IntegrationHub\IntegrationHub\Models\Token as TokenModel;
use professionalweb\IntegrationHub\IntegrationHubDB\Repositories\BaseRepository;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models\User as IUser;
use professionalweb\IntegrationHub\IntegrationHub\Interfaces\Repositories\UserRepository as IUserRepository;

/**
 * User repository
 * @package App\Repositories
 */
class UserRepository extends BaseRepository implements IUserRepository
{

    public function __construct()
    {
        $this->setModelClass(User::class);
    }

    /**
     * Get user by token
     *
     * @param string $token
     *
     * @return IUser
     */
    public function getByToken(string $token): ?IUser
    {
        /** @var TokenModel $tokenO */
        $tokenO = TokenModel::query()->where('token', $token)->first();

        return $tokenO !== null ? $tokenO->user : null;
    }

    /**
     * Refresh user token
     *
     * @param string $token
     * @param string $refreshToken
     *
     * @return Token
     * @throws \Exception
     */
    public function refreshToken(string $token, string $refreshToken): Token
    {
        /** @var TokenModel $tokenO */
        $tokenO = TokenModel::query()->where('token', $token)->first();
        if ($tokenO !== null && $tokenO->refresh_token === $refreshToken) {
            $user = $tokenO->user;
            $tokenO->delete();

            return $user->generateToken();
        }

        return null;
    }

    /**
     * Get user by login and password
     *
     * @param string $login
     * @param string $password
     *
     * @return IUser|null
     */
    public function getByCredentials(string $login, string $password): ?IUser
    {
        /** @var User $user */
        $user = User::query()->where('login', $login)->first();
        if ($user->validatePassword($password)) {
            return $user;
        }

        return null;
    }
}