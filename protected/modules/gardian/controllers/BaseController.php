<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 26/12/2019
 * Time: 11:55
 */

namespace humhub\modules\gardian\controllers;

use humhub\modules\gardian\models\ContentProvider;
use humhub\modules\gardian\models\Dataset;
use humhub\modules\gardian\models\File;
use humhub\modules\gardian\models\License;
use humhub\modules\gardian\models\Publication;
use Yii;
use humhub\modules\content\components\ContentContainerController;
use yii\helpers\FileHelper;
use yii\helpers\VarDumper;



abstract class BaseController extends ContentContainerController
{

    public function activateAPI()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://gardian.bigdata.cgiar.org/api/v2/getAccessToken.php?=",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('email' => 'info@scio.systems','password' => 'PbMQfDkgEs27Qvzs','clientId' => 'lIzdujOxJyohwleZvsGSJWoCEw9pQBxQ'),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: multipart/form-data"
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response)->access_token;
    }

    public function queryGardianAPI($resourceType,$keywords,$size = 100)
    {
        $access_token = $this->activateAPI();

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://gardian.bigdata.cgiar.org/api/v2/searchGARDIANbyKeyword.php",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('type' => $resourceType,'keywords' => $keywords,'size' => $size),
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
                "authorization: Bearer ".$access_token,
                "Content-Type: multipart/form-data"
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    public function translateDataset($indexResponse){
        $response = json_decode($indexResponse,true);

        $results = array();
        foreach ($response as $source){

            $document = $source["_source"]["DatasetMetadata"];
            $id = $document["QuantumId"];
            $accessibility = $document["Accessibility"];
            $title = $document["Title"];
            $publicationYear = $document["PubYear"];
            $authors = $document["Authors"];

            $contentProvidersElement = $document["ContentProvider"];
            $contentProviders = $this->translateContentProvider($contentProvidersElement);

            $filesElement = $document["Files"];
            $files = $this->translateFiles($filesElement);

            $summary = $document["Summary"];
            $extractedMetadata = $document["ExtractedMetadata"];

            $license = $this->translateLicense($extractedMetadata);
            //$citation = $document["Citation"];

            $doiElement = $document["DOI"];
            if(!empty($doiElement)){
                $doi = $doiElement[0]["link"];
            }else{
                $doi = "";
            }
            $result = new Dataset($accessibility,$title,$publicationYear,$authors,$contentProviders,$files,$summary,$license,"",$doi,$id);
            $results[] = $result;
        }
        return $results;
    }

    public function translatePublication($indexResponse){
        $response = json_decode($indexResponse,true);
        $results = array();
        foreach ($response as $source){

            $document = $source["_source"]["PubMetadata"];
            $id = $document["QuantumId"];
            $accessibility = $document["IsOpenAccess"];
            $title = $document["Title"];
            $publicationYear = $document["PubYear"];
            $authors = $document["Authors"];

            $contentProvidersElement = $document["ContentProvider"];
            $contentProviders = $this->translateContentProvider($contentProvidersElement);

            $summary = $document["Summary"];
            //$citation = $document["Citation"];
            $doiElement = $document["DOI"];
            if(!empty($doiElement)){
                $doi = $doiElement[0]["link"];
            }else{
                $doi = "";
            }
            $result = new Publication($accessibility,$title,$publicationYear,$authors,$contentProviders,$summary,"",$doi,$id);
            $results[] = $result;
        }
        return $results;
    }

    public function translateLicense($extractedMetadata){
        foreach ($extractedMetadata as $vocabulary){
            if(strcmp($vocabulary["vocabulary"],"license")==0){
                if(!empty($vocabulary["data"])){
                    $term = $vocabulary["data"][0]["term"];
                    $url = $vocabulary["data"][0]["URL"];
                    $image = $vocabulary["data"][0]["image"];

                    return $license = new License($term,$url,$image);
                }
            }
        }
        return array();
    }

    public function translateContentProvider($contentProviders){
        $translatedContentProviders = array();

        foreach ($contentProviders as $contentProvider){
            $providerLink = $contentProvider["ProviderLink"][0]["link"];
            $contentProviderID = $contentProvider["ContentProviderID"];
            $contentProviderName = $contentProvider["ContentProviderName"];

            if(!empty($contentProvider["HDL"])){
                $hdl = $contentProvider["HDL"][0]["link"];
            }else{
                $hdl = "";
            }

            $translatedContentProvider = new ContentProvider($providerLink,$contentProviderID,$contentProviderName,$hdl);
            $translatedContentProviders[] = $translatedContentProvider;
        }

        return $translatedContentProviders;
    }

    public function translateFiles($files){
        $translatedFiles = array();

        foreach ($files as $file){
            $filename = $file["filename"];
            $contentType = $file["ContentType"];
            $accessibility = $file["Accessibility"];
            $downloadLink = $file["DownloadLink"];
            $translatedFile = new File($filename,$contentType,$accessibility,$downloadLink);
            $translatedFiles[] = $translatedFile;
        }
        return $translatedFiles;
    }

}
