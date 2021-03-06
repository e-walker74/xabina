<?php

class TransfersController extends Controller
{

    public $layout = 'banking';
    public $title  = '';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
			array('allow', // allow readers only access to the view file
                'actions' => array(''),
                'users' => array('*')
            ),
            array('allow', // allow readers only access to the view file
                'actions' => array(
                    'outgoing',
                    'incoming',
                    'overview',
                    'delete',
                    'smsverivicaiton',
                    'smsconfirm',
                    'success',
					'successincoming',
                    'resendsms',
                    'history',
                    'getbankname',
					'standing',
					'deletestanding',
					'IncomingOverview',
					'createinvoice',
					'createinvoiceoption',
                    'duplicate',
				),
                'roles' => array('client')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

    /**
     * outgoing new version
     * template newtransfer_xabina_15.psd
     * codding http://nikxabina.intwall.com/layout/account/new_transfer.html
     */
    public function actionOutgoing()
	{
        $this->breadcrumbs[Yii::t('Front', 'New Transfer')] = '';

        $user = Users::model()->with('settings')->findByPk(Yii::app()->user->id);
        $accounts = $user->accounts;
        if (empty($user->accounts)) {
            throw new CHttpException(404, Yii::t('Front', 'You have not any accounts'));
        }

        /**
         * Start save Quick transfer
         */

        if (isset($_POST['quick'])) {
            $quick = Transfers_Outgoing_Favorite::model()->findByPk($_POST['quick']);
            if ($quick->user_id == Yii::app()->user->id) {
                $transfer = new Transfers_Outgoing();
                $transfer->attributes = $quick->attributes;
                if ($transfer->save()) {
                    echo CJSON::encode(array('success' => true, 'url' => Yii::app()->createUrl('/transfers/overview')));
                }
                Yii::app()->end();
            }
        }

        /**
         * End quick transfer
         */

        $number = Yii::app()->request->getParam('account', '', 'int');
        $transfer = false;
		$redirectTo = '/transfers/overview';
		
		if (($transfer = Yii::app()->request->getParam('transfer', '', 'int')) && !Yii::app()->request->getParam('backTransfer', '', 'int')) {
			if ($transfer && $transfer = Transfers_Outgoing::model()->findByPk($transfer)) {
                $number = $transfer->account_number;
			}
		}

        if (Yii::app()->request->getParam('transfer', '', 'int') && Yii::app()->request->getParam('backTransfer', '', 'int')) {
            if ($transferIncoming = Transfers_Incoming::model()->findByPk(Yii::app()->request->getParam('transfer', '', 'int'))){
                $transfer = Transfers_Outgoing::model();
                $transfer->attributes = $transferIncoming->attributes;
                $transfer->to_account_number = $transferIncoming->from_account_number;
                $transfer->to_account_holder = $transferIncoming->from_account_holder;
            }
        }
		
		if (Yii::app()->request->getParam('standing', '', 'int')) {
			$transfer = Yii::app()->request->getParam('standing', '', 'int');
			if ($transfer && $transfer = Transfers_Outgoing_Standing::model()->findByPk($transfer)) {
				$number = $transfer->account_number;
				$redirectTo = '/transfers/standing';
			}
		}
		
		if ($transfer && $transfer->user_id != Yii::app()->user->id) {
			//throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		
        if ($number) {
            $selectedAcc = Accounts::model()->find('user_id = :uid AND number = :number', array(':uid' => Yii::app()->user->id, ':number' => $number));

            if (!$selectedAcc)
                throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        } elseif (Yii::app()->request->getParam('copyTransfer', '', 'int') || Yii::app()->request->getParam('backTransfer', '', 'int')) {
            $selectedAcc = $accounts[0];
        } else {
            $selectedAcc = $accounts[0];
            foreach($accounts as $acc) {
                if ($acc->balance > 0) {
                    $this->redirect(array('/transfers/outgoing', 'account' => $acc->number));
                    Yii::app()->end();
                }
            }
            $this->redirect(array('/transfers/outgoing', 'account' => $selectedAcc->number));
            Yii::app()->end();
        }

        /*
         * Own Form
         */
        $ownForm = new Form_Outgoingtransf_Own;

        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'own-form') {
            echo $ownForm->validateWithNotify();
            Yii::app()->end();
        }

        if (isset($_POST['Form_Outgoingtransf_Own'])) {
            $ownForm->attributes = $_POST['Form_Outgoingtransf_Own'];
            if (Yii::app()->request->getParam('copyTransfer', '', 'int') || Yii::app()->request->getParam('backTransfer', '', 'int')) {
                $ownForm->need_confirm = 1;
                $transfer = null;
            }

            $message = Yii::t('Front', 'Payment was saved successfully');
            if ($ownForm->save($transfer)) {
                if (isset($_GET['next'])) {
                    echo CJSON::encode(array(
                        'success' => true,
                        'clean' => false,
                        'message' => $message,
                        'url' => Yii::app()->createUrl($redirectTo)
                    ));
                } else {
                    echo CJSON::encode(array('success' => true, 'clean' => true, 'message' => $message));
                }
            } else {
                echo CJSON::encode(array('success' => false, 'message' => ''));
            }
            Yii::app()->end();
        }
        /*
         * end Own Form
         */

        /*
         * start Another Xabina account
         */
        $anotherForm = new Form_Outgoingtransf_Another;

        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'another-form') {
            echo $anotherForm->validateWithNotify();
            Yii::app()->end();
        }
		
        if(isset($_POST['Form_Outgoingtransf_Another'])){
            $anotherForm->attributes = $_POST['Form_Outgoingtransf_Another'];
            if (Yii::app()->request->getParam('copyTransfer', '', 'int') || Yii::app()->request->getParam('backTransfer', '', 'int')) {
                $anotherForm->need_confirm = 1;
                $transfer = null;
            }

            $message = Yii::t('Front', 'Payment was saved successfully');
            if ($anotherForm->save($transfer)) {
                if (isset($_GET['next'])) {
                    echo CJSON::encode(array(
                        'success' => true,
                        'clean' => false,
                        'message' => $message,
                        'url' => Yii::app()->createUrl($redirectTo)
                    ));
                } else {
                    echo CJSON::encode(array('success' => true, 'clean' => true, 'message' => $message));
                }
            } else {
                echo CJSON::encode(array('success' => false, 'message' => ''));
            }
            Yii::app()->end();
        }
        /*
         * end Another Xabina Account
         */

        /*
         * start External Xabina account
         */
        $externalForm = new Form_Outgoingtransf_External;

        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'external-form') {
            echo $externalForm->validateWithNotify();
            Yii::app()->end();
        }

        if (isset($_POST['Form_Outgoingtransf_External'])) {
            $externalForm->attributes = $_POST['Form_Outgoingtransf_External'];
            if (Yii::app()->request->getParam('copyTransfer', '', 'int') || Yii::app()->request->getParam('backTransfer', '', 'int')) {
                $externalForm->need_confirm = 1;
                $transfer = null;
            }

            $message = Yii::t('Front', 'Payment was saved successfully');
            if ($externalForm->save($transfer)) {
                if (isset($_GET['next'])) {
                    echo CJSON::encode(array(
                        'success' => true,
                        'clean' => false,
                        'message' => $message,
                        'url' => Yii::app()->createUrl($redirectTo)
                    ));
                } else {
                    echo CJSON::encode(array('success' => true, 'clean' => true, 'message' => $message));
                }
            } else {
                echo CJSON::encode(array('success' => false, 'message' => ''));
            }
            Yii::app()->end();
        }
        /*
         * end External Xabina Account
         */

        /*
         * start E-Wallet Xabina account
         */
        $ewalletForm = new Form_Outgoingtransf_Ewallet;

        if (isset($_POST['Form_Outgoingtransf_Ewallet'])) {
            $ewalletForm->attributes = $_POST['Form_Outgoingtransf_Ewallet'];

            switch($ewalletForm->ewallet_type) {
                case 1:
                    $ewalletForm->scenario = 'paypall';
                    break;
                case 2:
                    $ewalletForm->scenario = 'webmoney';
                    break;
                case 3:
                    $ewalletForm->scenario = 'scrill';
                    break;
            }
        }

        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'ewallet-form') {
            echo $ewalletForm->validateWithNotify();
            Yii::app()->end();
        }

        if (isset($_POST['Form_Outgoingtransf_Ewallet'])) {
            $ewalletForm->attributes = $_POST['Form_Outgoingtransf_Ewallet'];
            if (Yii::app()->request->getParam('copyTransfer', '', 'int') || Yii::app()->request->getParam('backTransfer', '', 'int')) {
                $ewalletForm->need_confirm = 1;
                $transfer = null;
            }

            $message = Yii::t('Front', 'Payment was saved successfully');
            if ($ewalletForm->save($transfer)) {
                if (isset($_GET['next'])) {
                    echo CJSON::encode(array(
                        'success' => true,
                        'clean' => false,
                        'message' => $message,
                        'url' => Yii::app()->createUrl($redirectTo)
                    ));
                } else {
                    echo CJSON::encode(array('success' => true, 'clean' => true, 'message' => $message));
                }
            } else {
                echo CJSON::encode(array('success' => false, 'message' => ''));
            }
            Yii::app()->end();
        }
        /*
         * end E-Wallet Xabina Account
         */

        /**
         * Update transfer
         */
        if ($transfer) {
            switch($transfer->form_type) {
                case 'own':
                    $ownForm->attributes = $transfer->attributes;
                    break;
                case 'another':
                    $anotherForm->attributes = $transfer->attributes;
                    break;
                case 'external':
                    $externalForm->attributes = $transfer->attributes;
                    break;
                case 'ewallet':
                    $ewalletForm->attributes = $transfer->attributes;
                    break;
                default :
                    $transfer->form_type = 'external';
                    $externalForm->attributes = $transfer->attributes;
                    break;
            }
        }

        /**
         * Quick Transfers
         */
        $quickTransfers = Transfers_Outgoing_Favorite::model()->findAll(
            array(
                'condition' => 'user_id = :uid',
                'params' => array(':uid' => Yii::app()->user->id),
                'order' => 'created_at desc',
            )
        );

        $quickForm = new Transfers_Outgoing_Favorite();

        if (isset($_POST['Transfers_Outgoing_Favorite']) && strpos(Yii::app()->request->getParam('ajax'), 'quick-form') === 0) {
            echo $quickForm->validateWithNotify();
            Yii::app()->end();
        }

        if (isset($_POST['Transfers_Outgoing_Favorite'])) {
            if (isset($_POST['Transfers_Outgoing_Favorite']['id'])) {
                $favorite = Transfers_Outgoing_Favorite::model()->findByPk($_POST['Transfers_Outgoing_Favorite']['id']);
                $favorite->attributes = $_POST['Transfers_Outgoing_Favorite'];
                $favorite->save();
                $message = Yii::t('Front', 'Saved');
                if (isset($_GET['next'])) {
                    echo CJSON::encode(array(
                        'success' => true,
                        'clean' => false,
                        'message' => $message,
                        'url' => Yii::app()->createUrl($redirectTo)
                    ));
                } else {
                    echo CJSON::encode(array('success' => true, 'clean' => true, 'message' => $message));
                }
                Yii::app()->end();
            }
        }

        $currencies = Currencies::model()->findAll();
        $categories = Transactions_Categories::model()->findAll('user_id = :uid OR user_id = 0', array(':uid' => Yii::app()->user->id));

		$searchTransfers = Widget::create('ContactListWidget', 'searchTransfers', 
			array(
				'type' => 'searchTransfers',
				'withAlphabet' => false,
			)
		);
		
		$search = Widget::create('ContactListWidget', 'searchWidget', 
			array(
				'type' => 'searchHolders',
				'withAlphabet' => true,
			)
		);

        $this->render('outgoingv2', array(
            'user'          => $user,
            'selectedAcc'   => $selectedAcc,
            'currencies'    => $currencies,
            'categories'    => $categories,
            'ownForm'       => $ownForm,
            'anotherForm'   => $anotherForm,
            'externalForm'  => $externalForm,
            'ewalletForm'   => $ewalletForm,
            'transfer'      => $transfer,
            'quickTransfers'=> $quickTransfers,
            'quickForm'     => $quickForm,
			'searchTransfers'=>$searchTransfers,
        ));
    }

    public function actionIncoming()
    {
        $this->breadcrumbs[Yii::t('Front', 'Upload money')] = '';

        $user = Users::model()->with('settings')->findByPk(Yii::app()->user->id);
        $accounts = $user->accounts;
        if (empty($user->accounts)) {
            throw new CHttpException(404, Yii::t('Front', 'You have not any accounts'));
        }

        /*
         * start Payment Request Form
         */
        $incoming_request = new Form_Incoming_Request;

        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'request-form') {
            echo CActiveForm::validate($incoming_request);
            Yii::app()->end();
        }

        if (isset($_POST['Form_Incoming_Request'])) {
            $incoming_request->attributes = $_POST['Form_Incoming_Request'];
            $message = Yii::t('Front', 'Payment was saved successfully');
            if ($incoming_request->save()) {
				Yii::app()->session['flash_notify'] = array(
					'title' => Yii::t('Front', 'Upload'),
					'message' => Yii::t('Front', 'Upload was successfully saved'),
				);
                echo CJSON::encode(array(
                    'success' => true,
                    'clean' => false,
                    'message' => $message,
                    'url' => Yii::app()->createUrl('/transfers/successincoming')
                ));
            } else {
                echo CJSON::encode(array('success' => false, 'message' => ''));
            }
            Yii::app()->end();
        }
        /*
         * end Payment Request Form
         */

		/*
         * start Electronic Form
         */
        $electronic_request = new Form_Incoming_Electronic;

		if (   isset($_POST['Form_Incoming_Electronic']) 
			&& isset($_POST['Form_Incoming_Electronic']['electronic_method'])
			&& isset(Form_Incoming_Electronic::$methods[$_POST['Form_Incoming_Electronic']['electronic_method']])
		) {
			$electronic_request->scenario = Form_Incoming_Electronic::$methods[$_POST['Form_Incoming_Electronic']['electronic_method']];
		}
		
        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax')=='electronic-form') {
            echo CActiveForm::validate($electronic_request);
            Yii::app()->end();
        }

        if (isset($_POST['Form_Incoming_Electronic'])) {
            $electronic_request->attributes = $_POST['Form_Incoming_Electronic'];
            $message = Yii::t('Front', 'Payment was saved successfully');
            if ($electronic_request->save()) {
				Yii::app()->session['flash_notify'] = array(
					'title' => Yii::t('Front', 'Upload'),
					'message' => Yii::t('Front', 'Upload was successfully saved'),
				);

                echo CJSON::encode(array(
                    'success' => true,
                    'clean' => false,
                    'message' => $message,
                    'url' => Yii::app()->createUrl('/transfers/successincoming')
                ));
			} else {
                echo CJSON::encode(array('success' => false, 'message' => ''));
            }
            Yii::app()->end();
        }
        /* end Electronic Form */

        /*
         * start favorite transfers
         */
		$quickForm = new Form_Incoming_Quick();

        if (isset($_POST['quick'])) {
            $quick = Transfers_Incoming_Favorite::model()->findByPk($_POST['quick']);
            if ($quick->user_id == Yii::app()->user->id) {
                $transfer = new Transfers_Incoming();
                $transfer->form_type = $quick->form_type;
				$transfer->electronic_method = $quick->electronic_method;
				$transfer->attributes = $quick->attributes;
				if ($transfer->save()) {
                    $tm = Transfers_Model::model($transfer->form_type);
                    $tm->createInComingTransaction($transfer);
					Yii::app()->session['flash_notify'] = array(
						'title' => Yii::t('Front', 'Upload'),
						'message' => Yii::t('Front', 'Upload was successfully saved'),
					);
                    echo CJSON::encode(array('success' => true, 'url' => Yii::app()->createUrl('/transfers/successincoming')));
                } else {
//                    dd($transfer->getErrors());
                }
                Yii::app()->end();
            }
        }
		
		if (isset($_POST['Form_Incoming_Quick']) && strrpos(Yii::app()->request->getParam('ajax'), 'quick-form') === 0) {
			echo CActiveForm::validate($quickForm);
            Yii::app()->end();
		}
		
		if (isset($_POST['Form_Incoming_Quick'])) {
			if (!isset($_POST['Form_Incoming_Quick']['tid'])) {
				throw new CHttpException(404, Yii::t('Front', 'Page not found'));
			}
			$transaction = Transfers_Incoming_Favorite::model()->findByPk($_POST['Form_Incoming_Quick']['tid']);
			$transaction->scenario = 'quickUpdate';
			$quickForm->attributes = $transaction->attributes;
			$quickForm->attributes = $_POST['Form_Incoming_Quick'];
			if ($quickForm->validate()) {
				$transaction->attributes = $quickForm->attributes;
				$transaction->save();
				echo CJSON::encode(array('success' => true));
			}
			Yii::app()->end();
		}
		
		/** end favorite transfers */
		
		$favorites = Transfers_Incoming_Favorite::model()
            ->with(array('account', 'account.user'))
            ->own()
            ->findAll();

        $currencies = Currencies::model()->findAll();
        $categories = Transactions_Categories::model()->findAll('user_id = :uid OR user_id = 0', array(':uid' => Yii::app()->user->id));

        $this->render('incoming', compact(
            'user',
			'favorites',
            'currencies',
            'categories',
            'incoming_request',
			'electronic_request',
			'quickForm'
        ));
    }
	
	public function actionOverview()
    {
		$transfers = Transfers_Outgoing::model()->findAll('user_id = :uid AND need_confirm = 1', array('uid' => Yii::app()->user->id));
		
		$this->breadcrumbs[Yii::t('Front', 'New Transfer')] = array('/transfers/outgoing');
		$this->breadcrumbs[Yii::t('Front', 'Transfers overview')] = '';

        if (isset($_POST['User_Overview'])) {
            Transfers_Confirmation::model()->deleteAll('user_id = :uid', array(':uid' => Yii::app()->user->id));
            $success = true;
            foreach($_POST['User_Overview'] as $trans_id) {
                if (!$trans_id)
                    continue;
                $confirmation = new Transfers_Confirmation;
                $confirmation->group_id = 0;
                $confirmation->transfer_id = $trans_id;
                $confirmation->user_id = Yii::app()->user->id;
                $confirmation->active = 0;
                if (!$confirmation->save()) {
                    $success = false;
                }
            }

            $trans = Transfers_Confirmation::model()->with('transfer')->findAll('t.user_id = :uid', array(':uid' => Yii::app()->user->id));
            $transes = array();

            /**
             * Check balance in euro. When we add the percent we use another function
             */
            $sumInEur = array();

            foreach($trans as $tr) {
                if (!isset($sumInEur[$tr->transfer->account_number])) {
                    $sumInEur[$tr->transfer->account_number]['balance'] = $tr->transfer->account->getBalanceInEUR();
                    $sumInEur[$tr->transfer->account_number]['sum'] = Currencies::convert($tr->transfer->amount, $tr->transfer->currency->code, 'EUR');
                }else{
                    $sumInEur[$tr->transfer->account_number]['sum'] = $sumInEur[$tr->transfer->account_number]['sum'] + Currencies::convert($tr->transfer->amount, $tr->transfer->currency->code, 'EUR');
                }

                if (!isset($transes[$tr->transfer->currency->code])) {
                    $transes[$tr->transfer->currency->code] = array(
                        'amount' => $tr->transfer->amount,
                        'count' => 1,
                    );
                } else {
                    $transes[$tr->transfer->currency->code] = array(
                        'amount' => $transes[$tr->transfer->currency->code]['amount'] + $tr->transfer->amount,
                        'count' => $transes[$tr->transfer->currency->code]['count']+1,
                    );
                }
            }

            $valid = true;
            foreach($sumInEur as $acc => $ar) {
                if ($ar['balance'] < $ar['sum']) {
                    $valid = false;
                }
            }

            $html = $this->renderPartial('_checked', array('transes' => $transes, 'valid' => $valid), true, false);
            echo CJSON::encode(array('success'=>$success, 'html' => $html, 'error' => !$valid, 'message' => Yii::t('Front', 'Not enough money')));
            Yii::app()->end();

        }
		
		$this->render('overview', array('transfers' => $transfers, 'valid' => true));
	}
	
	public function actionSuccess()
    {
		$this->breadcrumbs[Yii::t('Front', 'New Transfer')] = array('/transfers/outgoing');
		$this->breadcrumbs[Yii::t('Front', 'SMS-verification')] = '';
		$this->breadcrumbs[Yii::t('Front', 'Success')] = '';
		
		$time = time() - 3600 * 24 * 5;
		$transfers = Transfers_Outgoing::model()->findAll(array('condition' => 'user_id = :uid AND (created_at > ' . $time . ')', 'params' => array(':uid' => Yii::app()->user->id), 'order' => 'created_at desc'));
	
		$this->render('success', array('transfers' => $transfers));
	}
	
	public function actionDelete($id)
    {
		$transfers = Transfers_Outgoing::model()->findByPk($id);
		if ($transfers && $transfers->user_id == Yii::app()->user->id && $transfers->need_confirm == 1) {
			$transfers->delete();
			echo CJSON::encode(array('success' => true));
			Yii::app()->end();
		}
		echo CJSON::encode(array('success' => false));
	}
	
	public function actionSmsConfirm()
    {
		$this->breadcrumbs[Yii::t('Front', 'New Transfer')] = array('/transfers/outgoing');
		$this->breadcrumbs[Yii::t('Front', 'SMS-verification')] = '';
	
		$form = new Form_Smsconfirm();
		if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'sms-confirmation-code') {
            echo CActiveForm::validate($form);
            Yii::app()->end();
        }
		if (isset($_POST['Form_Smsconfirm']) && Yii::app()->request->isAjaxRequest ) {
			$confs = Transfers_Confirmation::model()->findAll('user_id = :uid AND active = 1', array(':uid' => Yii::app()->user->id));
			if (count($confs)) {
				$smsshot = Yii::app()->cache->get('transferSmsShot'.$confs[0]->transfer_id.Yii::app()->user->id);
				if (!$smsshot) {
					$smsshot = 1;
				}
				if ($smsshot >= 3) {
					echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'Try in a hour')));
					Yii::app()->end();
				}elseif ($confs[0]->confirm_code != (int)$_POST['Form_Smsconfirm']['code']) {
					Yii::app()->cache->set('transferSmsShot'.$confs[0]->transfer_id.Yii::app()->user->id, ++$smsshot, 3600);
					echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'Code is incorrect. Your code is: '.$confs[0]->confirm_code)));
					Yii::app()->end();
				} else{
					foreach($confs as $conf) {
						if ($conf->confirm_code == (int)$_POST['Form_Smsconfirm']['code']) {
							$conf->transfer->need_confirm = 0;
                            if($conf->transfer->save()){
                                $tm = Transfers_Model::model($conf->transfer->form_type);
                                $tm->createOutgoingTransaction($conf->transfer);
                                if ($conf->transfer->favorite) {
                                    $favorite = new Transfers_Outgoing_Favorite();
                                    $favorite->attributes = $conf->transfer->attributes;
                                    $favorite->save();
                                }
                                if ($conf->transfer->frequency_type == 2) {
                                    $standing = new Transfers_Outgoing_Standing;
                                    $standing->attributes = $conf->transfer->attributes;
                                    $conf->transfer->frequency_type = 1;
                                    $conf->transfer->save();
                                    $standing->save();
                                }
                                $conf->delete();
                            }
						}
					}
					echo CJSON::encode(array('success' => true, 'url' => $this->createUrl('/transfers/success')));
					Yii::app()->end();
				}
				if (!$smsshot) {
					$smsshot = 1;
				} else {
					$smsshot++;
				}
			} else {
				throw new CHttpException(404, Yii::t('Front', 'Page not found'));
			}
		}
		
		$code = rand(1000, 9999);
		$user = Users::model()->findByPk(Yii::app()->user->id);
		if (Yii::app()->request->isAjaxRequest && Yii::app()->request->getParam('type') == 'all') {
			Transfers_Confirmation::model()->deleteAll('user_id = :uid', array(':uid' => Yii::app()->user->id));
			$transfers = Transfers_Outgoing::model()->findAll('user_id = :uid AND need_confirm = 1', array(':uid' => Yii::app()->user->id));
			foreach($transfers as $transfer) {
				$ntc = new Transfers_Confirmation;
				$ntc->group_id = substr(time()+$code, 5, 11);
				$ntc->transfer_id = $transfer->id;
				$ntc->user_id = Yii::app()->user->id;
				$ntc->confirm_code = $code;
				$ntc->active = 1;
				$ntc->save();
			}

			if (Yii::app()->sms->to($user->phone)->body('Confirmation code for transfer: {code}', array('{code}' => $code))->send() != 1) {
				Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
			}
			echo CJSON::encode(array('success' => true));
			Yii::app()->end();
		}
	
		$newConfirmations = Transfers_Confirmation::model()->findAll('user_id = :uid AND active = 0', array(':uid' => Yii::app()->user->id));
		if (count($newConfirmations)) {
			Transfers_Confirmation::model()->deleteAll('user_id = :uid AND active = 1', array(':uid' => Yii::app()->user->id));
			Transfers_Confirmation::model()->updateAll(array('confirm_code' => $code, 'active' => 1), 'user_id = :uid AND active = 0', array(':uid' => Yii::app()->user->id));
			if(Yii::app()->sms->to($user->phone)->body('Confirmation code for transfer: {code}', array('{code}' => $code))->send() != 1){
				Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
			}
		} else {
			$confirmations = Transfers_Confirmation::model()->findAll('user_id = :uid AND active = 1', array(':uid' => Yii::app()->user->id));
			if (empty($confirmations)) {
				throw new CHttpException(404, Yii::t('Front', 'Page not found'));
			}
		}
		$num = substr($user->phone, -3, 3);
		
		$confirmations = Transfers_Confirmation::model()->with('transfer')->findAll('t.user_id = :uid AND active = 1', array(':uid' => Yii::app()->user->id));
		
		$transes = array();

		foreach($confirmations as $tr) {
			if (!isset($transes[$tr->transfer->currency->code])) {
				$transes[$tr->transfer->currency->code] = array(
					'amount' => $tr->transfer->amount,
					'count' => 1,
				);
			} else {
				$transes[$tr->transfer->currency->code] = array(
					'amount' => $transes[$tr->transfer->currency->code]['amount'] + $tr->transfer->amount,
					'count' => $transes[$tr->transfer->currency->code]['count']+1,
				);
			} 
		}
		
		$this->render('smsconfirm', array(
			'model' => $form, 
			'num' => $num, 
			'confirmations' => $confirmations,
			'transes' => $transes,
		));
	}

    /**
     * @param $bic
     * @return JSON
     */
    public function actionGetBankName()
    {
        $bic = Yii::app()->request->getParam('bic', '', 'string');
        $model = Banks_Info::model()->find(
            array(
                'condition' => 'bic_code = :bic',
                'params' => array(':bic' => $bic),
                'select' => 'institution_name',
            )
        );
        if ($model) {
            echo CJSON::encode(array('success' => true, 'name' => $model->institution_name));
        } else {
            echo CJSON::encode(array('success' => false));
        }
    }
	
	public function actionResendSms()
    {
		$trans = Transfers_Confirmation::model()->with('transfer')->find('t.user_id = :uid AND active = 1', array(':uid' => Yii::app()->user->id));
		if ($trans) {
			$code = rand(1000, 9999);
			Transfers_Confirmation::model()->updateAll(array('confirm_code' => $code), 'user_id = :uid AND active = 1', array(':uid' => Yii::app()->user->id));
			$user = Users::model()->findByPk(Yii::app()->user->id);
			
			if (Yii::app()->sms->to($user->phone)->body('Confirmation code for transfer: {code}', array('{code}' => $code))->send() != 1) {
				Yii::log('SMS is not send', CLogger::LEVEL_ERROR);
			}
			echo CJSON::encode(array('success' => true));
		}
	}
	
	public function actionHistory()
    {
		$this->breadcrumbs[Yii::t('Front', 'Payments Overview')] = '';
		$time = time() - 3600 * 24 * 30;
		$transfers = Transfers_Outgoing::model()->findAll(array('condition' => 'user_id = :uid AND (created_at > ' . $time . ' OR status = 0)', 'params' => array(':uid' => Yii::app()->user->id), 'order' => 'created_at desc'));
		
		$this->render('history', array('transfers' => $transfers));
	}
	
	public function actionStanding()
    {
		$model = Transfers_Outgoing_Standing::model()->findAll(
			array(
				'condition' => 'user_id = :uid AND deleted = 0',
				'params' => array(':uid' => Yii::app()->user->id),
				'order' => 'created_at desc',
			)
		);

		$this->render('standing', array('model' => $model));
	}
	
	public function actionDeleteStanding($id)
    {
		$model = Transfers_Outgoing_Standing::model()->findByPk($id);
		
		$success = false;
		$message = false;
		
		if ($model->user_id = Yii::app()->user->id) {
			$model->deleted = 1;
			if ($model->save()) {
				$success = true;
				$message = Yii::t('Front', 'Standing transfer was successfully removed');
			}
		}
		
		echo CJSON::encode(array('success' => $success, 'message' => $message));
	}
	
	public function actionSuccessIncoming()
    {
		$this->breadcrumbs[Yii::t('Front', 'Upload money')] = array('/transfers/incoming');
		$this->breadcrumbs[Yii::t('Front', 'Success')] = '';
		
		$time = time() - 3600 * 24 * 5;
		$transfers = Transfers_Incoming::model()->findAll(array('condition' => 'user_id = :uid AND (created_at > ' . $time . ')', 'params' => array(':uid' => Yii::app()->user->id), 'order' => 'created_at desc'));
	
		$this->render('incoming/success', array('transfers' => $transfers));
	}
	
	public function actionIncomingOverview()
    {
		$this->breadcrumbs[Yii::t('Front', 'Incoming overview')] = '';
		
		$time = time() - 3600 * 24 * 5;
		$transfers = Transfers_Incoming::model()->findAll(array('condition' => 'user_id = :uid AND (created_at > ' . $time . ')', 'params' => array(':uid' => Yii::app()->user->id), 'order' => 'created_at desc'));
	
		$this->render('incoming/overview', array('transfers' => $transfers));
	}

    public function actionDuplicate($id){
        $type = Yii::request()->getParam('type', '', 'list', array('incoming', 'outgoing'));
        if($type == 'outgoing'){
            $transaction = Transfers_Outgoing::model()->currentUser()->findByPk($id);
            $newTransfer = new Transfers_Outgoing();
            $redirect = 'overview';
        } else {
            $transaction = Transfers_Incoming::model()->currentUser()->findByPk($id);
            $newTransfer = new Transfers_Incoming();
            $redirect = 'incomingoverview';
        }

        $newTransfer->user_id = $transaction->user_id;
        $newTransfer->created_at = time();
        $newTransfer->attributes = $transaction->attributes;
        if ($newTransfer->save()) {
            $this->redirect(array('/transfers/'.$redirect));
        }
        Yii::app()->end();
    }
}