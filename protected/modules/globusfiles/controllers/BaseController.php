<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 26/12/2019
 * Time: 11:55
 */

namespace humhub\modules\globusfiles\controllers;

use humhub\modules\globusfiles\models\CurrentFolder;
use humhub\modules\globusfiles\models\ParentFolder;
use humhub\modules\user\authclient\AuthClientHelpers;
use Yii;
use humhub\modules\content\components\ContentContainerController;
use yii\helpers\FileHelper;
use yii\helpers\VarDumper;


abstract class BaseController extends ContentContainerController
{

    /**
     * The base api url for transfer operations
     *
     * @var string
     **/
    private $baseUrl = 'https://transfer.api.globusonline.org/v0.10';
    private $labsEndpoint;

    public $currentPath;


    const ROOT_ID = 0;
    const All_POSTED_FILES_ID = -1;

    public $hideSidebar = true;
    public $errorMessages = [];

    public function activationEndpoint()
    {
        $authClient = Yii::$app->user->getCurrentAuthClient();

        if($authClient == null){
            $authClient = Yii::$app->authClientCollection->getClients()["globus"];
        }

        $accessToken = $authClient->getAccessToken();

        $other_tokens = $accessToken->getParam('other_tokens');
        $scope = 'urn:globus:auth:scope:transfer.api.globus.org:all';
        foreach ($other_tokens as &$tokenparams) {
            if(strcmp($tokenparams['scope'],$scope) == 0){
                $token = $tokenparams['access_token'];
            }
        }

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://transfer.api.globus.org/v0.10/endpoint/88798b42-41da-11ea-9712-021304b0cca7/activate",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>"{\n    \"DATA_TYPE\": \"activation_requirements\",\n    \"oauth_server\": null,\n    \"activated\": false,\n    \"expire_time\": null,\n    \"expires_in\": 0,\n    \"myproxy_server\": null,\n    \"auto_activation_supported\": false,\n    \"DATA\": [\n        {\n            \"DATA_TYPE\": \"activation_requirement\",\n            \"type\": \"delegate_proxy\",\n            \"name\": \"public_key\",\n            \"description\": \"The public key of the GO API server to use in the proxy certificate for delegation to GO, in PEM format.\",\n            \"ui_name\": \"Server Public Key\",\n            \"private\": false,\n            \"required\": false,\n            \"value\": \"-----BEGIN PUBLIC KEY-----\\nMIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAuzdD1xkOBZF2dj0GrnQj\\ndbBqGMo3OMYpJ8gT7Ujl1jq4YnKo0ha+mk3yLtSsDxz8uPBOszH5CrowgLTZO9uE\\n8iLymqq3Cm8ZoYmbuaXs1kyFWy4Twu9BPYxRfY/6F93ioOwTdkTMX7AmZ4o2z7lB\\nljtcpRJk+X8IXfKaaNztqKOr/l2vWxNIlRu7daVBE8/oDU6wCy72weQ7oXCDzeE+\\naxtaNyaw57W7SD7s7dwZFKrfmJLCE48v5bAhm0dg+DCB8+ccPKg2apd2dMxxNtU9\\nhy5Sg1hHXZMFoJkLuJ5ycwPnSZs7Arb7BxuX4iteEAAyX2bpLmP9rZI6uWU2lnTZ\\nXI38lWTpiZzLHifiN5k/Rme4VYN7fxhmSWf6zo9RdjEelBQKRMtqUsy581qFEug6\\nDB9l16JOxNUo2B2TQA1hyZscHt26wJS/FLUTGqXU2eXjuNJ+/fghHBbOCA78G7gA\\nmQe2c75kOiWRq8giE3F/6iTDAygdOscO0XYaGI4vX7KbM/YmGiUIErlScKMMDs0s\\nWCCzYATaVQA62fYdurzACWuZXuz2x1SZiX1OKXkryNVNHZTZI0wnfdGQbIRjM+MO\\n9jpKhg6r1NMBiErrA9s+F1nWzZcus/238H38gD2oEW7vr6I9LXVn1pmAhixrb7H9\\nGWY3T+2ouMlNdboP1h+z2sUCAwEAAQ==\\n-----END PUBLIC KEY-----\\n\"\n        },\n        {\n            \"DATA_TYPE\": \"activation_requirement\",\n            \"type\": \"delegate_proxy\",\n            \"name\": \"proxy_chain\",\n            \"description\": \"A proxy certificate using the provided public key, in PEM format.\",\n            \"ui_name\": \"Proxy Chain\",\n            \"private\": false,\n            \"required\": true,\n            \"value\": null\n        },\n        {\n            \"DATA_TYPE\": \"activation_requirement\",\n            \"type\": \"myproxy\",\n            \"name\": \"hostname\",\n            \"description\": \"The hostname of the MyProxy server to request a credential from.\",\n            \"ui_name\": \"MyProxy Server\",\n            \"private\": false,\n            \"required\": true,\n            \"value\": \"ec2-18-191-236-182.us-east-2.compute.amazonaws.com\"\n        },\n        {\n            \"DATA_TYPE\": \"activation_requirement\",\n            \"type\": \"myproxy\",\n            \"name\": \"username\",\n            \"description\": \"The username to use when connecting to the MyProxy server.\",\n            \"ui_name\": \"Username\",\n            \"private\": false,\n            \"required\": true,\n            \"value\": \"dexter\"\n        },\n        {\n            \"DATA_TYPE\": \"activation_requirement\",\n            \"type\": \"myproxy\",\n            \"name\": \"passphrase\",\n            \"description\": \"The passphrase to use when connecting to the MyProxy server.\",\n            \"ui_name\": \"Passphrase\",\n            \"private\": true,\n            \"required\": true,\n            \"value\": \"dexter\"\n        },\n        {\n            \"DATA_TYPE\": \"activation_requirement\",\n            \"type\": \"myproxy\",\n            \"name\": \"server_dn\",\n            \"description\": \"The distinguished name of the MyProxy server, formated with '/' as the separator. This is only needed if the server uses a non-standard certificate and the hostname does not match.\",\n            \"ui_name\": \"Server DN\",\n            \"private\": false,\n            \"required\": false,\n            \"value\": \"/C=US/O=Globus Consortium/OU=Globus Connect Service/CN=8813976a-41da-11ea-9712-021304b0cca7\"\n        },\n        {\n            \"DATA_TYPE\": \"activation_requirement\",\n            \"type\": \"myproxy\",\n            \"name\": \"lifetime_in_hours\",\n            \"description\": \"The lifetime for the credential to request from the server, in hours. Depending on the MyProxy server's configuration, this may not be respected if it's too high. If no lifetime is submitted, the value configured as the default on the  server will be used.\",\n            \"ui_name\": \"Credential Lifetime (hours)\",\n            \"private\": false,\n            \"required\": false,\n            \"value\": null\n        }\n    ]\n}",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer ".$token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
    }

    public function createRootFolder($guid,$globusRoot){

        $user_directory = $globusRoot.$guid;
        if (file_exists($user_directory) != TRUE){
            FileHelper::createDirectory($user_directory, $mode = 0777, $recursive = true);
        }
    }

    /**
     * Returns current folder by given path parameter.
     *
     * @return CurrentFolder
     */
    public function getCurrentFolder($globusRoot,$directory = '',$labsEndpoint,$previousCurrentFolder = NULL)
    {
        $this->currentPath = $globusRoot."/".$directory;
        $guid = Yii::$app->user->getGuid();

        $this->createRootFolder($guid,$globusRoot);
        $this->activationEndpoint();
        $id = $directory;
        $scope = 'urn:globus:auth:scope:transfer.api.globus.org:all';

        $listingUrl = $this->baseUrl."/endpoint/".$labsEndpoint."/ls?path=".$globusRoot.'/'.$directory;
        $authClient = Yii::$app->user->getCurrentAuthClient();

        if($authClient == null){
            $authClient = Yii::$app->authClientCollection->getClients()["globus"];
        }

        $request = $authClient->createRequest()
            ->setMethod('GET')
            ->setUrl($listingUrl);

        $authClient->applyOtherTokenToRequest($request,$authClient->getAccessToken(),$scope);
        $response = $authClient->sendRequest($request);

        $parentFolder = array();
        $username = Yii::$app->user->identity->username;
        $url = '/index.php/u/'.$username.'/globusfiles/browse?path=';
        if(strcmp($directory,$guid)==0){
            $parentFolderInstance = new ParentFolder($guid,$url);
            $parentFolder[] = $parentFolderInstance;
        }else{
            $folderNames = explode('/',$directory);
            foreach ($folderNames as $folderName){
                $url = $url.'/'.$folderName;
                $parentFolderInstance = new ParentFolder($folderName,$url);
                $parentFolder[] = $parentFolderInstance;
            }
        }

        $currentFolder = new CurrentFolder($response["DATA"],$id,$parentFolder);

        return $currentFolder;
    }

    public function createDirectory($globusRoot,$fullPath,$labsEndpoint){

        $this->activationEndpoint();
        $createDirectoryUrl = $this->baseUrl."/operation/endpoint/".$labsEndpoint."/mkdir";
        $fullPath = $globusRoot.$fullPath;

        //echo $fullPath;

        $body = "{\n    \"DATA_TYPE\": \"mkdir\",\n    \"path\": \"".$fullPath."\"\n}";

        $authClient = Yii::$app->user->getCurrentAuthClient();
        if($authClient == null){
            $authClient = Yii::$app->authClientCollection->getClients()["globus"];
            //VarDumper::dump();
        }

        $accessToken = $authClient->getAccessToken();

        $other_tokens = $accessToken->getParam('other_tokens');
        $scope = 'urn:globus:auth:scope:transfer.api.globus.org:all';
        foreach ($other_tokens as &$tokenparams) {
            if(strcmp($tokenparams['scope'],$scope) == 0){
                $token = $tokenparams['access_token'];
            }
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $createDirectoryUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$body,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer ".$token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

    }

    public function renameDirectory($globusRoot,$oldPath,$newPath,$labsEndpoint){

        $this->activationEndpoint();
        $renameDirectoryUrl = $this->baseUrl."/operation/endpoint/".$labsEndpoint."/rename";

        $oldPath = $globusRoot.$oldPath;
        $newPath = $globusRoot.$newPath;

        $body = "{\n    \"DATA_TYPE\": \"rename\",\n    \"old_path\": \"".$oldPath."\",\n \"new_path\": \"".$newPath."\"\n}";

        $authClient = Yii::$app->user->getCurrentAuthClient();
        if($authClient == null){
            $authClient = Yii::$app->authClientCollection->getClients()["globus"];
            //VarDumper::dump();
        }

        $accessToken = $authClient->getAccessToken();

        $other_tokens = $accessToken->getParam('other_tokens');
        $scope = 'urn:globus:auth:scope:transfer.api.globus.org:all';
        foreach ($other_tokens as &$tokenparams) {
            if(strcmp($tokenparams['scope'],$scope) == 0){
                $token = $tokenparams['access_token'];
            }
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $renameDirectoryUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$body,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer ".$token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        //echo $response;

    }

    public function renameFile($globusRoot,$oldPath,$newPath,$labsEndpoint){

        $this->activationEndpoint();
        $renameDirectoryUrl = $this->baseUrl."/operation/endpoint/".$labsEndpoint."/rename";

        $oldPath = $globusRoot.$oldPath;
        $newPath = $globusRoot.$newPath;

        $body = "{\n    \"DATA_TYPE\": \"rename\",\n    \"old_path\": \"".$oldPath."\",\n \"new_path\": \"".$newPath."\"\n}";

        $authClient = Yii::$app->user->getCurrentAuthClient();
        if($authClient == null){
            $authClient = Yii::$app->authClientCollection->getClients()["globus"];
            //VarDumper::dump();
        }

        $accessToken = $authClient->getAccessToken();

        $other_tokens = $accessToken->getParam('other_tokens');
        $scope = 'urn:globus:auth:scope:transfer.api.globus.org:all';
        foreach ($other_tokens as &$tokenparams) {
            if(strcmp($tokenparams['scope'],$scope) == 0){
                $token = $tokenparams['access_token'];
            }
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $renameDirectoryUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$body,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer ".$token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        //echo $response;

    }

    public function delete($globusRoot,$path,$labsEndpoint)
    {
        $this->activationEndpoint();
        $submissionUrl = $this->baseUrl."/submission_id";

        $scope = 'urn:globus:auth:scope:transfer.api.globus.org:all';
        $authClient = Yii::$app->user->getCurrentAuthClient();

        if($authClient == null){
            $authClient = Yii::$app->authClientCollection->getClients()["globus"];
        }

        //SUBMISSION ID
        $request = $authClient->createRequest()
            ->setMethod('GET')
            ->setUrl($submissionUrl);

        $authClient->applyOtherTokenToRequest($request,$authClient->getAccessToken(),$scope);
        $response = $authClient->sendRequest($request);
        $submission_id = $response["value"];

        $deleteUrl = 'https://transfer.api.globus.org/v0.10/delete';
        $fullPath = $globusRoot.$path;



        $body = "{\"DATA_TYPE\":\"delete\",
        \"endpoint\":\"".$labsEndpoint."\",
        \"recursive\":true,
        \"ignore_missing\":true,
        \"interpret_globs\":false,
        \"label\":null,
        \"DATA\":[
        {\"DATA_TYPE\":\"delete_item\",
        \"path\":\"".$fullPath."\"}],
        \"submission_id\":\"".$submission_id."\"}";


        $authClient = Yii::$app->user->getCurrentAuthClient();
        $accessToken = $authClient->getAccessToken();

        $other_tokens = $accessToken->getParam('other_tokens');
        $scope = 'urn:globus:auth:scope:transfer.api.globus.org:all';
        foreach ($other_tokens as &$tokenparams) {
            if(strcmp($tokenparams['scope'],$scope) == 0){
                $token = $tokenparams['access_token'];
            }
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $deleteUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>$body,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer ".$token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        //echo $response;
    }

    public function submitTransferTask($source_endpoint,$spath,$dpath,$folders,$files,$label,$labsEndpoint,$globusRoot)
    {
        $this->activationEndpoint();
        $submissionUrl = $this->baseUrl."/submission_id";

        $scope = 'urn:globus:auth:scope:transfer.api.globus.org:all';
        $authClient = Yii::$app->user->getCurrentAuthClient();

        if($authClient == null){
            $authClient = Yii::$app->authClientCollection->getClients()["globus"];
            //VarDumper::dump();
        }

        //SUBMISSION ID
        $request = $authClient->createRequest()
            ->setMethod('GET')
            ->setUrl($submissionUrl);

        $authClient->applyOtherTokenToRequest($request,$authClient->getAccessToken(),$scope);
        $response = $authClient->sendRequest($request);
        $submission_id = $response["value"];

        $dpath = $globusRoot.$dpath;

        $DATA = array();

        $isEmpty = empty($folders);
        if(!$isEmpty){
            foreach ($folders as &$folder){
                $item = [
                    "DATA_TYPE" => "transfer_item",
                    "source_path" => $spath.$folder,
                    "destination_path" => $dpath."/".$folder,
                    "recursive" => TRUE
                ];
                $DATA[] = $item;
            }
        }

        $isEmpty = empty($files);
        if(!$isEmpty){
            foreach ($files as &$file){
                $item = [
                    "DATA_TYPE" => "transfer_item",
                    "source_path" => $spath."/".$file,
                    "destination_path" => $dpath."/".$file,
                    "recursive" => FALSE
                ];
                $DATA[] = $item;
            }
        }

        $body = [
            "DATA_TYPE" => "transfer",
            "submission_id" => $submission_id,
            "source_endpoint" => $source_endpoint,
            "destination_endpoint" => $labsEndpoint,
            "deadline" => null,
            "label"      => $label,
            "sync_level" => null,
            "verify_checksum" => TRUE,
            "delete_destination_extra" => FALSE,
            "preserve_timestamp" => FALSE,
            "encrypt_data" => TRUE,
            "DATA" => $DATA
        ];

        //TASK ID
        $tranferUrl = $this->baseUrl."/transfer";

        $authClient = Yii::$app->user->getCurrentAuthClient();
        $accessToken = $authClient->getAccessToken();

        $other_tokens = $accessToken->getParam('other_tokens');
        $scope = 'urn:globus:auth:scope:transfer.api.globus.org:all';
        foreach ($other_tokens as &$tokenparams) {
            if(strcmp($tokenparams['scope'],$scope) == 0){
                $token = $tokenparams['access_token'];
            }
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $tranferUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>json_encode($body),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer ".$token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

    }

    public function submitDownloadTask($source_endpoint,$spath,$folders,$files,$label,$labsEndpoint,$globusRoot)
    {
        $this->activationEndpoint();
        $submissionUrl = $this->baseUrl."/submission_id";

        $scope = 'urn:globus:auth:scope:transfer.api.globus.org:all';
        $authClient = Yii::$app->user->getCurrentAuthClient();

        if($authClient == null){
            $authClient = Yii::$app->authClientCollection->getClients()["globus"];
        }

        //SUBMISSION ID
        $request = $authClient->createRequest()
            ->setMethod('GET')
            ->setUrl($submissionUrl);

        $authClient->applyOtherTokenToRequest($request,$authClient->getAccessToken(),$scope);
        $response = $authClient->sendRequest($request);
        $submission_id = $response["value"];

        $dpath = "/~/";

        $DATA = array();
        $isEmpty = empty($folders);
        if(!$isEmpty){
            $item = [
                "DATA_TYPE" => "transfer_item",
                "source_path" => $spath,
                "destination_path" => $dpath."/".$folders[0],
                "recursive" => TRUE
            ];
            $DATA[] = $item;
        }

        $isEmpty = empty($files);
        if(!$isEmpty){
            $item = [
                "DATA_TYPE" => "transfer_item",
                "source_path" => $spath,
                "destination_path" => $dpath."/".$files[0],
                "recursive" => FALSE
            ];
            $DATA[] = $item;
        }

        $body = [
            "DATA_TYPE" => "transfer",
            "submission_id" => $submission_id,
            "source_endpoint" => $source_endpoint,
            "destination_endpoint" => $labsEndpoint,
            "deadline" => null,
            "label"      => $label,
            "sync_level" => null,
            "verify_checksum" => TRUE,
            "delete_destination_extra" => FALSE,
            "preserve_timestamp" => FALSE,
            "encrypt_data" => TRUE,
            "DATA" => $DATA
        ];

        //TASK ID
        $tranferUrl = $this->baseUrl."/transfer";

        $authClient = Yii::$app->user->getCurrentAuthClient();
        $accessToken = $authClient->getAccessToken();

        $other_tokens = $accessToken->getParam('other_tokens');
        $scope = 'urn:globus:auth:scope:transfer.api.globus.org:all';
        foreach ($other_tokens as &$tokenparams) {
            if(strcmp($tokenparams['scope'],$scope) == 0){
                $token = $tokenparams['access_token'];
            }
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $tranferUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>json_encode($body),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Authorization: Bearer ".$token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

    }
}
