<div class="auth-question">
	
    <?php
        $attrs = $identity->getAttributes();
        $login = '';
        if(isset($attrs['name'])){
            $login = $attrs['name'];
        }
        if(isset($attrs['surname'])){
            $login .= ' ' . $attrs['surname'];
        }
        if(!$login && isset($attrs['login'])){
            $login = $attrs['login'];
        }
    ?>
	<div class="question">
		<p><?= Yii::t('Login', 'Вы сможете входить на сайт migom.by без ввода пароля через свой аккаунт <strong class="{class}">{name}</strong>', array('{class}' => $service, '{name}' => $login)); ?></p>
		<input type="submit" onclick="window.location = '<?= $this->createUrl('site/login', array('reg_ask' => 1, 'service' => $service, 'user' => 'new')); ?>'" value="Я новый пользователь" />
		<input type="submit" onclick="window.location = '<?= $this->createUrl('site/login', array('reg_ask' => 1, 'service' => $service, 'user' => 'haveALogin')); ?>'" value="Я регистрировался ранее" />
	</div>
	<div class="logo"></div>
</div>
