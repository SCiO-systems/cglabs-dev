<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 26/12/2019
 * Time: 11:55
 */

namespace humhub\modules\map\controllers;

use humhub\modules\globusfiles\models\CurrentFolder;
use humhub\modules\globusfiles\models\ParentFolder;
use Yii;
use humhub\modules\content\components\ContentContainerController;
use yii\helpers\FileHelper;




abstract class BaseController extends ContentContainerController
{
    public $globusRoot = '/opt/labsspace/';

    public function createRootFolder($guid,$globusRoot){

        $user_directory = $globusRoot.$guid;
        if (file_exists($user_directory) != TRUE){
            FileHelper::createDirectory($user_directory, $mode = 0777, $recursive = true);
        }
    }

}
