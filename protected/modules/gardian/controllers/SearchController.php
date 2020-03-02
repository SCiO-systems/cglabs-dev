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
        if(Yii::$app->request->post('keywords')){
            $keywords = Yii::$app->request->post('keywords');
            $indexResponseDatasets = $this->queryGardianAPI("dataset",$keywords);
            $indexResponsePublications = $this->queryGardianAPI("publication",$keywords);
            $datasets = $this->translateDataset($indexResponseDatasets);
            $publications = $this->translatePublication($indexResponsePublications);
            $session->set('keywords', $keywords);
        }elseif($session->has('keywords')){
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
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'attributes' => [ 'title','publicationYear'],
                'defaultOrder' => [
                    'publicationYear' => SORT_ASC,
                ]
            ],
        ]);

        $publicationDataProvider = new ArrayDataProvider([
            'allModels' => $publications,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'attributes' => [ 'title','publicationYear'],
                'defaultOrder' => [
                    'publicationYear' => SORT_ASC,
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
        $userPath = Yii::$app->user->getGuid();
        $userPath = '/opt/labsspace/'.$userPath;

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
