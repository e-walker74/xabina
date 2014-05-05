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
			foreach($transactions as $trans){
				if($trans->type == 'positive'){
					$credit = $credit + $trans->sum;
				}
				if($trans->type == 'negative'){
					$debit = $debit + $trans->sum;
				}
			}

            $path = Yii::getPathOfAlias('application.vendor.phpWord');

            spl_autoload_unregister(array('YiiBaseEx','autoload'));
            require_once $path .'/PHPWord.php';

            // New Word Document
            $PHPWord = new PHPWord();

            // New portrait section
            $section = $PHPWord->createSection();

            // Add header
            $styleCell = array('valign'=>'center', 'borderBottomColor'=>'403186');
            $header = $section->createHeader();
            // Add table style
            $PHPWord->addTableStyle('headTableStyle', array('borderSize'=>6, 'borderColor'=>'FFFFFF'));
            $hTable = $header->addTable('headTableStyle');
            $hTable->addRow(57);
            $hTable->addCell(168, $styleCell)->addImage(Yii::app()->basePath.'/../images/logo.png', array('align'=>'left'));
            $cell = $hTable->addCell(2000, $styleCell);
            $cell->addText('Xabina/Stadsring 99');
            $cell->addText('3811 HP Amersfoort/The Netherlands');
            $cell->addText('Telephone: +31 880 200 200    Fax: +31 880 200 100');
            $cell->addText('Company Registration Number: 32168526');


            // Define table style arrays
//            $styleTable = array('borderSize'=>6, 'borderColor'=>'CCCDD2', 'cellMargin'=>80);
//            $styleFirstRow = array('bgColor'=>'BDBDC5');

            // Define cell style arrays
//            $styleCell = array('valign'=>'center');
//            $styleCellBTLR = array('valign'=>'center', 'borderTopColor'=>'CCCDD2', 'textDirection'=>PHPWord_Style_Cell::TEXT_DIR_BTLR);

            // Define font style for first row
//            $fontStyle = array('bold'=>true, 'align'=>'center');

            // Add table style
//            $PHPWord->addTableStyle('myOwnTableStyle', $styleTable, $styleFirstRow);

            // Add table
//            $table = $section->addTable('myOwnTableStyle');

            // Add row
//            $table->addRow();

            // Add cells
//            $table->addCell(2000, $styleCell)->addText('Row 1', $fontStyle);
//            $table->addCell(2000, $styleCell)->addText('Row 2', $fontStyle);
//            $table->addCell(2000, $styleCell)->addText('Row 3', $fontStyle);
//            $table->addCell(2000, $styleCell)->addText('Row 4', $fontStyle);
//            $table->addCell(500, $styleCellBTLR)->addText('Row 5', $fontStyle);

            // Add more rows / cells
//            for($i = 1; $i <= 10; $i++) {
//                $table->addRow();
//                $table->addCell(2000)->addText("Cell $i");
//                $table->addCell(2000)->addText("Cell $i");
//                $table->addCell(2000)->addText("Cell $i");
//                $table->addCell(2000)->addText("Cell $i");
//
//                $text = ($i % 2 == 0) ? 'X' : '';
//                $table->addCell(500)->addText($text);
//            }

            $footer = $section->createFooter();
            $footer->addPreserveText('Page {PAGE} of {NUMPAGES}.', array('align'=>'center'));

            // Save File
            $objWriter = PHPWord_IOFactory::createWriter($PHPWord, 'Word2007');
            $objWriter->save('test.doc');

            spl_autoload_unregister(array('YiiBaseEx','autoload'));

//            $html = $this->renderPartial('cardbalance/_doc', array('transactions' => $transactions, 'model' => $model, 'user' => $user, 'debit' => $debit, 'credit' => $credit), true, false);
            Yii::app()->request->sendFile('test.doc', file_get_contents('test.doc'), 'application/octet-stream', true);
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
}