<?php

namespace humhub\modules\globusfiles\widgets;

use humhub\modules\globusfiles\models\GlobusItem;
use Yii;
use yii\base\Widget;
use yii\data\Pagination;

/**
 * Widget for rendering the file list.
 */
class FileList extends Widget
{

    /**
     * @var \humhub\modules\globusfiles\models\CurrentFolder current folder
     */
    public $folder;

    /**
     * @var \humhub\modules\content\components\ContentContainerActiveRecord Current content container.
     */
    public $contentContainer;

    /**
     * @var GlobusItem[] All file items of the current folder sorted by item type.
     */
    protected $rows;


    /**
     * @var Pagination
     */
    protected $pagination;


    /**
     * @inheritdoc
     */
    public function run()
    {
        $this->setSystemItemRows();

        $canWrite = TRUE;
        $itemsSelectable = ($canWrite || Yii::$app->getModule('globusfiles')->isZipSupportEnabled());

        return $this->render('fileList', [
            'rows' => $this->rows,
            'pagination' => $this->pagination,
            'folder' => $this->folder,
            'itemsSelectable' => $itemsSelectable,
            'itemsInFolder' => count($this->rows),
            'canWrite' => $canWrite,
        ]);
    }

    /**
     * Returns all file items of the current folder sorted by item type.
     * @return array
     */
    protected function setSystemItemRows()
    {
        $this->rows = [];

        foreach ($this->folder->getFolders() as $folder) {
            $this->rows[] = $folder;
        }

        foreach ($this->folder->getFiles() as $file) {
            $this->rows[] = $file;
        }
    }

    /**
     * Returns a list of selected items
     *
     * @return \humhub\modules\globusfiles\models\FileSystemItem[]
     */
    public static function getSelectedItems()
    {
        $selectedItems = Yii::$app->request->post('selection');

        $items = [];

        // download selected items if there are some
        if (is_array($selectedItems)) {
            foreach ($selectedItems as $itemId) {
                $item = FileSystemItem::getItemById($itemId);
                if ($item !== null) {
                    $items[] = $item;
                }
            }
        }
        return $items;
    }

}
