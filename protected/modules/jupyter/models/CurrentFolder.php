<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 26/12/2019
 * Time: 11:30
 */

namespace humhub\modules\globusfiles\models;
use humhub\modules\ui\view\components\View;
use Yii;
use yii\helpers\Url;
use yii\helpers\VarDumper;

class CurrentFolder
{
    /**
     * @inheritdoc
     */
    public $wallEntryClass = "humhub\modules\globusfiles\widgets\WallEntryFolder";
    public $fileList;
    public $folderList;
    public $id;
    public $parentFolder;
    public $isRoot;
    public $backUrl;

    function __construct($files,$id,$parentFolder) {
        $this->id = $id;
        $this->fileList = array();
        $this->folderList = array();
        $this->parentFolder = $parentFolder;

        if(count($this->parentFolder)==1){
            $this->isRoot = TRUE;
        }else{
            $this->isRoot = FALSE;
            $this->backUrl = $this->parentFolder[count($this->parentFolder)-2]->url;
        }

        foreach ($files as $file)
        {
            $itemName = $file["name"];
            $itemType = $file["type"];
            $updatedAt = $file["last_modified"];
            $size = $file["size"];

            if(strcmp($itemType,"dir")==0){
                $ext = "";
                $item = new GlobusItem($itemName,$itemType,$updatedAt,$size,$ext,$id);
                $this->fileList[] = $item;
            }elseif(strcmp($itemType,"file")==0){
                $ext = pathinfo($itemName, PATHINFO_EXTENSION);
                $item = new GlobusItem($itemName,$itemType,$updatedAt,$size,$ext,$id);
                $this->folderList[] = $item;
            }
        }
    }

    function getFiles() {
        return $this->fileList;
    }
    function getFolders() {
        return $this->folderList;
    }


    /**
     * @inheritdoc
     */
    public function getIcon()
    {
        return'fa-folder';
    }

    public function createUrl($route = null, $params = [], $scheme = false)
    {
        $username = Yii::$app->user->identity->username;
        $url = Url::toRoute('/u/'.$username.'/globusfiles/delete?path='.$this->id);
        return $url;
    }

    public function getUrl()
    {
        if (empty($this->content->container)) {
            return "";
        }

        return $this->content->container->createUrl('/globusfiles/browse/index', ['fid' => $this->id]);
    }

    public function getFullUrl()
    {
        if (empty($this->content->container)) {
            return "";
        }

        return $this->content->container->createUrl('/globusfiles/browse/index', ['fid' => $this->id], true);
    }

    public function getEditUrl()
    {
        return $this->content->container->createUrl('/globusfiles/edit/folder', ['id' => $this->getItemId()]);
    }

    /**
     * Returns the folder path as ordered array.
     * @return CurrentFolder[]
     */
    public function getCrumb()
    {
        return $this->parentFolder;
    }

    /**
     * Creates and adds the given UploadedFile to this directory.
     *
     * Returns the newly created globusfiles file.
     * The calling function has to make sure there are no errors by checking_
     *
     * ```php
     * $file->hasErrors()
     * ```
     * and
     *
     * ```php
     * $file->baseFile->hasErrors();
     * ```
     * @param UploadedFile $uploadedFile
     * @return File
     */
    public function addUploadedFile(UploadedFile $uploadedFile, $replace = false)
    {

        // Get file instance either an existing one if $replace = true and a file already exists or a new one
        $file = $this->getFileInstance($uploadedFile, $replace);

        $fileName = (!$replace) ? $this->getAddedFileName($uploadedFile->name) : $uploadedFile->name;

        if($file->setUploadedFile($uploadedFile, $fileName)) {
            $file->save();
        }

        return $file;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param bool $replace
     */
    private function getFileInstance(UploadedFile $uploadedFile, $replace = false)
    {
        $result = null;
        if($replace) {
            $result = $this->findFileByName($uploadedFile->name);
        }

        if(!$result) {
            $result = new File($this->content->container, $this->getNewItemVisibility(), [
                'parent_folder_id' => $this->id
            ]);
        }

        return $result;
    }

    private function getNewItemVisibility()
    {
        if ($this->isRoot()) {
            return $this->content->container->getDefaultContentVisibility();
        }

        return $this->content->visibility;
    }

    public function addFileFromPath($filename, $filePath)
    {
        $file = new File($this->content->container, $this->getNewItemVisibility(), [
            'parent_folder_id' => $this->id
        ]);

        $fileContent = new FileContent([
            'mime_type' => FileHelper::getMimeType($filePath),
            'size' => filesize($filePath),
            'show_in_stream' => 0,
            'file_name' => $this->getAddedFileName($filename)
        ]);

        if ($fileContent->mime_type == 'image/jpeg') {
            ImageConverter::TransformToJpeg($filePath, $filePath);
        }

        $fileContent->newFileContent = stream_get_contents(fopen($filePath, 'r'));

        $file->setFileContent($fileContent);
        $file->save();

        return $file;
    }

    /**
     * Creates a new non persisted folder within this folder.
     *
     * @param string|null $title
     * @param string|null $description
     * @return Folder
     */
    public function newFolder($title = null, $description = null)
    {
        return new self($this->content->container, $this->getNewItemVisibility(), [
            'parent_folder_id' => $this->id,
            'title' => $title,
            'description' => $description]);
    }

    public function isAllPostedFiles()
    {
        return TRUE;
    }

    public function isRoot()
    {
        //return $this->isRoot;
        return TRUE;
    }

    public function getVisibilityTitle()
    {
        $title = Yii::$app->user->username;
        return $title;
    }

    public function getBackUrl(){
        return $this->backUrl;
    }



}
