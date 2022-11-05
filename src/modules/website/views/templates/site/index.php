<?php
   /** @var $apiList array */
   /** @var $home array */
?>
<meta name="viewport"
      content="initial-scale=1, maximum-scale=3, minimum-scale=1, user-scalable=no">


<div class="bg c">
    <div class="box">
        <div class="bg-content">
            <h1 style="margin-bottom: 32px;margin-top: 80px;""><?= $_ENV['APP_NAME']; ?></h1>
            <div class="icon-list">
                <div class="hot"
                ">🔥
            </div>
            <div class="icontab">
                <?php foreach ($home as $k => $v):
                    if ($v['isShowHome'] == true):?>
                        <div class="icontab-btn">
                            <img class="icon" src="<?= $v['icon']; ?>" alt="">
                            <?= $v['title']; ?>
                        </div>
                    <?php endif;
                endforeach; ?>
            </div>
        </div>
        <div style="margin-top: 100px;">
            <a class="go start" style="background: white;color:#056cff;" href="/admin">开始管理</a>
        </div>
    </div>
</div>
<div class="box">
    <div class="bg-content">
        <h2>应用列表</h2>
        <div style="display: flex;flex-wrap: wrap;justify-content: space-between;">
            <?php foreach ($home as $k => $v):
                if ($v['isShowHome'] == true):?>
                    <div class="card-item">
                        <img style="width: 66px;
    height: 66px;
    background: #e2e9f7;
    border-radius: 12px;" src="<?= $v['icon']; ?>" alt="">
                        <p style="color: rgb(86, 85, 124);
    font-weight: bold;
}">
                            <?= $v['title']; ?>
                        </p>
                        <div style="color: rgb(172, 176, 185);
    font-size: 0.9em;margin-bottom: 16px;">
                            <?= $v['des']; ?>
                        </div>
                        <div style="color: rgb(170, 174, 183);
    font-size: 0.8em;">
                            <?= $v['version']; ?>
                        </div>
                    </div>
                <?php endif;
            endforeach; ?>
        </div>
    </div>
</div>

<div class="box api">
    <?php if ($_ENV['APP_ENV'] == 'dev'): ?>
        <div class="bg-content" style="margin:16px;">
            <h2>文档说明</h2>
            <?php foreach ($apiList as $k => $v): ?>
                <a class="go-block go" target="_blank" href="<?= "/site/$k-doc" ?>">
                    <?= $v ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>


<style>
    html, body {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        background: #041a41;
    }

    .bg {
        background-image: url("/images/homebg.jpeg");
        background-position: 100% 100%;
        background-repeat: no-repeat;
        background-size: cover;
        width: 100%;
        height: 640px;
    }

    .c {
        box-sizing: border-box;
        margin: 0px;
        min-width: 0px;
        background-color: rgb(5, 40, 108);
        flex-direction: column;
        padding-bottom: 0px;
        display: flex;
    }

    .bg-content {
        max-width: 1088px;
        width: 1088px;
        padding-left: 0px !important;
        padding-right: 0px !important;
        color: white;
    }

    .box {
        box-sizing: border-box;
        min-width: 0px;
        padding-top: 32px;
        display: flex;
        position: relative;
        width: 100%;
        -webkit-box-pack: center;
        justify-content: center;
    }

    .go {
        color: white;
        text-decoration: none;
    }

    .icon-list {
        display: flex;
        align-items: center;
        height: 49px;
        margin-bottom: 32px;
    }

    .hot {
        margin-right: 16px;
        letter-spacing: 0;
        font: 400 18px/21px Roboto, -apple-system, BlinkMacSystemFont, "Segoe UI", Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
    }

    .icontab {
        position: relative;
        display: inline-flex;
        flex-direction: row;
        flex-wrap: wrap;
        height: 49px;
        padding-right: 0;
        overflow: hidden;
        background-color: #01112f;
        border-radius: 20px;
        font: 400 18px/21px Roboto, -apple-system, BlinkMacSystemFont, "Segoe UI", Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;
    }

    .icontab-btn {
        position: relative;
        display: flex;
        align-items: center;
        flex-direction: row;
        padding: 9px 21px 9px 12px;
        color: #fff;
        cursor: pointer;
        background-color: #01112f;
        border-radius: 20px;
        transition: all .2s ease;
    }

    .icontab-btn:hover {
        color: #fff;
        background-color: #4f6698;
    }

    .icon {
        width: 16px;
        height: 16px;
        margin-right: 10px;
        border-radius: 16px;
        background: #f6f6f6;
    }

    .api {
        width: 100%;
        height: 50%;
        margin: 0;
    }

    /*block*/
    .block {
        background: #056cff 0 0 no-repeat padding-box;
        border-radius: 5px;
        margin-bottom: 16px;
    }

    .go-block {
        background: #056cff 0 0 no-repeat padding-box;
        border-radius: 5px;
        margin-bottom: 16px;
        padding: 16px;
        display: block;
    }

    .start {
        border: 1px solid white;
        padding: 12px;
        border-radius: 8px;
        font-weight: 700;
        text-align: center;
    }

    .start:hover {
        background: white;
        color: #056cff;
        transition: all 0.5s;
    }

    .card-item {
        width: 40%;
        background: white;
        border-radius: 16px;
        padding: 20px;
        /*box-shadow: 0 18px 45px #eaebf7;*/
        font-family: PingFangSC;
        margin-bottom: 32px;
    }
</style>

