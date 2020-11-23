<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\map;

use Yii;
use yii\helpers\Url;

class Events
{
    public static function onSpaceMenuInit($event)
    {
        if ($event->sender->space !== null && $event->sender->space->isModuleEnabled('power')) {
            $event->sender->addItem([
                'label' => 'Weather Data',
                'group' => 'modules',
                'url' => $event->sender->space->createUrl('/power/browse/'),
                'icon' => '<i class="fa-sun-o"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'power')
            ]);
        }
    }

    public static function onProfileMenuInit($event)
    {
        if ($event->sender->user !== null && $event->sender->user->isModuleEnabled('power')) {
            $event->sender->addItem([
                'label' => 'Weather Data',
                'url' => $event->sender->user->createUrl('/power/browse'),
                'icon' => '<i class="fa-sun-o"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'power')
            ]);
        }
    }

}
