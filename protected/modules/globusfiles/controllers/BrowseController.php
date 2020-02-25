<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 30/12/2019
 * Time: 17:01
 */

namespace humhub\modules\globusfiles\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\helpers\Url;

class BrowseController extends BaseController
{
    public $globusRoot = '/home/data/';

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex($path = "")
    {

        if (empty($path) == TRUE){
            $path = Yii::$app->user->getGuid();
        }else{
            if(strcmp($path[0],"/")==0){
                $path = substr($path,1);
            }
        }

        $folder = $this->getCurrentFolder($this->globusRoot,$path,'88798b42-41da-11ea-9712-021304b0cca7');

        return $this->render('index', [
            'folder' => $folder,
            'contentContainer' => $this->contentContainer
            ]
        );
    }

    public function actionUpload($path = "")
    {
        if (empty($path) == TRUE){
            $path = Yii::$app->user->getGuid();
        }else{
            if(strcmp($path[0],"/")==0){
                $path = substr($path,1);
            }
        }

        $source_endpoint = Yii::$app->request->post('endpoint_id');
        $spath = Yii::$app->request->post('path');
        $folders = Yii::$app->request->post('folder');
        $files = Yii::$app->request->post('file');
        $label = Yii::$app->request->post('label');

        $this->submitTransferTask($source_endpoint,$spath,$path,$folders,$files,$label,"88798b42-41da-11ea-9712-021304b0cca7",$this->globusRoot);

        $folder = $this->getCurrentFolder($this->globusRoot,$path,"88798b42-41da-11ea-9712-021304b0cca7");

        return $this->render('index', [
                'folder' => $folder,
                'contentContainer' => $this->contentContainer
            ]
        );
    }

    public function actionDirectory($path)
    {
        $filename = Yii::$app->request->post('title');
        $fullPath = $path.'/'.$filename;
        $this->createDirectory($this->globusRoot,$fullPath,"88798b42-41da-11ea-9712-021304b0cca7");
        $folder = $this->getCurrentFolder($this->globusRoot,$path,"88798b42-41da-11ea-9712-021304b0cca7");

        return $this->render('index', [
                'folder' => $folder,
                'contentContainer' => $this->contentContainer
            ]
        );
    }

    public function actionRenamedirectory($path)
    {
        $filename = Yii::$app->request->post('title');
        $oldPath = $path;
        $tempPath = explode("/",$path);
        $levels = count($tempPath);
        $tempPath[$levels-1] = $filename;
        $newPath = implode("/",$tempPath);
        $tempPath[$levels-1] = "";
        $currentPath = implode("/",$tempPath);

        $this->renameDirectory($this->globusRoot,$oldPath,$newPath,"88798b42-41da-11ea-9712-021304b0cca7");
        $folder = $this->getCurrentFolder($this->globusRoot,$currentPath,"88798b42-41da-11ea-9712-021304b0cca7");

        return $this->render('index', [
                'folder' => $folder,
                'contentContainer' => $this->contentContainer
            ]
        );
    }

    public function actionArchive($path)
    {
        $tempPath = explode("/",$path);
        $levels = count($tempPath);
        $filename = Yii::$app->request->post('title');
        $tempPath[$levels-1] = $filename;
        $newPath = implode("/",$tempPath);

        $tempPath[$levels-1] = "";
        $currentPath = implode("/",$tempPath);

        $this->renameFile($this->globusRoot,$path,$newPath,"88798b42-41da-11ea-9712-021304b0cca7");
        $folder = $this->getCurrentFolder($this->globusRoot,$currentPath,"88798b42-41da-11ea-9712-021304b0cca7");

        //call base controller

        return $this->render('index', [
                'folder' => $folder,
                'contentContainer' => $this->contentContainer
            ]
        );
    }

    /**
     * Action to delete a file or folder.
     * @return string
     */
    public function actionDelete($path = "")
    {
        $selectedItems = Yii::$app->request->post('selection');

        $this->delete($this->globusRoot,$selectedItems[0],"88798b42-41da-11ea-9712-021304b0cca7");

        if (empty($path) == TRUE){
            $path = Yii::$app->user->getGuid();
        }else{
            if(strcmp($path[0],"/")==0){
                $path = substr($path,1);
            }
        }

        $username = Yii::$app->user->identity->username;
        $url = Url::toRoute('/u/'.$username.'/globusfiles/browse/');

        $this->redirect($url);

    }

    public function actionTransfer($path="",$type="")
    {
        $destination_endpoint = Yii::$app->request->post('destination');

        $source_endpoint = "88798b42-41da-11ea-9712-021304b0cca7";
        $spath = $this->globusRoot.$path;
        $folders = array();
        $files = array();
        if(strcmp($type,"dir")==0){
            $tempPath = explode("/",$path);
            $folders[] = $tempPath[count($tempPath)-1];
        }elseif(strcmp($type,"file")==0){
            $tempPath = explode("/",$path);
            $files[] = $tempPath[count($tempPath)-1];
        }
        $label = "GARDIAN LABS";

        $this->submitDownloadTask($source_endpoint,$spath,$folders,$files,$label,$destination_endpoint,$this->globusRoot);

        $username = Yii::$app->user->identity->username;
        $url = Url::toRoute('/u/'.$username.'/globusfiles/browse/');

        $this->redirect($url);

    }


}
