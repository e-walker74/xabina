<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 25.07.14
 * Time: 19:23
 */ ?>

<?= $this->renderPartial('tabversion/_mobilePhones', array('users_phones' => $users_phones, 'data_categories' => $data_categories)) ?>

<?= $this->renderPartial('tabversion/_landlinePhones', array('user' => $user, 'data_categories' => $data_categories)) ?>