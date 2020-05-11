<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\gardian;

use Yii;
use yii\helpers\Url;

class Events
{
    public static function onSpaceMenuInit($event)
    {
        if ($event->sender->space !== null && $event->sender->space->isModuleEnabled('gardian')) {
            $event->sender->addItem([
                'label' => 'Find Data',
                'group' => 'modules',
                'url' => $event->sender->space->createUrl('/gardian/search/'),
                'icon' => '<i class="fa fa-search"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'gardian')
            ]);
        }
    }

    public static function onProfileMenuInit($event)
    {
        if ($event->sender->user !== null && $event->sender->user->isModuleEnabled('gardian')) {
            $event->sender->addItem([
                'label' => 'Find Data',
                'url' => $event->sender->user->createUrl('/gardian/search'),
                'icon' => '<i class="fa fa-search"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'gardian')
            ]);
        }
    }

}
