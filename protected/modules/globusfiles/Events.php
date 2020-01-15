<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\globusfiles;

use Yii;
use yii\helpers\Url;

class Events
{
    public static function onSpaceMenuInit($event)
    {
        if ($event->sender->space !== null && $event->sender->space->isModuleEnabled('globusfiles')) {
            $event->sender->addItem([
                'label' => 'Globus',
                'group' => 'modules',
                'url' => $event->sender->space->createUrl('/globusfiles/browse/'),
                'icon' => '<i class="fa fa-files-o"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'globusfiles')
            ]);
        }
    }

    public static function onProfileMenuInit($event)
    {
        if ($event->sender->user !== null && $event->sender->user->isModuleEnabled('globusfiles')) {
            $event->sender->addItem([
                'label' => 'Globus',
                'url' => $event->sender->user->createUrl('/globusfiles/browse'),
                'icon' => '<i class="fa fa-folder-open"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'globusfiles')
            ]);
        }
    }

}
