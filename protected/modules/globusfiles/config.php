<?php

use humhub\modules\space\widgets\Menu;
use humhub\modules\user\widgets\ProfileMenu;

/** @noinspection MissedFieldInspection */
return [
    'id' => 'globusfiles',
    'class' => 'humhub\modules\globusfiles\Module',
    'namespace' => 'humhub\modules\globusfiles',
    'events' => [
        [Menu::class, Menu::EVENT_INIT, ['humhub\modules\globusfiles\Events', 'onSpaceMenuInit']],
        [ProfileMenu::class, ProfileMenu::EVENT_INIT, ['humhub\modules\globusfiles\Events', 'onProfileMenuInit']]
    ]
];



