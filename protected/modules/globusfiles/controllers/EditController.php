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
        $space = $this->contentContainer;
        $className = $space::className();

        if(strcmp($className,'humhub\modules\space\models\Space') == 0){
            $spaceName = strtolower($space->getDisplayName());
            $url = Url::toRoute('/s/'.$spaceName.'/globusfiles/browse/directory?path='.$path);
        }else{
            $username = Yii::$app->user->identity->username;
            $url = Url::toRoute('/u/'.$username.'/globusfiles/browse/directory?path='.$path);
        }

        $folder = $this->getCurrentFolder($this->globusRoot,$path,"88798b42-41da-11ea-9712-021304b0cca7");
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
        $space = $this->contentContainer;
        $className = $space::className();

        if(strcmp($className,'humhub\modules\space\models\Space') == 0){
            $spaceName = strtolower($space->getDisplayName());
            $url = Url::toRoute('/s/'.$spaceName.'/globusfiles/browse/renamedirectory?path='.$path);
        }else{
            $username = Yii::$app->user->identity->username;
            $url = Url::toRoute('/u/'.$username.'/globusfiles/browse/renamedirectory?path='.$path);
        }

        $folder = $this->getCurrentFolder($this->globusRoot,$path,"88798b42-41da-11ea-9712-021304b0cca7");
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
        $space = $this->contentContainer;
        $className = $space::className();

        if(strcmp($className,'humhub\modules\space\models\Space') == 0){
            $spaceName = strtolower($space->getDisplayName());
            $url = Url::toRoute('/s/'.$spaceName.'/globusfiles/browse/archive?path='.$path);
        }else{
            $username = Yii::$app->user->identity->username;
            $url = Url::toRoute('/u/'.$username.'/globusfiles/browse/archive?path='.$path);
        }

        $tempPath = explode("/",$path);
        $levels = count($tempPath);
        $tempPath[$levels-1] = "";
        $currentPath = implode("/",$tempPath);

        $folder = $this->getCurrentFolder($this->globusRoot,$currentPath,"88798b42-41da-11ea-9712-021304b0cca7");

        return $this->renderPartial('modal_edit_file', [
            'folder' => $folder,
            'submitUrl' => $url
        ]);
    }
}
