<?php

namespace Biigle\Modules\AuthHaai;

use Exception;
use GuzzleHttp\RequestOptions;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

/**
 * @see https://nfdi-aai.de/infraproxy
 */
class SocialiteProvider extends AbstractProvider
{
    public const IDENTIFIER = 'HAAI';

    protected $scopes = ['openid', 'email', 'profile'];

    protected $scopeSeparator = ' ';

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        // Remove client ID and secret because they are sent in the Authorization header.
        $fields = parent::getTokenFields($code);
        unset($fields['client_id']);
        unset($fields['client_secret']);

        return $fields;
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenHeaders($code)
    {
        $headers = parent::getTokenHeaders($code);
        $headers['Authorization'] = 'Basic '.base64_encode($this->clientId.':'.$this->clientSecret);

        return $headers;
    }

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state): string
    {
        return $this->buildAuthUrlFromBase('https://login.helmholtz.de/oauth2-as/oauth2-authz', $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl(): string
    {
        return 'https://login.helmholtz.de/oauth2/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://login.helmholtz.de/oauth2/userinfo', [
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer '.$token,
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User)->setRaw($user)->map([
            'id'          => $user['sub'],
            'name'        => $user['name'] ?? '',
            'given_name'  => $user['given_name'],
            'family_name' => $user['family_name'],
            'email'       => $user['email'],
        ]);
    }
}
