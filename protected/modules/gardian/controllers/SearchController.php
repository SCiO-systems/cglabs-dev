<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 30/12/2019
 * Time: 17:01
 */

namespace humhub\modules\gardian\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\helpers\Url;

class SearchController extends BaseController
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $keywords = Yii::$app->request->post('keywords');

        //call gardian api

        $datasets = array();

        $datasets[] = "test_1";
        $datasets[] = "test_2";

        $publications = array();

        $publications[] = "ptest_1";
        $publications[] = "ptest_2";



        return $this->render('index', [
            'contentContainer' => $this->contentContainer,
            'datasets' => $datasets,
            'publications' => $publications
            ]
        );
    }

    public function actionDownload($identifier){



    }
}
