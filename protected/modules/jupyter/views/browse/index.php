<?php

use yii\helpers\Html;
use humhub\modules\globusfiles\widgets\FolderView;
use humhub\modules\globusfiles\widgets\FileListContextMenu;
use humhub\widgets\Button;

/* @var $contentContainer humhub\components\View */

$bundle = \humhub\modules\jupyter\assets\JupyterAsset::register($this);

$this->registerJsConfig('jupyter', [
    'text' => [
        'confirm.delete' => 'Do you really want to delete this {number} item(s) with all subcontent?',
        'confirm.delete.header' =>  '<strong>Confirm</strong> delete file',
        'confirm.delete.confirmText' =>  'Delete'
    ],
    'showUrlModal' => [
        'head' => '<strong>File</strong> url',
        'headFile' => '<strong>File</strong> download url',
        'headFolder' =>'<strong>Folder</strong> url',
        'info' => 'Copy to clipboard',
        'buttonClose' => 'Close',
    ]
]);

$authClient = Yii::$app->user->getCurrentAuthClient();
$accessToken = $authClient->getAccessToken();

$token = array();
$token["access_token"] = $accessToken->getToken();
$token["other_tokens"] = $accessToken->getParam('other_tokens');
$otherTokens = \yii\helpers\Json::encode($token);

?>

<?= Html::beginForm(null, null, ['data-target' => '#globalModal', 'id' => 'jupyter-form']); ?>
<div id="jupyter-container" class="panel panel-default jupyter-content">

    <div class="panel-body">

        <p>JupyterLab is a next-generation web-based user interface for Project Jupyter. JupyterLab enables you to work with documents and activities such as Jupyter notebooks, text editors, terminals, and custom components in a flexible, integrated, and extensible manner.</p>

        <?=
        Button::primary('Connect to GARDIAN\'s Jupyter Lab')->icon('fa fa-plug')->cssClass('btn-success')
            ->link($otherTokens);
        ?>

    </div>
</div>
<?= Html::endForm(); ?>




