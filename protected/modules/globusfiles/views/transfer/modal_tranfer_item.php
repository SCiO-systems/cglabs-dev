<?php

use humhub\widgets\ModalButton;
use humhub\widgets\ModalDialog;
use yii\helpers\Html;

/* @var $folder \humhub\modules\globusfiles\models\CurrentFolder */
/* @var $submitUrl string */

/*$header = ($folder->isNewRecord)
    ? '<strong>Create</strong> folder'
    :  '<strong>Edit</strong> folder';*/


$header = '<strong>Submit</strong> Destination Endpoint';

?>

<?php ModalDialog::begin([
    'header' =>  $header,
    'animation' => 'fadeIn',
    'size' => 'small']) ?>

<?= Html::beginForm($submitUrl, 'POST'); ?>
<div class="modal-body">
    <br />
    <?= Html::input('text', 'destination','',$options=['class'=>'form-control']) ?>
</div>

<div class="modal-footer">
    <?= Html::submitButton('Transfer', ['class' => 'btn btn-primary']) ?>
    <?= ModalButton::cancel() ?>
</div>
<?= Html::endForm(); ?>

<?php ModalDialog::end() ?>







