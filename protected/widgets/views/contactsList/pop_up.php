<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 09.07.14
 * Time: 8:52
 */
?>

<div class="dropdown-menu contact-book-dropdown">
<div class="account-contact-search-cont scroll-cont">
    <?php $this->render('contactsList/alphabet', array()); ?>
<div class="account-search-results-cont contacts-list-cont scroll-block scroll-cont">
    <?php $this->render('contactsList/searchUl', array('model' => $model)) ?>
</div>
</div>
</div>
