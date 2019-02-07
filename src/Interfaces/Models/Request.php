<?php namespace professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models;

/**
 * Constants used in http requests and responses
 * @package professionalweb\IntegrationHub\IntegrationHub\Interfaces\Models
 */
interface Request
{
    public const TOKEN_HEADER_NAME = 'x-pw-token';

    public const REFRESH_TOKEN_HEADER_NAME = 'x-pw-refresh-token';
}