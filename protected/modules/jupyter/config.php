<?php

use humhub\modules\space\widgets\Menu;
use humhub\modules\user\widgets\ProfileMenu;

/** @noinspection MissedFieldInspection */
return [
    'id' => 'jupyter',
    'class' => 'humhub\modules\jupyter\Module',
    'namespace' => 'humhub\modules\jupyter',
    'events' => [
        [Menu::class, Menu::EVENT_INIT, ['humhub\modules\jupyter\Events', 'onSpaceMenuInit']],
        [ProfileMenu::class, ProfileMenu::EVENT_INIT, ['humhub\modules\jupyter\Events', 'onProfileMenuInit']]
    ]
];



