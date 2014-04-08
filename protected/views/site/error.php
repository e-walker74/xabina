<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <title><?= $message; ?></title>    
	<link rel="stylesheet" type="text/css" href="/css/reset.css" />
    
    <link rel="stylesheet" type="text/css" href="/css/page_404.css" />

</head>
<body style="background:#ccc">

<div class="block_404">
    <a href="http://xabina.intwall.com/"><img alt="" src="/images/logo.png" /></a>

    <hgroup>
        <h2 style="margin-left:-2px;"><?= $message; ?></h2>
        <h6><?= Yii::t('Front', 'Error :code', array(':code' => $code)); ?></h6>
    </hgroup>
</div>

</body>
</html>