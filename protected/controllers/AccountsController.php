<?php

class AccountsController extends Controller
{

    public $layout = 'banking';
    public $title = '';

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
                    'addcategory',
                    'opennewaccount',
                    'create',
                    'getnewaccountstypes',
                    'makeprimary',
                    'management',
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

        Yii::app()->clientScript->registerScriptFile('/js/accounts.js', CClientScript::POS_END);

        $this->breadcrumbs[Yii::t('Front', 'Accounts')] = '';

        $accounts = Accounts::model();
        $accounts->user_id = Yii::app()->user->id;

        $this->render('index', array('accounts' => $accounts));
    }

    public function actionCardBalance()
    {

        $this->breadcrumbs[Yii::t('Front', 'Accounts')] = array('/accounts/index');
        $this->breadcrumbs[Yii::t('Front', 'Balance')] = '';

        $accounts = Accounts::model()->with('user')->currentUser()->findAll();
        if (empty($accounts)) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        $selectedAcc = false;
        if ($accountNumber = Yii::app()->request->getParam('account', false, 'int')) {
            $selectedAcc = Accounts::model()->find('number = :number', array(':number' => $accountNumber));
            if (!$selectedAcc) {
                throw new CHttpException(404, Yii::t('Front', 'Page not found'));
            }
        } elseif (!$selectedAcc) {
            $selectedAcc = $accounts[0];
        }

        $model = new Form_Search();
        $model->from_date = date('d.m.Y', time() - 3600 * 24 * 30);
        $model->account_number = $selectedAcc->number;
        if (isset($_GET['Form_Search']) && Yii::app()->request->isAjaxRequest) {
            $model->attributes = $_GET['Form_Search'];
            $transactions = $model->searchUserTransactions();
            $html = $this->renderPartial('cardbalance/_table', array('selectedAcc' => $selectedAcc, 'transactions' => $transactions), true, false);
            echo CJSON::encode(array('success' => true, 'html' => $html));
            Yii::app()->end();
        }

        $transactions = $model->searchUserTransactions();

        if (Yii::app()->request->isAjaxRequest && $accountNumber = Yii::app()->request->getParam('account', false, 'int')) {
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

    public function actionTransaction($id, $exportType = '')
    {

        $this->breadcrumbs[Yii::t('Front', 'Accounts')] = array('/accounts/index');
        $this->breadcrumbs[Yii::t('Front', 'Balance')] = array('/accounts/cardbalance');
        $this->breadcrumbs[Yii::t('Front', 'Transaction details')] = '';

        $trans = Transactions::model()->with('account')->findByAttributes(array('url' => $id));

        if (!$trans) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        if ($trans->account->user_id != Yii::app()->user->id) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        switch ($exportType) {
            case 'pdf':
                $html = $this->renderPartial('transaction/pdf', array('trans' => $trans, 'user' => Users::model()->with('primary_address')->findByPk(Yii::app()->user->id)), true, false);

                TransactionsExportService::exportDetailPdf($html, 'transaction_' . $id . '.pdf');

                Yii::app()->end();
                break;
            case 'csv':
                $filename = 'transaction_' . $id . '.csv';
                $filePath = '/tmp/' . uniqid() . $filename;
                $handle = fopen($filePath, 'w+');
                foreach ($trans->transfer->getPublicAttrs() as $label => $value) {
                    $line = array($label, $value);
                    fputcsv($handle, $line, ";", "\"");
                }
                fclose($handle);
                Yii::app()->request->sendFile($filename, file_get_contents($filePath), 'application/csv', false);
                unlink($filePath);
                Yii::app()->end();
                break;
            case 'doc':
                $filename = TransactionsExportService::exportDetailDoc($trans);
                Yii::app()->request->sendFile("transaction_{$trans->id}.docx", file_get_contents($filename), 'application/octet-stream', true);
                unlink($filename);
                break;
        }

        $categories = Transactions_Categories::model()->findAll('user_id = :uid OR user_id = 0', array(':uid' => Yii::app()->user->id));

        $this->render('transaction', array('trans' => $trans, 'categories' => $categories));
    }

    public function actionUploadAttachemnt($id)
    {
        Yii::import("application.ext.EAjaxUpload.qqFileUploader");
        $documentNum = Yii::app()->request->getParam('doc', 'int');

        $trans = Transactions::model()->findByAttributes(array('url' => $id));

        if (!$trans || $trans->account->user_id != Yii::app()->user->id) {
            echo CJSON::encode(array('success' => false));
        }

        $folder = Yii::app()->getBasePath(true) . '/../documents/' . Yii::app()->user->id . '/attachments/'; // folder for uploaded files
        $allowedExtensions = array("jpg", "jpeg", "gif", "png", "pdf"); //array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 20 * 1024 * 1024; // maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $oldUmask = umask();
        umask(0);
        $res = @mkdir($folder, 0777, 1);
        umask($oldUmask);
        $oldUmask = umask();
        $uploader->setFileName(mb_substr(md5(Yii::app()->user->name . time()), 5, 10));
        $result = $uploader->handleUpload($folder);
        $return = htmlspecialchars(json_encode($result), ENT_NOQUOTES);

        $fileSize = filesize($folder . $result['filename']); //GETTING FILE SIZE
        $fileName = $result['filename']; //GETTING FILE NAME

        if ($result['success'] == true) {
            $attachemntFile = new Transactions_Info_Attachments;
            $attachemntFile->user_id = Yii::app()->user->id;
            $attachemntFile->user_file_name = $uploader->getUserFileName();
            $attachemntFile->file_type = 'attach';
            $attachemntFile->name = $result['filename'];
            $attachemntFile->ext = $uploader->getFileExt();
            $attachemntFile->save();
        }

        echo $return; // it's array
        Yii::app()->end();
    }

    public function actionGetAttach($name)
    {
        $user_id = Yii::app()->user->id;
        $name = Yii::app()->request->getParam('name', 'str');
        $model = Transactions_Info_Attachments::model()->find('user_id = :user_id AND name = :name', array(':user_id' => $user_id, ':name' => $name));

        if (!$model) {
            throw new CHttpException(404, Yii::t('Admin', 'Page not found'));
        }
        $file = Yii::app()->getBasePath(true) . '/../documents/' . $user_id . '/attachments/' . $model->name;
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

    public function actionTransactionsOnDoc()
    {
        $model = new Form_Search();
        if (isset($_GET['Form_Search'])) {
            $model->attributes = $_GET['Form_Search'];
            $key = md5(serialize($model->attributes));
            $account = Accounts::model()->findByAttributes(array('number' => $model->account_number));
            if (!$account || $account->user_id != Yii::app()->user->id) {
                throw new CHttpException(404, Yii::t('Front', 'Page not found'));
            }
            $transactions = $model->searchUserTransactions();

            $fileName = TransactionsExportService::exportListDoc($model, $account, $transactions);

            Yii::app()->request->sendFile('transactions.docx', file_get_contents($fileName), 'application/octet-stream', true);
            unlink($fileName);
        }
        Yii::app()->end();
    }

    public function actionTransactionsOnCsv()
    {
        $model = new Form_Search();
        if (isset($_GET['Form_Search'])) {
            $model->attributes = $_GET['Form_Search'];
            $key = md5(serialize($model->attributes));
            $account = Accounts::model()->findByAttributes(array('number' => $model->account_number));
            if (!$account || $account->user_id != Yii::app()->user->id) {
                throw new CHttpException(404, Yii::t('Front', 'Page not found'));
            }
            $transactions = $model->searchUserTransactions();
            $data = array();
            $header = array();
            foreach ($transactions as $trans) {
                $header = array_unique(array_merge(array_keys($trans->transfer->getPublicAttrs()), $header));
                $data[] = $trans->transfer->getPublicAttrs();
            }
            foreach ($data as &$line) {
                foreach ($header as $hline) {
                    if (!isset($line[$hline])) {
                        $line[$hline] = '';
                    }
                }
            }

            $filename = 'transactions_' . date('Y-m-d', strtotime($model->from_date)) . '.csv';

            $filePath = TransactionsExportService::writeTableToCsvFile($header, $data, $filename);

            Yii::app()->request->sendFile($filename, file_get_contents($filePath), 'application/csv', false);
            unlink($filePath);
        }
        Yii::app()->end();
    }

    public function actionTransactionsOnPdf()
    {
        $model = new Form_Search();
        if (isset($_GET['Form_Search'])) {
            $model->attributes = $_GET['Form_Search'];
            $key = md5(serialize($model->attributes));
            $account = Accounts::model()->findByAttributes(array('number' => $model->account_number));
            if (!$account || $account->user_id != Yii::app()->user->id) {
                throw new CHttpException(404, Yii::t('Front', 'Page not found'));
            }
            $user = Users::model()->findByPk(Yii::app()->user->id);
            $transactions = $model->searchUserTransactions();
            $debit = 0;
            $credit = 0;
            foreach ($transactions as $trans) {
                if ($trans->type == 'positive') {
                    $credit = $credit + $trans->sum;
                }
                if ($trans->type == 'negative') {
                    $debit = $debit + $trans->sum;
                }
            }
            $html = $this->renderPartial('cardbalance/_pdf', array('transactions' => $transactions, 'account' => $account, 'model' => $model, 'user' => $user, 'debit' => $debit, 'credit' => $credit), true, false);

            TransactionsExportService::exportListPdf($html, $model, 'transactions.pdf');

            //$template = ob_get_contents();
            //ob_end_clean();
            //Yii::app()->cache->set('pdf_generator_'.$key.Yii::app()->user->id, $template, 3600*24);
            //$this->redirect(array('accounts/getpdf', 'md5' => $key));
        }
        Yii::app()->end();
    }

    public function actionGetPdf($md5)
    {
        if (Yii::app()->cache->get('pdf_generator_' . $md5 . Yii::app()->user->id)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/pdf');
            echo Yii::app()->cache->get('pdf_generator_' . $md5 . Yii::app()->user->id);
        }
    }

    public function actionAddNoteToTransaction($id)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $trans = Transactions::model()->with('account')->findByPk($id);
        if ($trans->account->user_id != Yii::app()->user->id) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        if (isset($_POST['note-text'])) {
            $notes = new Transactions_Notes;
            $notes->user_id = Yii::app()->user->id;
            $notes->text = $_POST['note-text'];
            $notes->transaction_id = $id;
            if ($notes->save()) {
                $html = $this->renderPartial('application.views.accounts._notes', array('trans' => $trans), true);
                echo CJSON::encode(array('success' => true, 'html' => $html));
            } else {
                echo CJSON::encode(array('success' => false));
            }
            Yii::app()->end();
        }
    }

    public function actionDeleteNote($id)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        $note = Transactions_Notes::model()->findByPk($id);
        if ($note->user_id != Yii::app()->user->id) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        $note->deleted = 1;
        $note->save();
        echo CJSON::encode(array('success' => true));
    }

    public function actionUpdateCategory($id)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        $trans = Transactions::model()->with('account')->findByPk($id);
        if ($trans->account->user_id != Yii::app()->user->id) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        $cat_id = Yii::app()->request->getParam('category', '0', 'int');
        if (!$cat_id) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        $cat = Transactions_Categories::model()->findByPk($cat_id);
        if ($cat->user_id && $cat->user_id != Yii::app()->user->id) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        $trans->transfer->category_id = $cat->id;

        $response = array();

        if ($trans->transfer->save()) {
            $response['success'] = true;
        } else {
            $response['success'] = false;
            $response['error'] = $trans->transfer->errors;
        }
        echo json_encode($response);
        Yii::app()->end();
    }

    public function actionAddCategory()
    {
        if (Yii::app()->request->isAjaxRequest && isset($_POST['title'])) {
            $model = new Transactions_Categories;
            $model->title = $_POST['title'];
            $model->user_id = Yii::app()->user->id;

            $response = array();

            if ($model->save()) {
                $response['success'] = true;
                $response['message'] = Yii::t('Front', 'Your category successfully created!');
                $response['data'] = array('id' => $model->id, 'title' => $model->title);
            } else {
                $response['success'] = false;
                $response['message'] = $model->errors;
            }
            echo json_encode($response);
            Yii::app()->end();
        }
        throw new CHttpException(404, Yii::t('Front', 'Page not found'));
    }

    public function actionOpenNewAccount()
    {
        Yii::app()->clientScript->registerScriptFile('/js/create-new-account.js', CClientScript::POS_END);
        $model = new Accounts;;
        $model->user_id = Yii::app()->user->id;

        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'new-account-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (!empty($_POST['Accounts'])) {
            $model->attributes = $_POST['Accounts'];
            if ($model->validate() && $model->save()) {
                $aRes = array(
                    'success' => true,
                    'message' => Yii::t('Front', 'New account saved successful')
                );
                if (isset($_GET['next'])) {
                    $aRes['url'] = $this->createUrl('/accounts/opennewaccount');
                }
                echo CJSON::encode($aRes);
            } else {
                echo CJSON::encode(array(
                    'success' => false,
                    'message' => Yii::t('Front', 'Something is incorrect')
                ));
            }
            Yii::app()->end();
        }

        $this->render('open_new_account', array('model' => $model));
    }

    public function actionGetNewAccountsTypes()
    {
        if (isset($_GET['currencyId']) && $_GET['categoryId']) {
            $model = new AccountsTypes;
            $types = $model->findAll(array(
                'condition' => 'currency_id=:currency_id AND category_id=:category_id',
                'params' => array(':currency_id' => $_GET['currencyId'], ':category_id' => $_GET['categoryId']),
            ));

            $this->renderPartial('open_new_account/new_accounts_types', array('types' => $types));
        }
    }

    public function actionMakePrimary()
    {

        $id = Yii::request()->getParam('id', '', 'integer');
        $model = Accounts::model()->ownUser()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        Accounts::model()->ownUser()->updateAll(array('is_master' => 0));

        $model->is_master = 1;
        $model->save();

        $accounts = Accounts::model();
        $accounts->user_id = Yii::app()->user->id;

        echo CJSON::encode(array(
            'success' => true,
            'message' => Yii::t('Accounts', 'Master is changed'),
            'html' => $this->renderPartial('_accountsTable', array('accounts' => $accounts), true, false),
        ));
    }

    /**
     * Create new account
     */
    public function actionCreate()
    {
        Yii::app()->clientScript->registerScriptFile('/js/XForms.js');
        $model = new Accounts('create');

        if (Yii::request()->getParam('ajax')) {
            $model->user_id = Yii::user()->id;
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Accounts'])) {
            $model->attributes = $_POST['Accounts'];
            $model->user_id = Yii::user()->id;
            $model->save();
            $this->redirect(array('/accounts/management', 'url' => $model->number));
        }

        $names = Accounts_Names::model()->findAll(
            array(
                'condition' => '(user_id is NULL AND lang = :lang) OR (user_id = :uid)',
                'params' => array(
                    ':lang' => Yii::app()->language,
                    ':uid' => Yii::user()->getCurrentId(),
                )
            )
        );

        $currencies = Currencies::model()->findAll();

        $this->render('create', array('model' => $model, 'names' => $names, 'currencies' => $currencies));
    }

    public function actionManagement()
    {
        Yii::app()->clientScript->registerScriptFile('/js/accounts.js');
        Yii::app()->clientScript->registerScriptFile('/js/XForms.js');
        $accountID = Yii::request()->getParam('url', '', 'integer');

        if (!is_numeric($accountID)) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $model = Accounts::model()->ownUser()->findByAttributes(array(
            'number' => $accountID,
            'basic' => true,
        ));

        if(Yii::request()->getParam('ajax')){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['Accounts'])){
            $model->name = $_POST['Accounts']['name'];
            $model->save();
            $this->redirect(array('/accounts/management', 'url' => $model->number));
        }

        if (!$model) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $accounts = Accounts::model()->ownUser()->findAllByAttributes(array(
            'number' => $accountID,
        ));

        $this->render('management', array('model' => $model, 'accounts' => $accounts));
    }

}