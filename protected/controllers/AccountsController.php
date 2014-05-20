<?php

class AccountsController extends Controller
{

    public $layout = 'banking';
    public $title  = '';

    public function filters()
    {
        return array(
            'accessControl',
            array(
                'application.components.RbacFilter'
            ),
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
					'index',
					'cardbalance',
					'transaction',
					'uploadattachemnt',
					'getattach',
					'transactionsonpdf', 
					'transactionsondoc',
					'transactionsoncsv',
					'getpdf',
					'addnotetotransaction',
					'deletenote',
					'updatecategory',
					'payments',
				),
                'roles' => array('client')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {

		$this->breadcrumbs[Yii::t('Front', 'Accounts')] = '';

		$accounts = Accounts::model();
		$accounts->user_id = Yii::app()->user->id;

		$transactions = Transactions::model();
		$transactions->user_id = Yii::app()->user->id;

		$this->render('index', array('accounts' => $accounts, 'transactions' => $transactions));
    }

	public function actionCardBalance(){

		$this->breadcrumbs[Yii::t('Front', 'Accounts')] = array('/accounts/index');
		$this->breadcrumbs[Yii::t('Front', 'Balance')] = '';

		$accounts = Accounts::model()->with('user')->findAll('user_id = :uid', array(':uid' => Yii::app()->user->id));
		if(empty($accounts)){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		$selectedAcc = false;
		if($accountNumber = Yii::app()->request->getParam('account', false, 'int')){
			$selectedAcc = Accounts::model()->find('user_id = :uid AND number = :number', array(':uid' => Yii::app()->user->id, ':number' => $accountNumber));
		} elseif(!$selectedAcc) {
			$selectedAcc = $accounts[0];
		}

		$model = new Form_Search();
		$model->from_date = date('m/d/Y', time()-3600*24*30);
		$model->account_number = $selectedAcc->number;
		if(isset($_GET['Form_Search']) && Yii::app()->request->isAjaxRequest){
			$model->attributes = $_GET['Form_Search'];
			$model->account_id = $selectedAcc->id;
			$transactions = $model->searchUserTransactions();
			$html = $this->renderPartial('cardbalance/_table', array('selectedAcc' => $selectedAcc, 'transactions' => $transactions), true, false);
			echo CJSON::encode(array('success' => true, 'html' => $html));
			Yii::app()->end();
		}

        $transactions = $model->searchUserTransactions();

		if(Yii::app()->request->isAjaxRequest && $accountNumber = Yii::app()->request->getParam('account', false, 'int')){
			$html = $this->renderPartial('cardbalance/_table', array('selectedAcc' => $selectedAcc, 'transactions' => $transactions), true, false);
			echo CJSON::encode(array('success' => true, 'html' => $html));
			Yii::app()->end();
		}

		$this->render('cardbalance', 
			array(
				'accounts' => $accounts, 
				'selectedAcc' => $selectedAcc,
                'transactions' => $transactions,
				'model' => $model,
			));
	}

	public function actionTransaction($id, $exportType=''){

		$this->breadcrumbs[Yii::t('Front', 'Accounts')] = array('/accounts/index');
		$this->breadcrumbs[Yii::t('Front', 'Balance')] = array('/accounts/cardBalance');
		$this->breadcrumbs[Yii::t('Front', 'Transaction details')] = '';

		$trans = Transactions::model()->with('account')->findByPk($id);
		
		if($trans->account->user_id != Yii::app()->user->id){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}		

		if(isset($_POST['Transactions_Info_Attachments'])){

			$file = Transactions_Info_Attachments::model();
			$file->attributes = $_POST['Transactions_Info_Attachments'];
			$file = Transactions_Info_Attachments::model()->find('name = :name AND user_id = :user_id', array(':name' => $file->name, ':user_id' => Yii::app()->user->id));
			if($file){
				$file->attributes = $_POST['Transactions_Info_Attachments'];
				$file->transaction_id = $trans->id;
				$file->save();
				echo CJSON::encode(array('success' => true));
				Yii::app()->end();
			} else {
				echo CJSON::encode(array('success' => false));
				Yii::app()->end();
			}
		}

        switch ($exportType) {
            case 'pdf':
                $html = $this->renderPartial('transaction/pdf', array('trans' => $trans, 'user'=>Users::model()->findByPk(Yii::app()->user->id)), true, false);
                Yii::import('application.ext.mpdf.mpdf');
                $mpdf = new mpdf('utf-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10); /*задаем формат, отступы и.т.д.*/
                $mpdf->charset_in = 'utf-8'; /*не забываем про русский*/

                $stylesheet = file_get_contents(Yii::app()->basePath.'/../css/pdf/style.css'); /*подключаем css*/
                $mpdf->WriteHTML($stylesheet, 1);

                $mpdf->list_indent_first_level = 0;

                $mpdf->SetHtmlFooter('<div class="pdf-footer">
                        <table class="footer-info">
                            <tr>
                                <td width="25%" class="left">Xabina</td>
                                <td width="30%">' . date('d.m.Y H:i:s', time()) . '</td>
                                <td width="10%" class="right">{PAGENO}/{nbpg}</td>
                            </tr>
                        </table>
                    </div>');
                $mpdf->WriteHTML($html, 2); /*формируем pdf*/

                //ob_start();
                $mpdf->Output('transaction_'.$id.'.pdf', 'I');
                Yii::app()->end();
                break;
            case 'csv':
                $filename = 'transaction_'.$id.'.csv';
                $handle = fopen('/tmp/'.$filename, 'w+');
                foreach ($trans->info->getPublicAttrs() as $label => $value) {
                    $line = array($label, $value);
                    fputcsv($handle, $line, ";", "\"");
                }
                rewind($handle);
                header('Content-Description: File Transfer');
                header('Content-Type: application/csv');
                header("Content-Disposition: attachment; filename=$filename");
                fpassthru($handle);
                unlink('/tmp/'.$filename);

				Yii::app()->end();
                break;
            case 'doc':
                $includePath = Yii::getPathOfAlias('application.vendor.phpWord');
                $tmplPath = Yii::getPathOfAlias('application.views.accounts.transaction');
                spl_autoload_unregister(array('YiiBaseEx', 'autoload'));
                require_once $includePath.'/PHPWord.php';

                $PHPWord = new PHPWord();

                spl_autoload_register(array('YiiBaseEx', 'autoload'));

                $document = $PHPWord->loadTemplate($tmplPath.'/transaction_template.docx');

                $this->fillHeaderDocTemplate($document, null, Users::model()->findByPk(Yii::app()->user->id));

                $document->setValue('headerText', Yii::t('Front', 'Indepland - Details overschrijving'));

                $detailTable = array(
                    'label' => array(),
                    'value' => array()
                );
                foreach($trans->info->getPublicAttrs() as $label => $value) {
                    $detailTable['label'][] = $label;
                    $detailTable['value'][] = $value;
                }
                $document->cloneRow('detailTable', $detailTable);

                // footer
                $document->setValue('nowDateVal', date('d.m.Y H:i:s'));

                $fileName = Yii::getPathOfAlias('application.runtime').'/transactions_'.md5(serialize($trans)).'.docx';
                $document->save($fileName);

                Yii::app()->request->sendFile("transaction{$trans->id}.docx", file_get_contents($fileName), 'application/octet-stream', true);
                break;
        }

		$model = new Transactions_Info_Attachments;

		$this->render('transaction', array('trans' => $trans, 'model' => $model));
	}

	public function actionUploadAttachemnt($id){
		Yii::import("application.ext.EAjaxUpload.qqFileUploader");
		$documentNum = Yii::app()->request->getParam('doc','int');

		$trans = Transactions::model()->findByPk($id);

		if(!$trans || $trans->account->user_id != Yii::app()->user->id){
			echo CJSON::encode(array('success' => false));
		}

		$folder=Yii::app()->getBasePath(true) . '/../documents/'.Yii::app()->user->id.'/attachments/'; // folder for uploaded files
		$allowedExtensions = array("jpg","jpeg","gif","png","pdf"); //array("jpg","jpeg","gif","exe","mov" and etc...
		$sizeLimit = 20 *1024 * 1024; // maximum file size in bytes
		$uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
		$oldUmask = umask ();
		umask ( 0 );
		$res = @mkdir ( $folder, 0777, 1);
		umask ( $oldUmask );
		$oldUmask = umask ();
		$uploader->setFileName(mb_substr(md5(Yii::app()->user->name . time()), 5, 10));
		$result = $uploader->handleUpload($folder);
		$return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

		$fileSize=filesize($folder.$result['filename']); //GETTING FILE SIZE
		$fileName=$result['filename']; //GETTING FILE NAME

		if($result['success'] == true){
			$attachemntFile = new Transactions_Info_Attachments;
			$attachemntFile->user_id = Yii::app()->user->id;
			$attachemntFile->user_file_name = $uploader->getUserFileName();
			$attachemntFile->file_type = 'attach';
			$attachemntFile->name = $result['filename'];
			$attachemntFile->ext = $uploader->getFileExt();
			$attachemntFile->save();
		}

		echo $return;// it's array
		Yii::app()->end();
	}

	public function actionGetAttach($name){
		$user_id = Yii::app()->user->id;
		$name = Yii::app()->request->getParam('name', 'str');
		$model = Transactions_Info_Attachments::model()->find('user_id = :user_id AND name = :name', array(':user_id' => $user_id, ':name' => $name));

		if(!$model){
			throw new CHttpException(404, Yii::t('Admin', 'Page not found'));
		}
		$file=Yii::app()->getBasePath(true) . '/../documents/'.$user_id.'/attachments/'.$model->name;
		if (file_exists($file)) {
			// сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
			// если этого не сделать файл будет читаться в память полностью!
			if (ob_get_level()) {
			  ob_end_clean();
			}
			// заставляем браузер показать окно сохранения файла
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename=' . basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			// читаем файл и отправляем его пользователю
			if ($fd = fopen($file, 'rb')) {
				while (!feof($fd)) {
					print fread($fd, 1024);
				}
				fclose($fd);
			}
			exit;
		}
	}

	public function actionTransactionsOnDoc(){
        $model = new Form_Search();
		if(isset($_GET['Form_Search'])){
			$model->attributes = $_GET['Form_Search'];
			$key = md5(serialize($model->attributes));
			$transactions = $model->searchUserTransactions();
			$user = Users::model()->findByPk(Yii::app()->user->id);
			$debit = 0;
			$credit = 0;
            $account = Accounts::model()->findByAttributes(array('number'=>$model->account_number));
            $transactionsTable = array(
                'date' => array(),
                'type' => array(),
                'detailsSender' => array(),
                'detailsExtra' => array(),
                'sumInc' => array(),
                'sumDec' => array(),
                'balance' => array(),
            );
			foreach($transactions as $trans){
                $transactionsTable['date'][] = date('d.m.Y', $trans->created_at);
                $transactionsTable['type'][] = $trans->info->type;
                $transactionsTable['detailsSender'][] = $trans->info->sender;
                $transactionsTable['detailsExtra'][] = $trans->info->details_of_payment;
                $transactionsTable['balance'][] = number_format($trans->acc_balance, 2, ".", " ");

				if($trans->type == 'positive'){
                    $transactionsTable['sumInc'][] = number_format($trans->sum, 2, ".", " ") . $trans->account->currency->code;
                    $transactionsTable['sumDec'][] = '';
					$credit = $credit + $trans->sum;
				} else if($trans->type == 'negative'){
                    $transactionsTable['sumDec'][] = '-' . number_format($trans->sum, 2, ".", " ") . $trans->account->currency->code;
                    $transactionsTable['sumInc'][] = '';
                    $debit = $debit + $trans->sum;
				}
			}

            $includePath = Yii::getPathOfAlias('application.vendor.phpWord');
            $tmplPath = Yii::getPathOfAlias('application.views.accounts.cardbalance');
            spl_autoload_unregister(array('YiiBaseEx', 'autoload'));
            require_once $includePath.'/PHPWord.php';

            $PHPWord = new PHPWord();

            spl_autoload_register(array('YiiBaseEx', 'autoload'));

            $document = $PHPWord->loadTemplate($tmplPath.'/cardbalance_template.docx');

            $this->fillHeaderDocTemplate($document, $model, $user);

            // headers for balance table
            $document->setValue('currency', Yii::t('Front', 'Currency'));
            $document->setValue('balanceStarting', Yii::t('Front', 'Balance at the starting date'));
            $document->setValue('balanceEnding', Yii::t('Front', 'Balance at the ending date'));
            $document->setValue('credit', Yii::t('Front', 'Credit turnover'));
            $document->setValue('debit', Yii::t('Front', 'Debit turnover'));
            // values for balance table
            $document->setValue('currencyVal', $account->currency->code);
            $balanceStart = count($transactions) ?
                reset($transactions)->acc_balance - reset($transactions)->sum :
                $account->transactions[0]->acc_balance;
            $balanceEnd = count($transactions) ?
                end($transactions)->acc_balance :
                $account->transactions[0]->acc_balance;
            $document->setValue('balanceStartingVal', number_format($balanceStart, 2, ".", " "));
            $document->setValue('balanceEndingVal', number_format($balanceEnd, 2, ".", " "));
            $document->setValue('creditVal', $credit);
            $document->setValue('debitVal', $debit);

            // headers for transactions table
            $document->setValue('date', Yii::t('Front', 'Date'));
            $document->setValue('type', Yii::t('Front', 'Type'));
            $document->setValue('details', Yii::t('Front', 'Details'));
            $document->setValue('sum', Yii::t('Front', 'Sum'));
            $document->setValue('balance', Yii::t('Front', 'Balance'));

            if(count($transactions) == 0) {
                $document->removeRow('transactionsTable');
                $document->setValue('noTransactions.val', Yii::t('Front', 'No transactions meet the filter criterias'));
            } else {
                $document->cloneRow('transactionsTable', $transactionsTable);
                $document->removeRow('noTransactions');
            }

            // footer
            $document->setValue('nowDateVal', date('d.m.Y H:i:s'));

            $fileName = Yii::getPathOfAlias('application.runtime').'/transactions_'.md5(serialize($model)).'.docx';
            $document->save($fileName);

            Yii::app()->request->sendFile('transactions.docx', file_get_contents($fileName), 'application/octet-stream', true);
        }
		Yii::app()->end();
    }

	public function actionTransactionsOnCsv(){
        $model = new Form_Search();
		if(isset($_GET['Form_Search'])){
			$model->attributes = $_GET['Form_Search'];
			$key = md5(serialize($model->attributes));
			$transactions = $model->searchUserTransactions();
            $header = array(
                'created_at'=>'Date',
                'type'=>'Type',
                'details'=>'Details',
                'sum'=>'Sum',
                'balance'=>'Balance',
            );
            $data = array();
            foreach($transactions as $trans) {
                $data[] = array(
                    'created_at' => date('d.m.Y', $trans->created_at),
                    'type' => $trans->info->type,
                    'details' => $trans->info->sender . ' ' . $trans->info->details_of_payment,
                    'sum' => number_format($trans->sum, 2, ".", " ") . ' ' . $trans->account->currency->code,
                    'balance' => number_format($trans->acc_balance, 2, ".", " "),
                );
            }
            $filename = 'transactions'.date('Y-m-d',strtotime($model->from_date)).'.csv';
            $handle = fopen('/tmp/'.$filename, 'w+');
            fputcsv($handle, array_values($header), ";", "\"");
            foreach ($data as $value) {
                $line = array();
                foreach ($header as $key => $title) {
                    $line[] = $value[$key];
                }
                fputcsv($handle, $line, ";", "\"");
            }
            rewind($handle);
			header('Content-Description: File Transfer');
			header('Content-Type: application/csv');
            header("Content-Disposition: attachment; filename=$filename");
            fpassthru($handle);
            unlink('/tmp/'.$filename);
        }
		Yii::app()->end();
    }

	public function actionTransactionsOnPdf(){
		$model = new Form_Search();
		if(isset($_GET['Form_Search'])){
			$model->attributes = $_GET['Form_Search'];
			$key = md5(serialize($model->attributes));
			$transactions = $model->searchUserTransactions();
			$user = Users::model()->findByPk(Yii::app()->user->id);
			$debit = 0;
			$credit = 0;
            $account = Accounts::model()->findByAttributes(array('number'=>$model->account_number));
			foreach($transactions as $trans){
				if($trans->type == 'positive'){
					$credit = $credit + $trans->sum;
				}
				if($trans->type == 'negative'){
					$debit = $debit + $trans->sum;
				}
			}
			$html = $this->renderPartial('cardbalance/_pdf', array('transactions' => $transactions, 'account' => $account, 'model' => $model, 'user' => $user, 'debit' => $debit, 'credit' => $credit), true, false);
			Yii::import('application.ext.mpdf.mpdf');
			$mpdf = new mpdf('utf-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10); /*задаем формат, отступы и.т.д.*/
			$mpdf->charset_in = 'utf-8'; /*не забываем про русский*/

			$stylesheet = file_get_contents(Yii::app()->getBaseUrl(true) . '/css/pdf/style.css'); /*подключаем css*/
			$mpdf->WriteHTML($stylesheet, 1);

			$mpdf->list_indent_first_level = 0; 
			$start_date = date('d M Y', strtotime($model->from_date));
			$end_date = ($model->to_date) ? date('d M Y', strtotime($model->to_date)) : date('d M Y', time());

			$mpdf->SetHtmlFooter('<div class="pdf-footer">
				<table class="footer-info">
					<tr>
						<td width="25%" class="left">Xabina</td>
						<td width="35%">' . $start_date . ' - ' . $end_date . '</td>
						<td width="30%">' . date('d.m.Y H:i:s', time()) . '</td>
						<td width="10%" class="right">{PAGENO}/{nbpg}</td>
					</tr>
				</table>
			</div>');
			$mpdf->WriteHTML($html, 2); /*формируем pdf*/

			//ob_start();
			$mpdf->Output('transactions.pdf', 'I');
			//$template = ob_get_contents();
			//ob_end_clean();
			//Yii::app()->cache->set('pdf_generator_'.$key.Yii::app()->user->id, $template, 3600*24);
			//$this->redirect(array('accounts/getpdf', 'md5' => $key));
		}
		Yii::app()->end();
	}

	public function actionGetPdf($md5){
		if(Yii::app()->cache->get('pdf_generator_'.$md5.Yii::app()->user->id)){
			header('Content-Description: File Transfer');
			header('Content-Type: application/pdf');
			echo Yii::app()->cache->get('pdf_generator_'.$md5.Yii::app()->user->id);
		}
	}

	public function actionAddNoteToTransaction($id){
		if(!Yii::app()->request->isAjaxRequest){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}

		$trans = Transactions::model()->with('account')->findByPk($id);
		if($trans->account->user_id != Yii::app()->user->id){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		if(isset($_POST['note-text'])){
			$notes = new Transactions_Notes;
			$notes->user_id = Yii::app()->user->id;
			$notes->text = $_POST['note-text'];
			$notes->transaction_id = $id;
			if($notes->save()){
				$html = $this->renderPartial('application.views.accounts._notes', array('trans' => $trans), true);
				echo CJSON::encode(array('success' => true, 'html' => $html));
			} else {
				echo CJSON::encode(array('success' => false));
			}
			Yii::app()->end();
		}
	}

	public function actionDeleteNote($id){
		if(!Yii::app()->request->isAjaxRequest){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		$note = Transactions_Notes::model()->findByPk($id);
		if($note->user_id != Yii::app()->user->id){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		$note->deleted = 1;
		$note->save();
		echo CJSON::encode(array('success' => true));
	}

	public function actionUpdateCategory($id){
		if(!Yii::app()->request->isAjaxRequest){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		$trans = Transactions::model()->with('account')->findByPk($id);
		if($trans->account->user_id != Yii::app()->user->id){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		$cat_id = Yii::app()->request->getParam('category', '0', 'int');
		if(!$cat_id){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		$cat = Transactions_Categories::model()->findByPk($cat_id);
		if($cat->user_id && $cat->user_id != Yii::app()->user_id){
			throw new CHttpException(404, Yii::t('Front', 'Page not found'));
		}
		Transactions_Categories_Links::model()->deleteAll('transaction_id = :id', array(':id' => $id));
		$link = new Transactions_Categories_Links;
		$link->transaction_id = $trans->id;
		$link->category_id = $cat->id;
		dd($link->save());
	}

    /**
     * @param PHPWord_Template $document
     * @param Form_Search $model
     * @param Users $user
     */
    private function fillHeaderDocTemplate(&$document, $model=null, $user=null)
    {
        if($model) {
            $periodVal =date('d M', strtotime($model->from_date)) .' - '.(($model->to_date) ? date('d M Y', strtotime($model->to_date)) : date('d M Y', time()));
            $document->setValue('periodVal', $periodVal);
        }

        // translate for info table
        $document->setValue('Account_Statement', Yii::t('Front', 'Account Statement'));
        $document->setValue('client', Yii::t('Front', 'Client').':');
        $document->setValue('address', Yii::t('Front', 'Address').':');
        $document->setValue('reg', Yii::t('Front', 'Reg #').':');
        $document->setValue('account_number_IBAN', Yii::t('Front', 'Account number IBAN').':');
        $document->setValue('periodFilter', Yii::t('Front', 'Period').':');
        $document->setValue('transactionsFilter', Yii::t('Front', 'Transactions').':');

        if($model) {
            $document->setValue('sumFilter', ($model->from_sum != '' || $model->to_sum != '') ? (Yii::t('Front', 'Sum').':') : '');
            $document->setValue('keywordFilter', ($model->keyword != '') ? (Yii::t('Front', 'Keyword').':') : '');
        }

        // values for info table
        if($user) {
            $document->setValue('clientVal', $user->fullname);
        }
        $document->setValue('addressVal', 'Square des Places 1, 1700 Fribourg, Switzerland');
        $document->setValue('regVal', '2546897');
        $document->setValue('IBANVal', '254897546212');

        if($model) {
            $document->setValue('transactionsVal', ($model->type ? Yii::t('Front', ucfirst($model->type)) : Yii::t('Front', 'All')));
            $document->setValue('sumVal', ($model->from_sum != '' || $model->to_sum != '') ?
                    (
                        (($model->from_sum != '') ? Yii::t('Front', 'from') .' '. $model->from_sum:'') .
                        (($model->to_sum != '') ? Yii::t('Front', 'to') .' '. $model->to_sum:'')
                    ) : '');
            $document->setValue('keywordVal', $model->keyword);
        }
    }
}