<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 30/12/2019
 * Time: 17:01
 */

namespace humhub\modules\map\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\helpers\Url;

class BrowseController extends BaseController
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {

        $space = $this->contentContainer;
        $className = $space::className();

        $guid = Yii::$app->user->getGuid();
        if(strcmp($className,'humhub\modules\space\models\Space') == 0){
            $spaceName = strtolower($space->getDisplayName());
            $spaceName = str_replace(' ', 's', $spaceName);
            $spaceName = str_replace('-', 's', $spaceName);
            $spaceName = preg_replace('/[^A-Za-z0-9\-]/', 's', $spaceName);
            $this->createRootFolder($spaceName,$this->globusRoot);
        }else{
            $this->createRootFolder($guid,$this->globusRoot);
        }

        return $this->render('index', [
            'contentContainer' => $this->contentContainer
            ]
        );
    }

    public function actionJupyter()
    {
        $space = $this->contentContainer;
        $className = $space::className();

        $guid = Yii::$app->user->getGuid();
        if(strcmp($className,'humhub\modules\space\models\Space') == 0){
            $sguid = $space->guid;
            $spaceName = strtolower($space->getDisplayName());
            $spaceName = str_replace(' ', 's', $spaceName);
            $spaceName = str_replace('-', 's', $spaceName);
            $spaceName = preg_replace('/[^A-Za-z0-9\-]/', 's', $spaceName);
            $this->createRootFolder($spaceName,$this->globusRoot);
        }else{
            $sguid = '';
            $this->createRootFolder($guid,$this->globusRoot);
        }


        $authClient = Yii::$app->user->getCurrentAuthClient();

        if($authClient == null){
            $authClient = Yii::$app->authClientCollection->getClients()["globus"];
        }

        $username = $authClient->getUserAttributes()['preferred_username'];
        $username_pieces = explode("@",$username);


        //$link = 'https://labs.scio.systems:8000/user/'.$username_pieces[0].'/lab?guid='.$guid;
        $link = 'https://labs.scio.systems:8000/user/'.$username_pieces[0].'/lab?guid='.$guid.'&sguid='.$sguid;


        $this->redirect($link);
    }
}
