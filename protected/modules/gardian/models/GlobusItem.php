<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 26/12/2019
 * Time: 11:30
 */

namespace humhub\modules\globusfiles\models;
use Yii;
use yii\helpers\Url;

class GlobusItem
{

    const COLUMN_SELECT = 'select';
    const COLUMN_VISIBILITY = 'visibility';
    const COLUMN_TITLE = 'title';
    const COLUMN_SIZE = 'size';
    const COLUMN_TIMESTAMP = 'timestamp';
    const COLUMN_SOCIAL = 'social';
    const COLUMN_CREATOR = 'creator';


    const DEFAULT_COLUMNS = [
        self::COLUMN_SELECT,
        self::COLUMN_VISIBILITY,
        self::COLUMN_TITLE,
        self::COLUMN_SIZE,
        self::COLUMN_TIMESTAMP,
        self::COLUMN_SOCIAL,
        self::COLUMN_CREATOR
    ];

    /**
     * @var bool
     */
    public $showSelect = true;
    private $_columns;


    /**
     * @inheritdoc
     */

    public $itemName;
    public $itemType;
    public $updatedAt;
    public $size;
    public $createdBy;
    public $extension;
    public $path;
    public $fullPath;

    function __construct($itemName,$itemType,$updatedAt,$size,$extension,$path) {
        $this->itemName = $itemName;
        $this->itemType = $itemType;
        $this->updatedAt = $updatedAt;
        $this->size = $size;
        $this->createdBy = Yii::$app->user->identity;
        $this->extension = $extension;
        $this->path = $path;
        $this->fullPath = $path.'/'.$itemName;
    }

    function setItemName($itemName) {
        $this->itemName = $itemName;
    }

    function setItemType($itemType) {
        $this->itemType = $itemType;
    }

    function getItemName() {
        return $this->itemName;
    }

    function getItemType() {
        return $this->itemType;
    }

    function getItemId(){
        //return $this->itemName;
        return $this->getItemName();
    }

    function setSize($size){
        $this->size = $size;
    }

    function getSize(){
        return $this->size;
    }

    function getUrl(){
        return "dummy_URL";
    }

    function getFullUrl(){
        return $this->fullPath;
    }

    public function getLinkUrl()
    {
        if(strcmp($this->itemType,'dir')==0){
            $username = Yii::$app->user->identity->username;
            $url = Url::toRoute('/u/'.$username.'/globusfiles/browse?path='.$this->fullPath);
            return $url;
        }else{
            return "#";
        }

    }

    public function getDisplayUrl()
    {
        return "dummy_Display_URL";
    }

    public function getWallUrl()
    {
        return "dummy_Wall_URL";
    }

    public function getType()
    {
        return "dummy_Type";
    }

    /**
     * @inheritdoc
     */
    public function isSelectable()
    {
        return true;
    }

    /**
     * @inheritdoc
     */
    public function isSocialActionsAvailable()
    {
        return false;
    }

    public function getEditUrl()
    {
        if(strcmp($this->itemType,'dir')==0){
            $username = Yii::$app->user->identity->username;
            $url = Url::toRoute('/u/'.$username.'/globusfiles/edit/renamefolder?path='.$this->fullPath);
            return $url;
        }elseif(strcmp($this->itemType,'file')==0){
            $username = Yii::$app->user->identity->username;
            $url = Url::toRoute('/u/'.$username.'/globusfiles/edit/file?path='.$this->fullPath);
            return $url;
        }
    }

    public function getDeleteUrl()
    {
        $username = Yii::$app->user->identity->username;
        $url = Url::toRoute('/u/'.$username.'/globusfiles/browse/delete?path='.$this->fullPath);
        return $url;
    }

    public function getMoveUrl()
    {
        $username = Yii::$app->user->identity->username;

        if(strcmp($this->itemType,'dir')==0){
            $path = $this->fullPath."&type=dir";
        }elseif(strcmp($this->itemType,'file')==0){
            $path = $this->fullPath."&type=file";
        }
        $url = Url::toRoute('/u/'.$username.'/globusfiles/transfer/item?path='.$path);
        return $url;
    }

    /**
     * @inheritdoc
     */
    public function getTitle()
    {
        //return $this->getItemName();
        return $this->getItemName();
    }

    /**
     * @inheritdoc
     */
    public function getCreator()
    {
        //return $this->item->getCreator();
        return $this->createdBy;
    }

    /**
     * @inheritdoc
     */
    public function getEditor()
    {
        //return $this->item->getCreator();
        return $this->createdBy;
    }

    /**
     * @inheritdoc
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        //return $this->item->getDescription();
        return "Last Update: ".$this->updatedAt;
    }

    /**
     * @inheritdoc
     */
    public function getVisibilityIcon()
    {
        //return $this->item->content->isPublic() ? 'fa-unlock-alt': 'fa-lock';
        return "fa-unlock-alt";
    }

    /**
     * @return string
     */
    public function getVisibilityTitle()
    {
        //return $this->item->getVisibilityTitle();
        return "Permission";
    }

    /**
     * @param $column
     * @return bool
     */
    public function isRenderColumn($column)
    {
        if($column === self::COLUMN_SELECT && !$this->showSelect) {
            return false;
        }

        if(!$this->_columns) {
            $this->_columns = $this->getColumns();
        }

        return in_array($column, $this->_columns);
    }

    /**
     * @inheritdoc
     */
    public function getColumns()
    {
        return self::DEFAULT_COLUMNS;
    }

    /**
     * @inheritdoc
     */
    public function canEdit()
    {
        return TRUE;
    }

    /**
     * @inheritdoc
     */
    public function getIcon()
    {
        if(strcmp($this->itemType,"dir")==0){
            return'fa-folder';
        }elseif(strcmp($this->itemType,"file")==0){
            return $this->resolveIcon($this->extension);
        }
    }

    private function resolveIcon($extension){
        if (in_array($extension, [
            'html',
            'cmd',
            'bat',
            'xml'
        ])) {
            return 'fa-file-code-o';
        } elseif (in_array($extension, [
            'zip',
            'rar',
            'gz',
            'tar'
        ])) {
            return "fa-file-archive-o";
        } elseif (in_array($extension, [
            'mp3',
            'wav'
        ])) {
            return "fa-file-audio-o";
        } elseif (in_array($extension, [
            'xls',
            'xlsx'
        ])) {
            return "fa-file-excel-o";
        } elseif (in_array($extension, [
            'jpg',
            'gif',
            'bmp',
            'svg',
            'tiff',
            'png'
        ])) {
            return "fa-file-image-o";
        } elseif (in_array($extension, [
            'pdf'
        ])) {
            return "fa-file-pdf-o";
        } elseif (in_array($extension, [
            'ppt',
            'pptx'
        ])) {
            return "fa-file-powerpoint-o";
        } elseif (in_array($extension, [
            'txt',
            'log',
            'md'
        ])) {
            return "fa-file-text-o";
        } elseif (in_array($extension, [
            'mp4',
            'mpeg',
            'swf'
        ])) {
            return "fa-file-video-o";
        } elseif (in_array($extension, [
            'doc',
            'docx'
        ])) {
            return "fa-file-word-o";
        }
        return 'fa-file-o';

    }

    /**
     * @inheritdoc
     */
    public function getIconClass()
    {
        return $this->getIcon();
    }
}
