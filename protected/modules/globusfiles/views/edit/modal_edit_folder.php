<?php

use humhub\widgets\ModalButton;
use humhub\widgets\ModalDialog;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $folder \humhub\modules\globusfiles\models\CurrentFolder */
/* @var $submitUrl string */

/*$header = ($folder->isNewRecord)
    ? '<strong>Create</strong> folder'
    :  '<strong>Edit</strong> folder';*/


$header = '<strong>Create / Rename</strong> folder';

?>

<?php ModalDialog::begin([
    'header' =>  $header,
    'animation' => 'fadeIn',
    'size' => 'small']) ?>

<?= Html::beginForm($submitUrl, 'POST'); ?>
    <div class="modal-body">
        <br />
        <?= Html::input('text', 'title','',$options=['class'=>'form-control', 'maxlength'=>10]) ?>
    </div>

    <div class="modal-footer">
        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
        <?= ModalButton::cancel() ?>
    </div>
<?= Html::endForm(); ?>

<?php ModalDialog::end() ?>







