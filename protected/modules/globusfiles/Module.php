<?php
/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\globusfiles;

use Yii;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use humhub\modules\content\components\ContentContainerModule;
use humhub\modules\content\components\ContentContainerActiveRecord;
use yii\helpers\Url;

class Module extends ContentContainerModule
{
    public function getContentContainerTypes()
    {
        // This content container can be assigned to Spaces and User
        return [
            User::className()
        ];
    }

    // Is called when the whole module is disabled
    public function disable()
    {
        // Clear all Module data and call parent disable!
        parent::disable();
    }

    // Is called when the module is disabled on a specific container
    public function disableContentContainer(ContentContainerActiveRecord $container)
    {
        parent::disableContentContainer($container);
        //Here you can clear all data related to the given container
    }

    /**
     * @inheritdoc
     */
    public function getPermissions($contentContainer = null)
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getContentContainerName(ContentContainerActiveRecord $container)
    {
        return 'Globus Files';
    }

    // Can be used to define a specific description text for different container types
    public function getContentContainerDescription(ContentContainerActiveRecord $container)
    {
        if ($container instanceof Space) {
            return 'Space Globus File System';
        } elseif ($container instanceof User) {
            return 'User Globus File System';
        }
    }

    /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to([
            '/globusfiles/config'
        ]);
    }

}
