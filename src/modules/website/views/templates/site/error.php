<?php
    /**
     * Created by PhpStorm.
     * User: umono
     * Date: 2020/6/8
     * Time: 4:01 PM
     */
    $context = $this->context;
?>
<style>
    body {
        margin: 0 auto;
        margin-top: 48px;
        max-width: 616px;
        padding: 0 16px;
        font-family: 'Roboto', 'Helvetica Neue', sans-serif;
        font-size: 16px;
        line-height: 24px;
        color: rgba(0, 0, 0, 0.87);
    }

    h1,
    h2,
    h3 {
        font-family: 'Roboto', 'Helvetica Neue', sans-serif;
        font-weight: 300;
    }

    h1 {
        margin: 24px 0 16px 0;
        padding: 0 0 16px 0;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        font-size: 32px;
        line-height: 36px;
    }

    h2 {
        margin: 24px 0 16px 0;
        padding: 0;
        font-size: 20px;
        line-height: 32px;
        color: rgba(0, 0, 0, 0.54);
    }

    p {
        margin: 0;
        margin-bottom: 16px;
    }

    ol {
        margin: 0;

    }

    ol li {
        margin: 0;
        line-height: 24px;
        padding-left: 12px;
    }

    a {
        color: #039BE5;
        text-decoration: underline;
    }

    a:hover {
        text-decoration: underline;
    }

    code {
        display: inline-block;
        padding: 3px 4px;
        background-color: #ECEFF1;
        border-radius: 3px;
        font-family: 'Roboto Mono', "Liberation Mono", Courier, monospace;
        font-size: 14px;
        line-height: 1;
    }

    .logo {
        display: block;
        text-align: center;
        margin-top: 48px;
        margin-bottom: 24px;
    }

    img {
        width: 220px;
    }

    @media screen and (max-width: 616px) {
        body {
            margin-top: 24px;
        }

        .logo {
            margin: 0;
        }
    }
</style>
<h1><?= $exception->getMessage();?></h1>
<p>该文件不存在，并且<code>index.html</code>在当前目录或<code>404.html</code>根目录中都找不到。</p>
<h2>我为什么看到这个？</h2>

<p>您可能为应用程序部署了错误的目录。检查您<code>firebase.json</code>的目录，并确保<strong>公共</strong> 目录指向包含<code>index.html</code>文件的目录。</p>
<p>您也可以 <code>404.html</code>在网站的根目录中添加，以用自定义错误页面替换此页面。
</p>
<!--<a class="logo" href="https://firebase.google.com/">-->
<!--    <img src="/style/images/logo.png">-->
<!--</a>-->

