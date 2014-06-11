	<div class="col-lg-12 col-md-12 col-sm-12 search-by-name-block scroll-cont">
		<div class="link-search">
			<div class="account-number">
				<div class="input">
					<input class="account-search-input " style="width: 100%!important" type="text">
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<?php $this->render('contactsList/alphabet') ?>
		<div class="account-search-results-cont with-alphabet scroll-block">
			

			<?php $this->render('contactsList/contactListUl', array('model' => $model)) ?>
		</div>
	</div>