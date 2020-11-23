<?php

use humhub\modules\space\widgets\Menu;
use humhub\modules\user\widgets\ProfileMenu;

/** @noinspection MissedFieldInspection */
return [
    'id' => 'map',
    'class' => 'humhub\modules\map\Module',
    'namespace' => 'humhub\modules\power',
    'events' => [
        [Menu::class, Menu::EVENT_INIT, ['humhub\modules\power\Events', 'onSpaceMenuInit']],
        [ProfileMenu::class, ProfileMenu::EVENT_INIT, ['humhub\modules\power\Events', 'onProfileMenuInit']]
    ]
];



