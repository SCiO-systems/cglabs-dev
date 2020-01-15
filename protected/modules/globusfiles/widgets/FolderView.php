<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 26/12/2019
 * Time: 11:10
 */

namespace humhub\modules\globusfiles\widgets;

use humhub\modules\globusfiles\models\CurrentFolder;
use humhub\modules\content\components\ContentContainerActiveRecord;
use humhub\widgets\JsWidget;
use Yii;
use yii\helpers\Url;


/**
 * Widget for rendering the file list bar.
 */

class FolderView extends JsWidget
{
    /**
     * @inheritdoc
     */
    public $jsWidget = 'globusfiles.FolderView';

    /**
     * @inheritdoc
     */
    public $id = 'globusfiles-folderView';

    /**
     * @var ContentContainerActiveRecord
     */
    public $contentContainer;

    /**
     * @var CurrentFolder
     */
    public $folder;

    /**
     * @inheritdoc
     */
    public $init = true;


    /**
     * @inheritdoc
     */
    public function getData()
    {
        $username = Yii::$app->user->identity->username;
        $delete_url = Url::toRoute('/u/'.$username.'/globusfiles/browse/delete');

        return [
            'fid' => 'id',
            'upload-url' => 'upload-url',
            'reload-file-list-url' => 'file-list',
            'delete-url' => $delete_url,
            'zip-upload-url' => 'zip-upload',
            'download-archive-url' => 'download-archive',
            'move-url' => 'move-url',
            'import-url' => 'import-url',
        ];
    }

    /**
     * @inheritdoc
     */
    public function run() {
        return $this->render('folderView', [
            'folder' => $this->folder,
            'options' => $this->getOptions(),
            'contentContainer' => $this->contentContainer
        ]);
    }




}



?>
