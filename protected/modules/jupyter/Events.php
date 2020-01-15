<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\jupyter;

use Yii;
use yii\helpers\Url;

class Events
{
    public static function onSpaceMenuInit($event)
    {
        if ($event->sender->space !== null && $event->sender->space->isModuleEnabled('jupyter')) {
            $event->sender->addItem([
                'label' => 'Jupyter',
                'group' => 'modules',
                'url' => $event->sender->space->createUrl('/jupyter/browse/'),
                'icon' => '<i class="fa fa-files-o"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'jupyter')
            ]);
        }
    }

    public static function onProfileMenuInit($event)
    {
        if ($event->sender->user !== null && $event->sender->user->isModuleEnabled('jupyter')) {
            $event->sender->addItem([
                'label' => 'Jupyter',
                'url' => $event->sender->user->createUrl('/jupyter/browse'),
                'icon' => '<i class="fa fa-flask"></i>',
                'isActive' => (Yii::$app->controller->module && Yii::$app->controller->module->id == 'jupyter')
            ]);
        }
    }

}
