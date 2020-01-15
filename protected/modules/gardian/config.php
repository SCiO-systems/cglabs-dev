<?php

use humhub\modules\space\widgets\Menu;
use humhub\modules\user\widgets\ProfileMenu;

/** @noinspection MissedFieldInspection */
return [
    'id' => 'gardian',
    'class' => 'humhub\modules\gardian\Module',
    'namespace' => 'humhub\modules\gardian',
    'events' => [
        [Menu::class, Menu::EVENT_INIT, ['humhub\modules\gardian\Events', 'onSpaceMenuInit']],
        [ProfileMenu::class, ProfileMenu::EVENT_INIT, ['humhub\modules\gardian\Events', 'onProfileMenuInit']]
    ]
];



