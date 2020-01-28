<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 30/12/2019
 * Time: 17:01
 */

namespace humhub\modules\jupyter\controllers;

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
        return $this->render('index', [
            'contentContainer' => $this->contentContainer
            ]
        );
    }

    public function actionJupyter()
    {
        $guid = Yii::$app->user->getGuid();
        $authClient = Yii::$app->user->getCurrentAuthClient();

        if($authClient == null){
            $authClient = Yii::$app->authClientCollection->getClients()["globus"];
        }

        $username = $authClient->getUserAttributes()['preferred_username'];
        $username_pieces = explode("@",$username);


        $link = 'https://labs.scio.systems:8000/user/'.$username_pieces[0].'/lab?guid='.$guid;
        $this->redirect($link);
    }
}
