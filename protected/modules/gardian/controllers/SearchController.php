<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 30/12/2019
 * Time: 17:01
 */

namespace humhub\modules\gardian\controllers;

use humhub\modules\gardian\models\Dataset;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\VarDumper;
use yii\helpers\Url;
use yii\helpers\FileHelper;
use yii\helpers\Json;

class SearchController extends BaseController
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $session = Yii::$app->session;

        $space = $this->contentContainer;
        $className = $space::className();

        if(strcmp($className,'humhub\modules\space\models\Space') == 0){
            $spaceName = strtolower($space->getDisplayName());
            $sessionKey = $spaceName.'skeywords';
        }else{
            $sessionKey = 'ukeywords';
        }


        if(Yii::$app->request->post('keywords')){
            $keywords = Yii::$app->request->post('keywords');
            $indexResponseDatasets = $this->queryGardianAPI("dataset",$keywords);
            $indexResponsePublications = $this->queryGardianAPI("publication",$keywords);
            $datasets = $this->translateDataset($indexResponseDatasets);
            $publications = $this->translatePublication($indexResponsePublications);
            $session->set($sessionKey, $keywords);
        }elseif($session->has($sessionKey)){
            $keywords = $session->get('keywords');
            $indexResponseDatasets = $this->queryGardianAPI("dataset",$keywords);
            $indexResponsePublications = $this->queryGardianAPI("publication",$keywords);
            $datasets = $this->translateDataset($indexResponseDatasets);
            $publications = $this->translatePublication($indexResponsePublications);
        }else{
            $datasets = array();
            $publications = array();
            $keywords = "";
        }



        $datasetDataProvider = new ArrayDataProvider([
            'allModels' => $datasets,
            'sort' => [
                'attributes' => [ 'title','publicationYear'],
                'defaultOrder' => [
                    'publicationYear' => SORT_DESC,
                ]
            ],
        ]);

        $publicationDataProvider = new ArrayDataProvider([
            'allModels' => $publications,
            'sort' => [
                'attributes' => [ 'title','publicationYear'],
                'defaultOrder' => [
                    'publicationYear' => SORT_DESC,
                ]
            ],
        ]);


        return $this->render('index', [
            'contentContainer' => $this->contentContainer,
            'datasets' => $datasetDataProvider,
            'publications' => $publicationDataProvider,
            'keywords' => $keywords
            ]
        );
    }

    public function actionDownload(){

        $datasets = Yii::$app->request->post('datasets');


        $space = $this->contentContainer;
        $className = $space::className();

        if(strcmp($className,'humhub\modules\space\models\Space') == 0){
            $spaceName = strtolower($space->getDisplayName());
            $spaceName = str_replace(' ', 's', $spaceName);
            $spaceName = str_replace('-', 's', $spaceName);
            $guid = preg_replace('/[^A-Za-z0-9\-]/', 's', $spaceName);
            $userPath = '/opt/labsspace/'.$guid;
        }else{
            $guid = Yii::$app->user->getGuid();
            $userPath = '/opt/labsspace/'.$guid;
        }


        $notAccessible = 'false';
        foreach ($datasets as $dataset)
        {
            $title = $this->normalizeString($dataset["title"]);
            $files = $dataset["files"];
            FileHelper::createDirectory($userPath."/".$title, $mode = 0777, $recursive = true);
            foreach ($files as $file){
                $accessibility = $file["accessibility"];
                if(strcmp($accessibility,'open')==0){
                    $filename = $file["filename"];
                    $downloadLink = $file["downloadLink"];
                    file_put_contents($userPath."/".$title."/".$filename, fopen($downloadLink, 'r'));
                }else{
                    $notAccessible = 'true';
                }
            }
        }

        $username = Yii::$app->user->identity->username;
        $result = array();
        $result["notAccessible"] = $notAccessible;
        $result["username"] = $username;


        echo Json::encode($result);
    }

    public function normalizeString($string)
    {
        $str = strip_tags($string);
        $str = preg_replace('/[\r\n\t ]+/', ' ', $str);
        $str = preg_replace('/[\"\*\/\:\<\>\?\'\|]+/', ' ', $str);
        $str = strtolower($str);
        $str = html_entity_decode( $str, ENT_QUOTES, "utf-8" );
        $str = htmlentities($str, ENT_QUOTES, "utf-8");
        $str = preg_replace("/(&)([a-z])([a-z]+;)/i", '$2', $str);
        $str = str_replace(' ', '-', $str);
        $str = rawurlencode($str);
        $str = str_replace('%', '-', $str);

        return $str;

    }
}
