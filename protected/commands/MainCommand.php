<?php

// yiic mail send --actions=10
class MainCommand extends ConsoleCommand
{

    public $fromQueue = false;
	
	public function actionDeleteNonActiveUser(){

		$users = Users::model()->findAll('status = 4 and created_at < '.(time()-600));

        foreach($users as $u){

            if (!count($u->accounts)) {
                // delete base data
                foreach($u->rbac_roles as $role) $role->delete();
                foreach($u->phones as $phone) $phone->delete();
                if ($u->settings) $u->settings->delete();

                $deleted = new Users_Deleted;
                $deleted->attributes = $u->attributes;
                if($deleted->save()){
                    $u->delete();
                }
            }
		}
	}
	
	public function actionUpdateCurrencies(){
		try {
			$XMLContent=file("http://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml");
			//the file is updated daily between 2.15 p.m. and 3.00 p.m. CET
					
			foreach($XMLContent as $line){
				if(preg_match("/currency='([[:alpha:]]+)'/",$line,$currencyCode)){
					if(preg_match("/rate='([[:graph:]]+)'/",$line,$rate)){
						//Output the value of 1EUR for a currency code
						$currency = Currencies::model()->find('code = :code', array(':code' => $currencyCode[1]));
						if(!$currency){
							continue;
						}
						$currency->last_value = $rate[1];
						$currency->last_update = time();
						echo $currency->last_value . ' ' . $currency->code . "/n/r";
						if(!$currency->save()){
							Yii::log('Currencies not updated', CLogger::LEVEL_ERROR, 'carrencyUpdate');
						}
						
						//--------------------------------------------------
						//Here you can add your code for inserting
						//$rate[1] and $currencyCode[1] into your database
						//--------------------------------------------------
					}
				}
			}
		} catch (Exception $e) {
			Yii::log('Currencies not updated', CLogger::LEVEL_ERROR, 'carrencyUpdate');
		}
	}
}