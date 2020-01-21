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
class EditController extends BrowseController
{

    /**
     * Action to edit a given folder.
     *
     * @return string
     */
    public function actionFolder($path)
    {
        $username = Yii::$app->user->identity->username;
        $url = Url::toRoute('/u/'.$username.'/globusfiles/browse/directory?path='.$path);

        $folder = $this->getCurrentFolder($this->globusRoot,$path,"b973640c-3c3a-11ea-ab4c-0a7959ea6081");
        return $this->renderPartial('modal_edit_folder', [
            'folder' => $folder,
            'submitUrl' => $url
        ]);
    }

    /**
     * Action to edit a given folder.
     *
     * @return string
     */
    public function actionRenamefolder($path)
    {
        $username = Yii::$app->user->identity->username;
        $url = Url::toRoute('/u/'.$username.'/globusfiles/browse/renamedirectory?path='.$path);

        $folder = $this->getCurrentFolder($this->globusRoot,$path,"b973640c-3c3a-11ea-ab4c-0a7959ea6081");
        return $this->renderPartial('modal_edit_folder', [
            'folder' => $folder,
            'submitUrl' => $url
        ]);
    }

    /**
     * Action to edit a given file.
     *
     * @return string
     */
    public function actionFile($path)
    {
        $username = Yii::$app->user->identity->username;
        $url = Url::toRoute('/u/'.$username.'/globusfiles/browse/archive?path='.$path);


        $tempPath = explode("/",$path);
        $levels = count($tempPath);
        $tempPath[$levels-1] = "";
        $currentPath = implode("/",$tempPath);

        $folder = $this->getCurrentFolder($this->globusRoot,$currentPath,"b973640c-3c3a-11ea-ab4c-0a7959ea6081");

        return $this->renderPartial('modal_edit_file', [
            'folder' => $folder,
            'submitUrl' => $url
        ]);
    }
}
