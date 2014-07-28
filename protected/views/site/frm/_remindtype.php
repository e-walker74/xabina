<div class="popup-register-cont">
			

                    <div class="popup-register-block auth">

					<div class="popup-language-menu"  style="background-color: rgba(237, 239, 238, 1)">
                        <div class="language-current"><a class="<?= Yii::app()->language ?>" href="#"><?= Yii::app()->params->translatedLanguages[Yii::app()->language] ?></a></div>
                        <ul class="language-list">
							<?php foreach(Yii::app()->params->translatedLanguages as $label => $translate): ?>
								<?php if($label == Yii::app()->language) continue; ?>
								<li class="<?= $label ?>" >
									<?= CHtml::link($translate, array(Yii::app()->request->url, 'language' => $label)); ?>
								</li>
							<?php endforeach; ?>
                        </ul>
                    </div>
                        <div class="shadow_blocker"></div>
                        <div class="popup-register-header"><?= Yii::t('Front', 'Restore profile access') ?></div>

                            <div class="popup-register-form forgot-form" id="popup-auth-form">
                                 <?= Yii::t('Front', 'Choose one of the ways to restore access') ?>
                                <ul class="form-list cannot-method">
                                    <li>
                                        <a class="mobile-phone" href="?type=phone"><span><?= Yii::t('Front', 'I remember my mobile phone') ?></span></a>
                                    </li>
                                    <li>
                                         <a href="?type=email" class="email"><span><?= Yii::t('Front', 'I remember my E-Mail') ?></span></a>
                                    </li>
                                    <li>
                                         <a href="?type=login" class="user-id"><span><?= Yii::t('Front', 'I lost my phone but remember my User ID') ?></span></a>
                                    </li>
                                    <li>
                                     <a href="/site/remindSupportCall" class="name"><span><?= Yii::t('Front', 'I forgot everything, but remember my name') ?></span></a>
                                    </li>
                                </ul>
                            </div>
                    </div>

                </div>