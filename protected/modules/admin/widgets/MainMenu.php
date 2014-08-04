<?php
class MainMenu extends CWidget
{
    public function run()
    {
        // Static home
        $itemsArray = array(
                //array('label'=>'Сайт', 'url'=>Yii::app()->getBaseUrl(true)),
            );
			
		array_push($itemsArray, array('label'=>Yii::t('Users', 'Users'), 'url'=>'/admin/users/admin'));
		array_push($itemsArray, array('label'=>Yii::t('Mailer', 'Mailer'), 'url'=>'/admin/mailer/mails'));
        
        /*$modules_items = array();
		array_push($modules_items, array('label'=>'Продукты', 'url'=>'/admin/comments/product'));
		array_push($modules_items, array('label'=>'Фотосессии', 'url'=>'/admin/comments/photoshoots'));
		array_push($modules_items, array('label'=>'Дизайнерские коллекции', 'url'=>'/admin/comments/designerscollections'));
		array_push($itemsArray, array('label'=>'Комментарии', 
                                        'url'=>'/admin/comments/index', 
                                        'items' => $modules_items 
                                      )
                );
		array_push($itemsArray, array('label'=>'Страницы', 
                                        'url'=>'/admin/pages/admin', 
                                      )
                );
		array_push($itemsArray, array('label'=>'Каталог', 
                                        'url'=>'/catalog/catalog/index', 
                                      )
                );
		array_push($itemsArray, array('label'=>'Фото', 
								'url'=>'/admin/photoshoot/index', 
							  )
		);
		array_push($itemsArray, array('label'=>'Дизы', 
								'url'=>'/admin/designersCollections/index', 
							  )
		);
		if(Yii::app()->user->role == 'administrator'){
			array_push($itemsArray, array('label'=>'Заказы', 
				'url'=>'/admin/orders/index', 
			));
		}*/
		

        // Static login/logout
        array_push($itemsArray,
            array('label'=>Yii::t('Admin', 'Login'), 'url'=>Yii::app()->getBaseUrl(true).'/login', 'visible'=>Yii::app()->user->isGuest)
        );
        array_push($itemsArray,
            array('label'=>Yii::t('Admin', 'Logout') .' ('.Yii::app()->user->name.')', 'url'=>Yii::app()->getBaseUrl(true).'/logout', 'visible'=>!Yii::app()->user->isGuest)
        );

        $this->render('MainMenu', array('items' => $itemsArray));
    }
}