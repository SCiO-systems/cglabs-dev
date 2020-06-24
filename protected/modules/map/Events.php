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
        if ($event->sender->space !== null && $event->sender->space->isModuleEnabled('map')) {
            $event->sender->addItem([
                'label' => 'Geospatial Exploration',
                'group' => 'modules',
                'url' => $event->sender->space->createUrl('/map/browse/'),
                'icon' => '<i class="fa fa-globe"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'map')
            ]);
        }
    }

    public static function onProfileMenuInit($event)
    {
        if ($event->sender->user !== null && $event->sender->user->isModuleEnabled('map')) {
            $event->sender->addItem([
                'label' => 'Geospatial Exploration',
                'url' => $event->sender->user->createUrl('/map/browse'),
                'icon' => '<i class="fa fa-globe"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'map')
            ]);
        }
    }

}
