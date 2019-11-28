<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS KONSTANTINIDIS
 * Date: 28/11/2019
 * Time: 15:13
 */

namespace humhub\modules\user\authclient;

use yii\authclient\OAuth2;

class Globus extends OAuth2
{
    public $authUrl = 'https://auth.globus.org/v2/oauth2/authorize';
    public $tokenUrl = 'https://auth.globus.org/v2/oauth2/token';
    public $apiBaseUrl = 'https://auth.globus.org/v2/oauth2';

    protected function initUserAttributes()
    {
        return $this->api('userinfo', 'GET');
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
}
