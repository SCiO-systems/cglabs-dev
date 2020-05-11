<?php

use humhub\widgets\TopMenu;
use humhub\modules\myspace\Events;

return [
    'id' => 'myspace',
    'class' => 'humhub\modules\myspace\Module',
    'namespace' => 'humhub\modules\myspace',
    'events' => [
        ['class' => TopMenu::class, 'event' => TopMenu::EVENT_INIT, 'callback' => [Events::class, 'onTopMenuInit']]
    ],
];
