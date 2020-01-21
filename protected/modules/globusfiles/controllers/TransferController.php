<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2017 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\globusfiles\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\web\HttpException;
use yii\helpers\Url;
use humhub\modules\globusfiles\models\File;
use humhub\modules\globusfiles\models\Folder;


/**
 * Description of BrowseController
 *
 * @author luke, Sebastian Stumpf
 */
class TransferController extends BrowseController
{

    /**
     * Action to edit a given folder.
     *
     * @return string
     */
    public function actionItem($path,$type)
    {
        $username = Yii::$app->user->identity->username;
        $url = Url::toRoute('/u/'.$username.'/globusfiles/browse/transfer?path='.$path.'&type='.$type);

        //initiate tranfer
        return $this->renderPartial('modal_tranfer_item', [
            'submitUrl' => $url
        ]);
    }
}
