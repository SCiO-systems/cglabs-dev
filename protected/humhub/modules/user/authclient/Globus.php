<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS KONSTANTINIDIS
 * Date: 28/11/2019
 * Time: 15:13
 */

namespace humhub\modules\user\authclient;

use yii\authclient\OAuth2;
use yii;

class Globus extends OAuth2 implements interfaces\ApprovalBypass
{
    public $authUrl = 'https://auth.globus.org/v2/oauth2/authorize';
    public $tokenUrl = 'https://auth.globus.org/v2/oauth2/token';
    public $apiBaseUrl = 'https://auth.globus.org/v2/oauth2';

    protected function initUserAttributes()
    {
        $attributes = $this->api('userinfo', 'GET');
        return $attributes;
    }

    protected function defaultName()
    {
        return "globus_auth_client";
    }

    protected function defaultTitle(){
        return "Globus";
    }

    protected function defaultViewOptions()
    {

        return [
            'popupWidth' => 860,
            'popupHeight' => 480,
            'buttonBackgroundColor' => '#e0492f',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function applyAccessTokenToRequest($request, $accessToken)
    {
        $request->getHeaders()->set('Authorization', 'Bearer '. $accessToken->getToken());
    }

    /**
     * @inheritdoc
     */
    protected function defaultNormalizeUserAttributeMap()
    {
        return [
            'id' => function($attributes){
                return $attributes['sub'];
            },
            'firstname' => function($attributes){
                $parts = preg_split('/\s+/', $attributes['name']);
                return $parts[0];
            },
            'username' => 'displayName',
            'lastname' => function ($attributes) {
                $parts = preg_split('/\s+/', $attributes['name']);
                return $parts[1];
            },
            'email' => function ($attributes) {
                return $attributes['email'];
            }
        ];
    }

}
