<?php
    /* @var $this \yii\web\View */
    /* @var $title string */

    // 加载js、css样式
    \app\modules\backend\web\ManifestAssetBundle::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= \Yii::$app->language ?>">
    <head>
        <meta charset="<?= \Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="api-host" content="<?= $_ENV['APP_URL'] . '/admin/api/'; ?>">
        <meta name="host" content="<?= $_ENV['APP_URL']; ?>">
        <title><?= $_ENV['APP_NAME'] ?></title>

        <style>
            .loader {
                bottom: 0;
                left: 0;
                overflow: hidden;
                position: fixed;
                right: 0;
                top: 0;
                z-index: 99999;
            }

            .loader img {
                width: 333px;
                height: 200px;
                margin: 0 auto;
                display: block;
                top: 20%;
                position: relative;
                object-fit: cover;
            }

            .yaa-admin-loader-inner {
                bottom: 0;
                height: 60px;
                left: 0;
                margin: auto;
                position: absolute;
                right: 0;
                top: 0;
                width: 100px;
            }

            .yaa-admin-loader-line-wrap {
                animation: spin 1000ms cubic-bezier(.175, .885, .32, 1.275) infinite;
                box-sizing: border-box;
                height: 50px;
                left: 0;
                overflow: hidden;
                position: absolute;
                top: 0;
                transform-origin: 50% 100%;
                width: 100px;
            }

            .yaa-admin-loader-line {
                border: 5px solid transparent;
                border-radius: 100%;
                box-sizing: border-box;
                height: 100px;
                left: 0;
                margin: 0 auto;
                position: absolute;
                right: 0;
                top: 0;
                width: 100px;
            }

            .yaa-admin-loader-line-wrap:nth-child(1) {
                animation-delay: -50ms;
            }

            .yaa-admin-loader-line-wrap:nth-child(2) {
                animation-delay: -100ms;
            }

            .yaa-admin-loader-line-wrap:nth-child(3) {
                animation-delay: -150ms;
            }

            .yaa-admin-loader-line-wrap:nth-child(4) {
                animation-delay: -200ms;
            }

            .yaa-admin-loader-line-wrap:nth-child(5) {
                animation-delay: -250ms;
            }

            .yaa-admin-loader-line-wrap:nth-child(1) .yaa-admin-loader-line {
                border-color: hsl(0, 80%, 60%);
                height: 90px;
                width: 90px;
                top: 7px;
            }

            .yaa-admin-loader-line-wrap:nth-child(2) .yaa-admin-loader-line {
                border-color: hsl(60, 80%, 60%);
                height: 76px;
                width: 76px;
                top: 14px;
            }

            .yaa-admin-loader-line-wrap:nth-child(3) .yaa-admin-loader-line {
                border-color: hsl(120, 80%, 60%);
                height: 62px;
                width: 62px;
                top: 21px;
            }

            .yaa-admin-loader-line-wrap:nth-child(4) .yaa-admin-loader-line {
                border-color: hsl(180, 80%, 60%);
                height: 48px;
                width: 48px;
                top: 28px;
            }

            .yaa-admin-loader-line-wrap:nth-child(5) .yaa-admin-loader-line {
                border-color: hsl(240, 80%, 60%);
                height: 34px;
                width: 34px;
                top: 35px;
            }

            @keyframes spin {
                0%, 15% {
                    transform: rotate(0);
                }
                100% {
                    transform: rotate(360deg);
                }
            }
        </style>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div id="app">
        <div class="loader">
            <img src="https://gratisography.com/wp-content/uploads/2022/06/gratisography-old-skater-free-stock-photo-1170x780.jpg"/>
            <div class="yaa-admin-loader-inner">
                <div class="yaa-admin-loader-line-wrap">
                    <div class="yaa-admin-loader-line"></div>
                </div>
                <div class="yaa-admin-loader-line-wrap">
                    <div class="yaa-admin-loader-line"></div>
                </div>
                <div class="yaa-admin-loader-line-wrap">
                    <div class="yaa-admin-loader-line"></div>
                </div>
                <div class="yaa-admin-loader-line-wrap">
                    <div class="yaa-admin-loader-line"></div>
                </div>
                <div class="yaa-admin-loader-line-wrap">
                    <div class="yaa-admin-loader-line"></div>
                </div>
            </div>
        </div>
    </div>

    <?php $this->endBody(); ?>
    </body>

    </html>
<?php $this->endPage();
