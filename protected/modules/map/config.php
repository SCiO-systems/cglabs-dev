<?php

use humhub\modules\space\widgets\Menu;
use humhub\modules\user\widgets\ProfileMenu;

/** @noinspection MissedFieldInspection */
return [
    'id' => 'map',
    'class' => 'humhub\modules\map\Module',
    'namespace' => 'humhub\modules\map',
    'events' => [
        [Menu::class, Menu::EVENT_INIT, ['humhub\modules\map\Events', 'onSpaceMenuInit']],
        [ProfileMenu::class, ProfileMenu::EVENT_INIT, ['humhub\modules\map\Events', 'onProfileMenuInit']]
    ]
];



