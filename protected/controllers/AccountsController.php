<?php

class AccountsController extends Controller
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
                'actions' => array('index','cardbalance', 'transaction', 'uploadattachemnt','getattach','transactionsonpdf', 'getpdf'),
                'roles' => array('administrator')
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
		$accounts = Accounts::model();
		$accounts->user_id = Yii::app()->user->id;
		
		$transactions = Transactions::model();
		$transactions->user_id = Yii::app()->user->id;
		
		$this->render('index', array('accounts' => $accounts, 'transactions' => $transactions));
    }
	
	public function actionCardBalance(){
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
		
		if(Yii::app()->request->isAjaxRequest && $accountNumber = Yii::app()->request->getParam('account', false, 'int')){
			$html = $this->renderPartial('cardbalance/_table', array('selectedAcc' => $selectedAcc, 'transactions' => $selectedAcc->transactions), true, false);
			echo CJSON::encode(array('success' => true, 'html' => $html));
			Yii::app()->end();
		}
		
		$this->render('cardbalance', 
			array(
				'accounts' => $accounts, 
				'selectedAcc' => $selectedAcc, 
				'model' => $model,
			));
	}
	
	public function actionTransaction($id){
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
	
	public function actionTransactionsOnPdf(){
		$model = new Form_Search();
		if(isset($_GET['Form_Search'])){
			$model->attributes = $_GET['Form_Search'];
			$key = md5(serialize($model->attributes));
			$transactions = $model->searchUserTransactions();
			$user = Users::model()->findByPk(Yii::app()->user->id);
			$debit = 0;
			$credit = 0;
			foreach($transactions as $trans){
				if($trans->type == 'positive'){
					$credit = $credit + $trans->sum;
				}
				if($trans->type == 'negative'){
					$debit = $debit + $trans->sum;
				}
			}
			$html = $this->renderPartial('cardbalance/_pdf', array('transactions' => $transactions, 'model' => $model, 'user' => $user, 'debit' => $debit, 'credit' => $credit), true, false);
			Yii::import('application.ext.mpdf.mpdf');
			$mpdf = new mpdf('utf-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10); /*задаем формат, отступы и.т.д.*/
			$mpdf->charset_in = 'utf-8'; /*не забываем про русский*/

			$stylesheet = file_get_contents('http://xabina.com/css/pdf/style.css'); /*подключаем css*/
			$mpdf->WriteHTML($stylesheet, 1);
			
			$mpdf->list_indent_first_level = 0; 
			$start_date = date('d M Y', strtotime($model->from_date));
			$end_date = ($model->to_date) ? date('d M Y', strtotime($model->to_date)) : date('d M Y', time());

			$mpdf->SetHtmlFooter('<div class="pdf-footer">
				<table class="footer-info">
					<tr>
						<td width="25%" class="left">Xabina</td>
						<!--<td width="35%">' . $start_date . ' - ' . $end_date . '</td>-->
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
}