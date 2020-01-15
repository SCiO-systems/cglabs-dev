<?php
/**
 * Created by IntelliJ IDEA.
 * User: SOTIRIS SON
 * Date: 6/1/2020
 * Time: 18:27
 */

namespace humhub\modules\globusfiles\widgets;


class FileListMenu extends \yii\base\Widget
{
    /**
     * Current folder model instance.
     * @var \humhub\modules\globusfiles\models\CurrentFolder
     */
    public $folder;

    /**
     * @var \humhub\modules\content\components\ContentContainerActiveRecord Current content container.
     */
    public $contentContainer;


    /**
     * @var integer FileList item count.
     */
    public $itemCount;

    /**
     * @inheritdoc
     */
    public function run()
    {

        $canUpload = TRUE;

        return $this->render('fileListMenu', [
            'folder' => $this->folder,
            'contentContainer' => $this->contentContainer,
            'canUpload' => $canUpload
        ]);
    }

}
