<?php

use yii\captcha\Captcha;
use \yii\helpers\Url;
use yii\widgets\ActiveForm;
use \humhub\compat\CHtml;
use humhub\modules\user\widgets\AuthChoice;

$this->pageTitle = Yii::t('UserModule.views_auth_login', 'Login');
?>

<div class="container" style="text-align: center;">
    <div class="row">
        <div class="col-md-10" style="padding-left: 150px;padding-right: 0px;">
            <?= humhub\widgets\SiteLogo::widget(['place' => 'login']); ?>
        </div>

        <div class="col-md-2" style="float:right;padding-left: 0px;padding-right: 0px;">
            <a class="btn btn-info" href="/html/about.html">About CG Labs</a>
        </div>
    </div>
    <p style="color: #ffffff;padding-top:60px" ><strong>Frustrated at having your analytical workstream spread across multiple platforms?</strong></p>

    <p style="color: #f7941d;padding-top:40px"><strong>Using Slack or a similar tool to collaborate with your team? Email/Dropbox/FTP etc. to exchange data while worrying about security?
        GitHub to manage code? Jupyter or other analytics platform for data analysis?</strong>
    </p>

    <p style="color: #ffffff;padding-top:40px;padding-bottom:60px">
        <strong>
        Try Collaborative GARDIAN Labs – offering interlinked features to find and securely exchange data, collaborate, manage code, and analyze!
        </strong>
    </p>


    <div class="panel panel-default animated bounceIn" id="login-form"
         style="width: 100%; margin: 0 auto 20px;">

        <div class="panel-heading">

            <?php if (Yii::$app->session->hasFlash('error')): ?>
                <div class="alert alert-danger" role="alert">
                    <?= Yii::$app->session->getFlash('error') ?>
                </div>
            <?php endif; ?>

            <?php if (AuthChoice::hasClients()): ?>
                <?= AuthChoice::widget([]) ?>
            <?php else: ?>
                <?php if ($canRegister) : ?>
                    <p><?= Yii::t('UserModule.views_auth_login', "If you're already a member, please login with your username/email and password."); ?></p>
                <?php else: ?>
                    <p><?= Yii::t('UserModule.views_auth_login', "Please login with your username/email and password."); ?></p>
                <?php endif; ?>
            <?php endif; ?>




        </div>

    </div>



    <?php if ($canRegister) : ?>
        <div id="register-form"
             class="panel panel-default animated bounceInLeft"
             style="max-width: 300px; margin: 0 auto 20px; text-align: left;">

            <div class="panel-heading"><?= Yii::t('UserModule.views_auth_login', '<strong>Sign</strong> up') ?></div>

            <div class="panel-body">

                <p><?= Yii::t('UserModule.views_auth_login', "Don't have an account? Join the network by entering your e-mail address."); ?></p>

                <?php $form = ActiveForm::begin(['id' => 'invite-form']); ?>
                <?= $form->field($invite, 'email')->input('email', ['id' => 'register-email', 'placeholder' => $invite->getAttributeLabel('email'), 'aria-label' => $invite->getAttributeLabel('email')])->label(false); ?>
                <?php if ($invite->showCaptureInRegisterForm()) : ?>
                    <div id="registration-form-captcha" style="display: none;">
                        <div><?= Yii::t('UserModule.views_auth_login', 'Please enter the letters from the image.'); ?></div>

                        <?= $form->field($invite, 'captcha')->widget(Captcha::class, [
                            'captchaAction' => 'auth/captcha',
                        ])->label(false);?>
                    </div>
                <?php endif; ?>
                <hr>
                <?= CHtml::submitButton(Yii::t('UserModule.views_auth_login', 'Register'), ['class' => 'btn btn-primary', 'data-ui-loader' => '']); ?>

                <?php ActiveForm::end(); ?>
            </div>
        </div>

    <?php endif; ?>


    <?= humhub\widgets\LanguageChooser::widget(); ?>



</div>

<script type="text/javascript">
    $(function () {
        // set cursor to login field
        $('#login_username').focus();
    });

    // Shake panel after wrong validation
<?php if ($model->hasErrors()) { ?>
        $('#login-form').removeClass('bounceIn');
        $('#login-form').addClass('shake');
        $('#register-form').removeClass('bounceInLeft');
        $('#app-title').removeClass('fadeIn');
<?php } ?>

    // Shake panel after wrong validation
<?php if ($invite->hasErrors()) { ?>
        $('#register-form').removeClass('bounceInLeft');
        $('#register-form').addClass('shake');
        $('#login-form').removeClass('bounceIn');
        $('#app-title').removeClass('fadeIn');
<?php } ?>

<?php if ($invite->showCaptureInRegisterForm()) { ?>
    $('#register-email').on('focus', function () {
        $('#registration-form-captcha').fadeIn(500);
    });
<?php } ?>

</script>


