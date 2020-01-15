<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 26/12/2019
 * Time: 11:10
 */

namespace humhub\modules\globusfiles\widgets;

use Yii;


/**
 * Widget for rendering the file list context menu.
 */

class FileListContextMenu extends \yii\base\Widget
{
    /**
     * Current folder model instance.
     * @var \humhub\modules\globusfiles\models\GlobusItem
     */
    public $folder;

    /**
     * @inheritdoc
     */
    public function run()
    {
        $canWrite = TRUE;

        return $this->render('fileListContextMenu', [
            'folder' => $this->folder,
            'canWrite' => $canWrite,
        ]);
    }
}


?>
