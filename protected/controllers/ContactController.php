<?php

class ContactController extends Controller
{

    public $layout = 'banking';
    public $title = '';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function init()
    {
        Yii::import("application.ext.contactsList.*");
        Yii::app()->clientScript->registerScriptFile('/js/contacts.js');
        return parent::init();
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
                    'search',
                    'searchholders',
                    'searchtransfers',
                    'update',
                    'view',
                    'analytics',
                    'create',
                    'delete',
                    'DeleteData',
                    'makePrimary',
                    'category',
                    'deleteCategory',
                    'unlinkContact',
                    'addToCategory',
                    'addDataCategory',
                    'unlinkContrAgent',
                    'pdf',
                    'searchLink',
                ),
                'roles' => array('client')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

    public function actionIndex()
    {
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My contact'))] = '';
        $contact_categories = Users_Contacts_Categories::model()->currentUser()->findAll();
        $this->render('index', array('contact_categories' => $contact_categories));
    }

    public function actionSearch()
    {
        $html = Widget::create('ContactListWidget', 'ContactListWidget')->renderContactList(true);
        echo CJSON::encode(array('success' => true, 'html' => $html));
        Yii::app()->end();
    }

    public function actionSearchHolders()
    {
        if (Yii::app()->request->getParam('qAccountNumber')
            && Yii::app()->request->getParam('qAccountEType')
        ) {
            $transfers = Transfers_Outgoing::model()->with('currency')->currentUser()->findAll(
                array(
                    'condition' => 'to_account_number = :account AND status = 1 AND ewallet_type = :ewallet_type',
                    'params' => array(
                        ':account' => Yii::app()->request->getParam('qAccountNumber'),
                        ':ewallet_type' => Yii::app()->request->getParam('qAccountEType'),
                    ),
                    'order' => 'execution_date desc',
                )
            );
            echo CJSON::encode(Widget::create('ContactListWidget', 'ContactListWidget', array())->renderTransfersByAccount($transfers, true));
            Yii::app()->end();
        }
        echo CJSON::encode(Widget::create('ContactListWidget', 'ContactListWidget', array('type' => 'searchHolders'))->renderSearchHolders(true));
        Yii::app()->end();
    }

    public function actionSearchTransfers()
    {
        echo CJSON::encode(Widget::create('ContactListWidget', 'ContactListWidget', array('type' => 'searchtransfers'))->renderSearchTransfers(true));
        Yii::app()->end();
    }

    public function actionAnalytics($id)
    {
        $search = new Form_Contact_Analytics;

        $search->from_date = time() - 3600 * 24 * 30;
        $search->to_date = time();
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'analytics-form') {
            $search->attributes = $_POST['Form_Contact_Analytics'];
            $search->contact_id = $id;
            echo CActiveForm::validate($search, NULL, false);
            Yii::app()->end();
        }
        if (isset($_POST['Form_Contact_Analytics'])) {
            $search->attributes = $_POST['Form_Contact_Analytics'];
            $search->contact_id = $id;
            echo CJSON::encode(array('success' => true, 'html' => $this->renderPartial('_analytics/table', array('search' => $search), true, true)));
        }
        Yii::app()->end();

    }

    public function actionView($url)
    {

        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My contact'))] = array('/contact/index');

        $model = Users_Contacts::model()->currentUser()->with('data')->findByAttributes(array('url' => $url));

        if (!$model) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $id = $model->id;

        $this->breadcrumbs[$model->fullname] = '';

        $search = new Form_Contact_Analytics;

        $search->from_date = time() - 3600 * 24 * 30;
        $search->to_date = time();
        $search->contact_id = $id;

        $contact_categories = Users_Contacts_Categories::model()->currentUser()->findAll();

        $link = new Users_Contacts_Categories_Links();

        $criteria = new CDbCriteria();
        $data_categories = Users_Contacts_Data_Categories::model()->findAll(
            array(
                'condition' => '(user_id is null OR user_id = :uid) AND (language = :lang OR language is null)',
                'params' => array(':uid' => Yii::user()->id, ':lang' => Yii::app()->language),
            )
        );


        $searchLink = new Form_Search();
        $searchLink->counter_agent = $model->id;
        $searchLink->user_id = Yii::user()->getCurrentId();
        $transaction = $searchLink->contactLinkedTransactions();

        $this->render('view',
            array(
                'model' => $model,
                'search' => $search,
                'contact_categories' => $contact_categories,
                'link' => $link,
                'data_categories' => $data_categories,
                'searchLink' => $searchLink,
                'transaction' => $transaction,
            )
        );
    }

    public function actionCreate()
    {
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My contact'))] = array('/contact/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Add new contact'))] = '';

        $model = new Users_Contacts;

        if (isset($_POST['Users_Contacts']) && Yii::app()->request->getParam('ajax') === 'contact-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Users_Contacts'])) {
            $this->saveContact($model);
        }

        $this->render('create', array('model' => $model));
    }

    protected function saveContact($model)
    {
        $model->attributes = $_POST['Users_Contacts'];
        $model->user_id = Yii::app()->user->getCurrentId();
        if ($model->save()) {
            if (isset($_FILES['Users_Contacts']) && $_FILES['Users_Contacts']['tmp_name']['photo']) {
                $image = Yii::app()->image->load($_FILES['Users_Contacts']['tmp_name']['photo']);
                $image->resize(80, 80, Image::MAX)->crop(80, 80)->quality(75);
                $folder = Yii::app()->getBasePath(true) . '/../images/contacts/' . $model->user_id . '/' . $model->id . '/';
                $name = md5(time()) . '.' . $image->getImageExt();
                @mkdir($folder, 0775, 1);
                $image->save($folder . $name);
                $model->photo = $name;
                $model->save();
            }
            if ($model->delete == 1) {
                $model->photo = '';
                $model->save();
            }

            if(isset($_POST['update'])){
                echo CJSON::encode(
                    array(
                        'success' => true,
                        'html' => $this->renderPartial('update/_personal', array('model' => $model), true, true),
                    )
                );
                Yii::app()->end();
            }


        }
//        $this->renderPartial('update/_personal', array('model' => $model));
//        if(Yii::request()->isAjaxRequest){
//            echo CJSON::encode(
//                array(
//                    'success' => true,
//                    'html' => $this->renderPartial('update/_personal', array('model' => $model), true, true),
//                )
//            );
//            Yii::app()->end();
//        }
//        Yii::app()->session['flash_notify'] = array(
//            'title' => Yii::t('Front', 'Edit Contact'),
//            'message' => Yii::t('Front', 'Contact successfully saved'),
//        );


        $this->redirect(array('/contact/view', 'url' => $model->url));
    }

    public function actionUpdate($url)
    {
        $model = Users_Contacts::model()->currentUser()->with('data')->findByAttributes(array('url' => $url));

        if (!$model) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My contact'))] = array('/contact/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', $model->fullname))] = array('/contact/view', 'url' => $model->url);
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Edit'))] = '';

        $id = $model->id;
        if (Yii::app()->request->getParam('ajax') == 'contact-form' && isset($_POST['Users_Contacts'])) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Users_Contacts'])) {
            $this->saveContact($model);
        }

        if (count($_POST) && Yii::app()->request->isAjaxRequest && Yii::app()->request->getParam('ajax')) {
            echo Users_Contacts_Data::validateData();
            Yii::app()->end();
        }

        if (count($_POST) && Yii::app()->request->isAjaxRequest) {
            $this->cleanResponseJs();
            echo Users_Contacts_Data::model()->saveData($id);
            Yii::app()->end();
        }
//        $this->forward('/contact/view');
//		$this->render('update', array('model' => $model));
    }

    public function actionDelete($id)
    {
        Users_Contacts::model()->currentUser()->deleteByPk($id);
        $this->redirect(array('/contact/index'));
    }

    public function actionDeleteData($id)
    {
        $type = Yii::app()->request->getParam('type', '', 'list', array(
            'instmessaging',
            'contact',
            'account',
            'email',
            'phone',
            'address',
            'default',
            'social',
            'urls',
            'dates',
            'others',
        ));
        $model = Users_Contacts_Data::model()->with('contact')->findByAttributes(
            array(
                'id' => $id,
                'data_type' => $type,
            )
        );
        if (!$type || !$id || !$model || $model->contact->user_id != Yii::app()->user->getCurrentId()) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        echo CJSON::encode(array('success' => $model->delete(), 'mesTitle' => Yii::t('Front', 'Contact'), 'message' => Yii::t('Front', 'Entity was deleted')));
    }

    public function actionMakePrimary($entity, $id)
    {
        if (!Yii::request()->isAjaxRequest) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        $model = Users_Contacts_Data::model()->with('contact')->findByAttributes(array(
            'id' => $id,
            'data_type' => $entity,
        ));

        if (!$model || $model->contact->user_id != Yii::app()->user->id) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $model->is_primary = 1;

        Users_Contacts_Data::model()->updateAll(
            array('is_primary' => 0),
            'contact_id = :contact_id AND data_type = :data_type',
            array(
                ':contact_id' => $model->contact_id,
                ':data_type' => $entity,
            ));

        $model->save();

        echo Users_Contacts_Data::model()->renderContactData($model->contact_id, $model->data_type);
        Yii::app()->end();
    }

    public function actionCategory()
    {
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'My contact'))] = array('/contact/index');
        $this->breadcrumbs[Yii::t('Front', Yii::t('Front', 'Category'))] = '';

        $model = new Users_Contacts_Categories();

        if (Yii::request()->getParam('id', '', 'int')) {
            $model = Users_Contacts_Categories::model()->currentUser()->findByPk(Yii::request()->getParam('id', '', 'int'));
        }

        if (Yii::app()->request->getParam('ajax')) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if (isset($_POST['Users_Contacts_Categories'])) {
            $model->attributes = $_POST['Users_Contacts_Categories'];
            $model->user_id = Yii::app()->user->id;
            if ($model->save()) {
                $categories = Users_Contacts_Categories::model()->with('contacts')->currentUser()->findAll();
                $model = new Users_Contacts_Categories();
                echo CJSON::encode(array(
                    'success' => true,
                    'message' => Yii::t('Front', 'Category was successfully added'),
                    'html' => $this->renderPartial('category', array('model' => $model, 'categories' => $categories), true, true),
                ));
                Yii::app()->end();
            }
        }

        $categories = Users_Contacts_Categories::model()->with('contacts')->currentUser()->findAll();

        $this->render('category', array('model' => $model, 'categories' => $categories));
    }

    public function actionDeleteCategory($id)
    {
        $model = Users_Contacts_Categories::model()->currentUser()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $model->delete();
        echo CJSON::encode(array('success' => true));
    }

    public function actionUnlinkContact()
    {
        $model = Users_Contacts_Categories_Links::model()->with('contact')->findByAttributes(
            array(
                'contact_id' => Yii::request()->getParam('contact', '', 'int'),
                'category_id' => Yii::request()->getParam('category', '', 'int'),
            )
        );
        if (!$model || $model->contact->user_id != Yii::user()->id) {
            if (!$model) {
                throw new CHttpException(404, Yii::t('Front', 'Page not found'));
            }
        }
        $model->delete();
        echo CJSON::encode(array('success' => true));
    }

    public function actionAddToCategory($id)
    {
        $model = Users_Contacts::model()->currentUser()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        if(isset($_POST['Users_Contacts_Categories_Links'])){
            $link = new Users_Contacts_Categories_Links();
            $link->attributes = $_POST['Users_Contacts_Categories_Links'];
            $link->contact_id = $id;
            $link->save();
        }

        $contact_categories = Users_Contacts_Categories::model()->currentUser()->findAll();

        $link = new Users_Contacts_Categories_Links();

        echo CJSON::encode(array(
            'success' => true,
            'message' => 'Successfully saved',
            'html' => $this->renderPartial('update/_category',
                    array(
                        'model' => $model,
                        'contact_categories' => $contact_categories,
                        'link' => $link,
                    ),
                    true,
                    true
                )
        ));
    }

    public function actionAddDataCategory(){
        $model = new Users_Contacts_Data_Categories();

        $type = Yii::request()->getParam('type', '', 'list', array_keys(Users_Contacts_Data::$typesMap));
        if(!$type){
            throw new CHttpException(404, Yii::t('Front','Page not found'));
        }
        if(isset($_POST['Data_Category'])){
            $model->value = $_POST['Data_Category'];
            $model->user_id = Yii::user()->id;
            $model->data_type = $type;
            $model->language = Yii::app()->language;
            if($model->save()){
                echo CJSON::encode(array('success' => true, 'id' => $model->id, 'message' => Yii::t('Front', 'Category successfully saved')));
            }
        }
    }

    public function actionUnlinkContrAgent($id){
        $type = Yii::request()->getParam('type', '', 'list', array('incoming', 'outgoing'));
        $contact_id = Yii::request()->getParam('contact_id', 'int');

        $model = Users_Contacts::model()->currentUser()->findByPk($contact_id);

        if($type == 'outgoing'){
            $transaction = Transfers_Outgoing::model()->currentUser()->findByPk($id);
        } else {
            $transaction = Transfers_Incoming::model()->currentUser()->findByPk($id);
        }

        if(!$model || !$transaction){
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $transaction->counter_agent = NULL;
        $transaction->save();
        echo CJSON::encode(array(
            'success' => true,
//            'html' => $this->renderPartial('_linked', array('model' => $model), true, true),
        ));
    }

    public function actionPdf($url){

        $model = Users_Contacts::model()->currentUser()->with('data')->findByAttributes(array('url' => $url));

        if (!$model) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $html = $this->renderPartial('_pdf', array('model' => $model), true, false);

        Yii::import('application.ext.mpdf.mpdf');
        $mpdf = new mpdf('utf-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10); /*задаем формат, отступы и.т.д.*/
        $mpdf->charset_in = 'utf-8'; /*не забываем про русский*/

        $stylesheet = file_get_contents(Yii::app()->getBaseUrl(true) . '/css/pdf/style.css'); /*подключаем css*/
        $mpdf->WriteHTML($stylesheet, 1);

        $mpdf->list_indent_first_level = 0;

        $mpdf->SetHtmlFooter('<div class="pdf-footer">
				<table class="footer-info">
					<tr>
						<td width="25%" class="left">Xabina</td>
						<td width="35%"></td>
						<td width="30%">' . date('d.m.Y H:i:s', time()) . '</td>
						<td width="10%" class="right">{PAGENO}/{nbpg}</td>
					</tr>
				</table>
			</div>');
        $mpdf->WriteHTML($html, 2); /*формируем pdf*/

        $mpdf->Output($model->fullname, 'I');

        TransactionsExportService::exportListPdf($html, $model, 'transactions.pdf');

        Yii::app()->end();
    }

    public function actionSearchLink($id){

        $model = Users_Contacts::model()->currentUser()->findByPk($id);

        if (!$model) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $searchLink = new Form_Search();
        if (isset($_POST['Form_Search']) && Yii::app()->request->isAjaxRequest) {

            $searchLink->attributes = $_POST['Form_Search'];
            $searchLink->user_id = Yii::user()->getCurrentId();
            $searchLink->counter_agent = $model->id;
            if(!$searchLink->validate()){
                echo CJSON::encode(array('success' => false));
                Yii::app()->end();
            }
            $transaction = $searchLink->contactLinkedTransactions();

            $html = $this->renderPartial('_linked', array('model' => $model, 'transaction' => $transaction), true, true);
            echo CJSON::encode(array('success' => true, 'html' => $html));
            Yii::app()->end();
        }
        $searchLink->counter_agent = $model->id;
        $searchLink->user_id = Yii::user()->getCurrentId();

        $transaction = $searchLink->contactLinkedTransactions();

        echo CJSON::encode(
            array(
                'success' => true,
                'html' => $this->renderPartial('_linked', array('model' => $model, 'transactions' => $transaction), true, true),
            )
        );
    }
}