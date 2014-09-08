<?php

class TransfersController extends Controller
{

    public function actionList()
    {
        //$model = //Transfers_Outgoing::model()->findAll('status = 0 AND need_confirm = 0');
        $model = new Transactions('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Transactions'])) {
            $model->attributes = $_GET['Transactions'];
        }
//        $model->status = Transactions::STATUS_PENDING;
        $this->render('list', array('model' => $model));
    }

    public function actionOutgoing()
    {

        //$model = //Transfers_Outgoing::model()->findAll('status = 0 AND need_confirm = 0');
        $model = new Transfers_Outgoing('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Transfers_Outgoing'])) {
            $model->attributes = $_GET['Transfers_Outgoing'];
        }
        $this->render('outgoing', array('model' => $model));
    }

    public function actionIncoming()
    {

        //$model = //Transfers_Outgoing::model()->findAll('status = 0 AND need_confirm = 0');
        $model = new Transfers_Incoming('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Transfers_Incoming'])) {
            $model->attributes = $_GET['Transfers_Incoming'];
        }
        $this->render('incoming', array('model' => $model));
    }

    public function actionUpdateInc($id)
    {
        $model = Transfers_Incoming::model()->findByPk($id);
        $info = new Transactions_Info();
        $this->render('incoming/update', array('model' => $model, 'info' => $info));
    }

    public function actionUpdate($id)
    {
        $model = Transfers_Outgoing::model()->findByPk($id);
        $info = new Transactions_Info();
        $this->render('update', array('model' => $model, 'info' => $info));
    }

    public function actionAuthorise($id)
    {
        $model = Transfers_Outgoing::model()->findByPk($id);
        $model->scenario = 'admin';

        if (Yii::request()->getParam('ajax')) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Transfers_Outgoing']) && $model->status == Transfers_Outgoing::STATUS_PENDING && !$model->need_confirm) {
            if (!$model->account->checkBalance($model->amount, $model->account->currency_id)) {
                die('Not enough money!');
            }

            $model->attributes = $_POST['Transfers_Outgoing'];

            $return = false;
            if($model->status == Transfers_Outgoing::STATUS_APPROVED){
                $admin_transfer = Admin_Transfers::model($model->form_type);
                $return = $admin_transfer->approveOutgoingTransaction($model);
            } elseif($model->status == Transfers_Outgoing::STATUS_REJECTED){
                $admin_transfer = Admin_Transfers::model($model->form_type);
                $return = $admin_transfer->rejectTransaction($model);
            }
        }

        $this->redirect(array('/admin/transfers/outgoing'));
        Yii::app()->end();
    }

    public function actionAuthoriseInc($id)
    {

        $model = Transfers_Incoming::model()->findByPk($id);
        $model->scenario = 'admin';

        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'transfer-form') {
            echo CActiveForm::validate($model);
        }

        if (isset($_POST['Transfers_Incoming']) && $model->status == Transfers_Incoming::STATUS_PENDING) {

            $model->attributes = $_POST['Transfers_Incoming'];

            $return = false;
            if($model->status == Transfers_Incoming::STATUS_APPROVED){
                $admin_transfer = Admin_Transfers::model($model->form_type);
                $return = $admin_transfer->approveIncomingTransaction($model);
            } elseif($model->status == Transfers_Incoming::STATUS_REJECTED){
                $admin_transfer = Admin_Transfers::model($model->form_type);
                $return = $admin_transfer->rejectTransaction($model);
            }

            dd($return);
            die;
        }

        $this->redirect(array('/admin/transfers/incoming'));
        Yii::app()->end();
    }

    public function actionCreate()
    {

        $model = new Transactions('admin');
        $info = new Transactions_Info('admin');

        if (Yii::app()->getRequest()->isAjaxRequest && Yii::app()->getRequest()->getParam('ajax') == 'transfer-form') {
            $validate = CActiveForm::validate($model);
            $validateInfo = CActiveForm::validate($info);
            if ($validate != '[]') {
                echo $validate;
            } elseif ($validateInfo != '[]') {
                echo $validateInfo;
            } else {
                echo '[]';
            }
            Yii::app()->end();
        }

        if (isset($_POST['Transactions'])) {
            $toAcc = Accounts::model()->find('number = :num', array(':num' => $_POST['Transactions']['account_number']));
            $model->attributes = $_POST['Transactions'];
            $info->attributes = $_POST['Transactions_Info'];
            if ($model->type == 'positive') {
                $model->acc_balance = $toAcc->balance + $model->sum;
            } else {
                $model->acc_balance = $toAcc->balance - $model->sum;
            }
            $toAcc->balance = $model->acc_balance;
            $model->account_id = $toAcc->id;

            //$info->transaction_id = $model->id;
            $info->date = date('m.d.Y', time());
            $info->value = $model->sum . ' ' . $toAcc->currency->code;

            if ($model->validate() && $info->validate()) {
                $transaction = Yii::app()->db->beginTransaction();
                $ret = false;
                if ($model->save()) {
                    $info->transaction_id = $model->id;
                    if ($info->save() && $toAcc->save()) {
                        $transaction->commit();
                    } else {
                        $ret = true;
                    }
                } else {
                    $ret = true;
                }
                if ($ret) {
                    $transaction->rollback();
                }

                $this->redirect(array('/admin/accounts/index/'));
            } else {
                dd($model->getErrors());
                dd($info->getErrors());
                die;
            }
        }

        $this->render('create', array('model' => $model, 'info' => $info));
    }

}
