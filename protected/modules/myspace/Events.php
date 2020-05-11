<?php

namespace humhub\modules\myspace;

use Yii;
/**
 * Description of CalendarEvents
 *
 * @author luke
 */
class Events
{
    public static function onTopMenuInit($event)
    {
        $username = Yii::$app->user->identity->username;

        $mySpaceLink = "https://labs.scio.systems/index.php/u/".$username."/user/profile/home";
        $myModulesLink = "https://labs.scio.systems/index.php/user/account/edit-modules";

        $event->sender->addItem([
            'label' => 'My Space',
            'url' => $mySpaceLink,
            'icon' => '<i class="fa fa-user"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'myspace' && Yii::$app->controller->id == 'global'),
            'sortOrder' => 0,
            ]);

        $event->sender->addItem([
            'label' => 'My Modules',
            'url' => $myModulesLink,
            'icon' => '<i class="fa fa-cogs"></i>',
            'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'myspace' && Yii::$app->controller->id == 'global'),
            'sortOrder' => 0,
        ]);
    }
}
