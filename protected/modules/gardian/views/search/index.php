<?php

use yii\helpers\Html;
use yii\grid\GridView;
use humhub\widgets\Button;
use yii\helpers\Url;

/* @var $contentContainer humhub\components\View */
/* @var $datasets  yii\data\ArrayDataProvider; */
/* @var $publications yii\data\ArrayDataProvider; */

$bundle = \humhub\modules\gardian\assets\GardianAsset::register($this);
$username = $username = Yii::$app->user->identity->username;
$this->registerJsConfig('gardian', [
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

?>

<?= Html::beginForm('./search', 'POST', ['data-target' => '#globalModal', 'id' => 'gardian-form']); ?>
<div id="gardian-container" class="panel panel-default gardian-content">
    <div class="panel-body">
        <div id="contentForm_message" class="focusMenu">
            <?php if ($keywords): ?>
                <?=
                    Html::textInput(
                    "keywords",
                    $keywords,
                    ['data-ui-markdown' => "true", "class" => "form-control humhub-ui-richtext"])
                ?>
            <?php endif; ?>
            <?php if (!$keywords): ?>
                <?=
                Html::textInput(
                    "keywords",
                    $keywords,
                    ['data-ui-markdown' => "true", "class" => "form-control humhub-ui-richtext"])
                ?>
            <?php endif; ?>
        </div>
        <hr>
        <?=
        Button::primary('Search')
            ->icon('fa fa-search')
            ->cssClass('btn btn-info')
            ->submit();
        ?>
    </div>
    </div>
    <?php if ($keywords): ?>
    <div id="loader"
         style="position:absolute;
         z-index:1500;
         background-color:grey;
         height:100%;
         width:100%;
         opacity: 0.5;
         left:0;top:0;
         margin: auto;bottom:0;right:0;display: none">
        <img src="<?= Url::to('@web/static/img/loading.gif') ?>" alt="Loading" style="padding: 50%"/>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>Search Results</strong>
            <div class="panel-body">
                <ul id="tabs" class="nav nav-tabs" data-tabs="tabs">
                    <li class="active">
                        <a href="#datasets" data-toggle="tab">Datasets</a>
                    </li>
                    <li>
                        <a href="#publications" data-toggle="tab">Publications</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="tab-content">
            <div class="tab-pane active" id="datasets" style="padding: 5px">
                <?= GridView::widget([
                    'id' => 'datasets',
                    'dataProvider' => $datasets,
                    'showFooter' => TRUE,
                    'layout' => '{summary}{items}<div align="center">{pager}</div>',
                    'pager' => [
                        'firstPageLabel' => 'First',
                        'lastPageLabel' => 'Last',
                    ],
                    'columns' => [
                        [
                            'attribute' => 'publicationYear',
                            'format' => 'raw',
                            'value' => 'publicationYear',
                            'label' => 'Year',
                            'headerOptions' => ['style' => 'text-align: center']
                        ],
                        [
                            'label' => 'Title',
                            'attribute' => 'title',
                            'format' => 'raw',
                            'value' => function($data){
                                $link = $data->contentProvider[0]->providerLink;
                                $title = $data->title;
                                return Html::a($title, $link,['target'=>'_blank']);
                            },
                            'headerOptions' => ['style' => 'text-align: center'],
                            'contentOptions' => ['style' => 'padding:5px'],
                        ],
                        [
                            'attribute' => 'authors',
                            'format' => 'raw',
                            'value' => 'authors',
                            'label' => 'Authors',
                            'headerOptions' => ['style' => 'text-align: center'],
                            'contentOptions' => ['style' => 'padding:5px'],
                        ],
                        [
                            'label' => 'License',
                            'attribute' => 'license.image',
                            'format' => 'raw',
                            'value' => function($data){
                                    $license = $data->license;
                                    if(!empty($license)){
                                        $image = $license->image;
                                        $url = $license->url;
                                        $term = $license->term;
                                        $htmlImage = Html::img($image, ['alt'=>$term,'style'=>'width: 88px;height: 33px']);
                                        return Html::a($htmlImage, $url,['target'=>'_blank']);
                                    }else{
                                        return "-";
                                    }
                            },
                            'headerOptions' => ['style' => 'text-align: center'],
                            'contentOptions' => ['style' => 'padding:5px'],
                        ],
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'headerOptions' => ['style' => 'text-align: center; padding:5px'],
                            'contentOptions' => ['style' => 'text-align: center; padding:5px'],
                            'checkboxOptions' => function($data){
                                $license = $data->license;
                                if(!empty($license)){
                                    $term = $license->term;
                                    if(!empty($term)){
                                        return ['value' => json_encode($data)];
                                    }
                                }
                                return ['disabled' => true];
                            },
                            'footer' => '<button type="button" id="download_dataset" class="btn btn-info btn-primary" ><i class="fa fa  fa-floppy-o"></i> Save</button>',
                            'footerOptions' => ['style' => 'border:none']

                        ]
                    ],
                ]); ?>
            </div>
            <div class="tab-pane" id="publications" style="padding: 5px">
                <?= GridView::widget([
                    'id' => 'publications',
                    'dataProvider' => $publications,
                    'layout' => '{summary}{items}<div align="center">{pager}</div>',
                    'pager' => [
                        'firstPageLabel' => 'First',
                        'lastPageLabel' => 'Last',
                    ],
                    'columns' => [
                        [
                            'attribute' => 'publicationYear',
                            'format' => 'raw',
                            'value' => 'publicationYear',
                            'label' => 'Year',
                            'headerOptions' => ['style' => 'text-align: center']
                        ],
                        [
                            'label' => 'Title',
                            'attribute' => 'title',
                            'format' => 'raw',
                            'value' => function($data){
                                $link = $data->contentProvider[0]->providerLink;
                                $title = $data->title;
                                return Html::a($title, $link,['target'=>'_blank']);
                            },
                            'headerOptions' => ['style' => 'text-align: center'],
                            'contentOptions' => ['style' => 'padding:5px'],
                        ],
                        [
                            'attribute' => 'authors',
                            'format' => 'raw',
                            'value' => 'authors',
                            'label' => 'Authors',
                            'headerOptions' => ['style' => 'text-align: center'],
                            'contentOptions' => ['style' => 'padding:5px'],
                        ]
                    ],
                ]); ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?= Html::endForm(); ?>





