<?php

use yii\helpers\Html;
use yii\helpers\Url;
use humhub\widgets\Button;


/* @var $contentContainer humhub\components\View */

$bundle = \humhub\modules\jupyter\assets\MapAsset::register($this);

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
if($authClient == null){
    $authClient = Yii::$app->authClientCollection->getClients()["globus"];
}
$accessToken = $authClient->getAccessToken();

$token = array();
$token["access_token"] = $accessToken->getToken();
$token["other_tokens"] = $accessToken->getParam('other_tokens');
$otherTokens = \yii\helpers\Json::encode($token);

$username = Yii::$app->user->identity->username;

$guid = Yii::$app->user->getGuid();

$space = $contentContainer;
$className = $space::className();

if(strcmp($className,'humhub\modules\space\models\Space') == 0){
    $sguid = $space->guid;
    $spaceName = strtolower($space->getDisplayName());
    $spaceName = str_replace(' ', 's', $spaceName);
    $spaceName = str_replace('-', 's', $spaceName);
    $spaceName = preg_replace('/[^A-Za-z0-9\-]/', 's', $spaceName);
    $username = $authClient->getUserAttributes()['preferred_username'];
    $username_pieces = explode("@",$username);
    $url = Url::toRoute('/s/'.$spaceName.'/jupyter/browse/jupyter');
    $link = 'https://labs.scio.systems:8000/hub/spawn/'.$username_pieces[0].'/'.$spaceName;
}else{
    $username = $authClient->getUserAttributes()['preferred_username'];
    $username_pieces = explode("@",$username);
    $sguid = $guid;
    $url = Url::toRoute('/u/'.$username.'/jupyter/browse/jupyter');
    $link = 'https://labs.scio.systems:8000/user/'.$username_pieces[0].'/lab?guid='.$guid.'&sguid='.$sguid;
}



//$link = 'https://labs.scio.systems:8000/user/'.$username_pieces[0].'/lab?guid='.$guid;



?>

<?= Html::beginForm($url, "POST", ['data-target' => '#globalModal', 'id' => 'jupyter-form']); ?>
<div id="jupyter-container" class="panel panel-default jupyter-content">

    <div class="panel-body">

        <div class="panel-heading">

            <strong>Analytics Platform</strong>

            <p>JupyterLab enables you to work with documents and activities such as Jupyter notebooks, text editors,
                terminals, and custom components in a flexible, integrated, and extensible manner.
                You can arrange multiple documents and activities side by side in the work area using tabs and
                splitters. Documents and activities integrate with each other, enabling new workflows for
                interactive computing, for example:</p>

            <ul>
                <li>Code Consoles provide transient scratchpads for running code interactively, with full support for rich output. A code console can be linked to a notebook kernel as a computation log from the notebook, for example.</li>
                <li>Kernel-backed documents enable code in any text file (Markdown, Python, R, LaTeX, etc.) to be run interactively in any Jupyter kernel.</li>
                <li>Notebook cell outputs can be mirrored into their own tab, side by side with the notebook, enabling simple dashboards with interactive controls backed by a kernel.</li>
                <li>Multiple views of documents with different editors or viewers enable live editing of documents reflected in other viewers. For example, it is easy to have live preview of Markdown, Delimiter-separated Values, or Vega/Vega-Lite documents.</li>
            </ul>

            <p>JupyterLab also offers a unified model for viewing and handling data formats. JupyterLab understands many file formats (images, CSV, JSON, Markdown, PDF, Vega, Vega-Lite, etc.) and can also display rich kernel output in these formats. See File and Output Formats for more information.</p>

            <p><a href="https://jupyterlab.readthedocs.io/en/stable/" target="_blank" style="text-decoration: underline">Check JupyterLab Documentation!</a></p>

        </div>

        <div align="center">
            <?=
            Html::a('Connect to GARDIAN\'s Jupyter Lab', $link, ['target'=>'_blank','class'=>'btn btn-info btn-primary']); ?>
        </div>



    </div>
</div>
<?= Html::endForm(); ?>




