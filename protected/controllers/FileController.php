<?php

class FileController extends Controller
{

    public $layout = '';
    public $title = '';

    public function filters()
    {
        return array(
//            'accessControl',
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
                'actions' => array(),
                'roles' => array('client')
            ),
            array('deny', // deny everybody else
                'users' => array('*')
            ),
        );
    }

    public function actionUpload($id)
    {

        if (Yii::app()->request->getParam('ajax')) {
            $file = new Users_Files;
            $file->description = Yii::app()->request->getParam('description');
            $file->user_id = Yii::app()->user->id;
            $file->name = 'validate';
            $file->ext = 'validate';
            $file->validate();
            echo CJSON::encode($file->getErrors());
            Yii::app()->end();
        }

        $countFilesInHour = Yii::app()->cache->get('uploaded_files_by_user_' . Yii::app()->user->id);
        if ($countFilesInHour > 20) {
            echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'Exceeded the limit of uploaded files')));
            Yii::app()->end();
        }
        Yii::app()->cache->set('uploaded_files_by_user_' . Yii::app()->user->id, ++$countFilesInHour, 3600);

        $typeClassName = Yii::app()->request->getParam('type', '', 'list', array_keys(Users_Files::$fileTypes));
        $typeSuffix = Yii::app()->request->getParam('typeSuffix', '');
        $type = $typeClassName . $typeSuffix;

        if (!$typeClassName) {
            echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'Error')));
            Yii::app()->end();
        }

        if (Users_Files::$fileTypes[$type]['count']) {
            $fileCount = Users_Files::model()->count('user_id = :uid AND form = :type AND deleted = 0', array(
                ':uid' => Yii::app()->user->id,
                ':type' => $type,
            ));
            if ($fileCount >= Users_Files::$fileTypes[$type]['count']) {
                echo CJSON::encode(
                    array(
                        'success' => false,
                        'message' => Yii::t('Front', 'You can upload :count files in this form',
                                array(':count' => Users_Files::$fileTypes[$type]['count'])
                            )
                    )
                );
                Yii::app()->end();
            }
        }

        $model = $typeClassName::model();

        if (Users_Files::$fileTypes[$type]['user_check']) {

            $model = $model->findByPk($id);

            if (isset($model->user_id)) {
                if ($model->user_id != Yii::app()->user->id) {
                    echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'Hmm... Something wrong! You a hacker?')));
                    Yii::app()->end();
                }
            } elseif (isset($model->account_id)) {
                if ($model->account->user_id != Yii::app()->user->id) {
                    echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'Hmm... Something wrong! You a hacker?')));
                    Yii::app()->end();
                }
            }
        }

        Yii::import("application.ext.EAjaxUpload.qqFileUploader");

        $folder = Yii::app()->getBasePath(true) . '/../documents/' . Yii::app()->user->id . '/'; // folder for uploaded files
        $allowedExtensions = Users_Files::$fileTypes[$type]['ext']; //array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = Users_Files::$fileTypes[$type]['fileSize']; // maximum file size in bytes
        $uploader = new UploadedFile($allowedExtensions, $sizeLimit);

        $oldUmask = umask();
        umask(0);
        $res = @mkdir($folder, 0777, 1);
        umask($oldUmask);
        $oldUmask = umask();

        $uploader->setFileName(mb_substr(md5(Yii::app()->user->name . time()), 5, 10));

        $result = $uploader->handleUpload($folder);

        if (isset($result['success']) && $result['success']) {

            $file = new Users_Files();
            $file->user_id = Yii::app()->user->id;
            $file->name = $result['filename'];
            $file->ext = $uploader->getFileExt();
            $file->form = $type;
            if (isset($model->id)) {
                $file->model_id = $model->id;
            }
            $file->description = Yii::app()->request->getParam('description');
            $file->user_file_name = $uploader->getUserFileName();
            if (!$file->save()) {
                echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'Error')));
                Yii::app()->end();
            }

            $html = Widget::create(
                'WidgetUpload', 'WidgetUpload',
                array('showDialog' => false, 'typeSuffix' => $typeSuffix)
            )->getFilesTable($model, Yii::app()->user->id, true);

            echo CJSON::encode(
                array(
                    'success' => true,
                    'message' => Yii::t('Front', 'File «:fileName.:ext» is successfully uploaded.',
                            array(':fileName' => $uploader->getUserFileName(), ':ext' => $uploader->getFileExt())),
                    'html' => $html,
                )
            );
            Yii::app()->end();
        } else {
            echo CJSON::encode(array('success' => false, 'message' => $result['error']));
            Yii::app()->end();
        }
    }

    public function actionDelete($id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $file = Users_Files::model()->findByPk((int)$id);
            if ($file->user_id == Yii::app()->user->id && !$file->deleted) {
                $file->deleted = 1;
                $file->save();
                echo CJSON::encode(array('success' => true));
            } else {
                echo CJSON::encode(array('success' => false));
            }
        } else {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
    }

    public function actionGet($id, $name)
    {
        $model = Users_Files::model()->currentUser()->findByPk($id);

        if (!$model) {
            throw new CHttpException(404, Yii::t('Admin', 'Page not found'));
        }
        $file = Yii::app()->getBasePath(true) . '/../documents/' . Yii::app()->user->id . '/' . $model->name;
        if (file_exists($file)) {
            // сбрасываем буфер вывода PHP, чтобы избежать переполнения памяти выделенной под скрипт
            // если этого не сделать файл будет читаться в память полностью!
            if (ob_get_level()) {
                ob_end_clean();
            }
            // заставляем браузер показать окно сохранения файла
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . $model->user_file_name . '.' . $model->ext);
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
        } else {
            throw new CHttpException(404, Yii::t('File', 'File not found'));
        }
    }

    public function actionEdit($id)
    {
        if (!Yii::app()->request->isAjaxRequest) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }
        $model = Users_Files::model()->find(
            'user_id = :user_id AND id = :id',
            array(
                ':user_id' => Yii::app()->user->id,
                ':id' => $id
            )
        );

        if (!$model) {
            echo CJSON::encode(array('success' => false));
            Yii::app()->end();
        }

        $model->description = Yii::app()->request->getParam('comment', '');
        if ($model->save()) {
            echo CJSON::encode(array('success' => true, 'comment' => $model->shortDescription));
            Yii::app()->end();
        } else {
            echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'Entry is to long')));
            Yii::app()->end();
        }
    }

    public function actionGetMinimize($id, $name)
    {
        $model = Users_Files::model()->find(
            'user_id = :user_id AND id = :id',
            array(
                ':user_id' => Yii::app()->user->id,
                ':id' => $id
            )
        );

        if (!$model) {
            throw new CHttpException(404, Yii::t('Admin', 'Page not found'));
        }
        $file = Yii::app()->getBasePath(true) . '/../documents/' . Yii::app()->user->id . '/' . $model->name;
        if (getimagesize($file)) {
            $image = Yii::app()->image->load($file);
            $image->resize(60, 40, Image::WIDTH)->crop(60, 40)->quality(75);
            $image->render(); // or $image->save('images/small.jpg');
            Yii::app()->end();
        } else {
            switch ($model->ext) {
                case'pdf':
                    $image = Yii::app()->image->load(Yii::app()->getBasePath(true) . '/../images/ACP_PDF 2_file_document.png');
                    break;
                case'doc':
                case'docx':
                    $image = Yii::app()->image->load(Yii::app()->getBasePath(true) . '/../images/Word_2013_Icon.PNG');
                    break;
                default:
                    $image = Yii::app()->image->load(Yii::app()->getBasePath(true) . '/../images/Word_2013_Icon.PNG');
            }

            $image->resize(60, 40, Image::AUTO)->quality(75);
            $image->render(); // or $image->save('images/small.jpg');
            Yii::app()->end();
        }
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

    public function actionValidate()
    {

    }

    public function actionAddMemo()
    {
        $entity = Yii::request()->getParam('entity', '');
        $memo_id = Yii::request()->getParam('memo_id', '', 'int');
        $entityId = Yii::request()->getParam('entity_id', '', 'int');
        $text = trim(Yii::request()->getParam('text', '', 'string'));
        $transaction_id = Yii::request()->getParam('transaction_id', '', 'int');
        $folder_id = Yii::request()->getParam('folder_id', '', 'int');

        $model = Users_Files::model()->currentUser()->find('document_type = "memo" AND id = :id', array(':id' => $memo_id));

        if (!$model) {
            $model = new Users_Files();
            $model->form = $entity;
            $model->model_id = $entityId;
            $model->user_id = Yii::user()->getCurrentId();
            $model->document = $entity;
            $model->parent_id = $folder_id;
            $model->document_type = 'memo';
        }
        $model->scenario = 'memo';
        $model->description = $text;
        $model->file_size = mb_strlen($model->description);

        if ($model->save()) {
            if (!$memo_id) {
                echo CJSON::encode(array(
                    'success' => true,
                    'message' => Yii::t('Drive', 'memo_was_successfully_added'),
                    'html' => Widget::get('WLinkDrive')->renderMemoGridInPopup($folder_id, true, $entity, $entityId),
                ));
            } elseif($transaction_id) {
                echo CJSON::encode(array(
                    'success' => true,
                    'message' => Yii::t('Drive', 'memo_was_successfully_updated'),
                    'html' => Widget::get('WLinkDrive')->renderTransactionMemo($transaction_id, true),
                ));
            } else {
                echo CJSON::encode(array(
                    'success' => true,
                    'message' => Yii::t('Drive', 'memo_was_successfully_updated'),
                ));
            }

        } else {
            echo CJSON::encode(array(
                'success' => false,
                'message' => Yii::t('Drive', 'memo_not_added'),
            ));
        }
    }

    public function actionLink()
    {
        $entity = Yii::request()->getParam('entity', '', 'list', array('transactions'));
        $entity_id = Yii::request()->getParam('entity_id', '', 'int');

        $folderId = Yii::request()->getParam('folder', 0, 'int');
        $folder = Users_Files::model()->currentUser()->findByAttributes(array(
            'id' => $folderId,
            'document_type' => 'folder',
        ));

        if (!$folder) {
            $dir = '';
        } else {
            $dir = $folder->getDirectories();
        }

        $listFiles = Yii::request()->getParam('files');

        foreach ($listFiles as $file) {
            try {
                $cross = new CrossLinks();
                $cross->entity_id = $entity_id;
                $cross->entity_name = $entity;
                $cross->link_table_id = $file;
                $cross->link_table_name = 'users_files';
                $cross->user_id = Yii::user()->getCurrentId();
                $cross->save();
            } catch (CException $e) {
//                echo CJSON::encode(
//                    array(
//                        'success' => false,
//                        'message' => Yii::t('Drive', 'this_file_was_not_added')
//                    )
//                );
//                Yii::app()->end();
            }
        }

        $html = Widget::create(
            'WLinkDrive', 'WLinkDrive',
            array()
        )->renderTransactionsFiles($cross->entity_id, true);

        echo CJSON::encode(array(
            'success' => true,
            'message' => Yii::t('Drive', 'files_was_added'),
            'html' => $html,
        ));
    }


    public function actionLinkMemo()
    {
        $entity = Yii::request()->getParam('entity', '', 'list', array('transactions'));
        $entity_id = Yii::request()->getParam('entity_id', '', 'int');

        $folderId = Yii::request()->getParam('folder', 0, 'int');
        $folder = Users_Files::model()->currentUser()->findByAttributes(array(
            'id' => $folderId,
            'document_type' => 'folder',
        ));

        if (!$folder) {
            $dir = '';
        } else {
            $dir = $folder->getDirectories();
        }

        $listFiles = Yii::request()->getParam('files');

        foreach ($listFiles as $file) {
            try {
                $cross = new CrossLinks();
                $cross->entity_id = $entity_id;
                $cross->entity_name = $entity;
                $cross->link_table_id = $file;
                $cross->link_table_name = 'users_files_memo';
                $cross->user_id = Yii::user()->getCurrentId();
                $cross->save();
            } catch (CException $e) {
//                echo CJSON::encode(
//                    array(
//                        'success' => false,
//                        'message' => Yii::t('Drive', 'this_file_was_not_added')
//                    )
//                );
//                Yii::app()->end();
            }
        }


        $html = Widget::create(
            'WLinkDrive', 'WLinkDrive',
            array()
        )->renderTransactionMemo($cross->entity_id, true);

        echo CJSON::encode(array(
            'success' => true,
            'message' => Yii::t('Drive', 'files_was_added'),
            'html' => $html,
        ));
    }

    public function actionUploadDrive()
    {
        if (!Yii::request()->isAjaxRequest) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        Yii::import("application.ext.EAjaxUpload.qqFileUploader");

        $folderId = Yii::request()->getParam('folder', 0, 'int');

        $folderObject = Users_Files::model()->currentUser()->findByAttributes(array(
            'id' => $folderId,
            'document_type' => 'folder',
        ));

        $type = 'drive';

        if (!$folderObject) {
            $dir = '';
        } else {
            $dir = $folderObject->getDirectories();
        }

        $folder = Yii::app()->getBasePath(true) . '/../documents/' . Yii::app()->user->id . '/' . $dir; // folder for uploaded files
        $allowedExtensions = Users_Files::$fileTypes['Transactions']['ext']; //array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 20 * 1024 * 1024; // maximum file size in bytes
        $uploader = new UploadedFile($allowedExtensions, $sizeLimit);

        $oldUmask = umask();
        umask(0);
        @mkdir($folder, 0777, 1);
        umask($oldUmask);
        umask();

        $uploader->setFileName(mb_substr(md5(Yii::app()->user->name . time()), 5, 10));

        $result = $uploader->handleUpload($folder);

        if (isset($result['success']) && $result['success']) {

            $file = new Users_Files();
            $file->user_id = Yii::app()->user->id;
            $file->name = $result['filename'];
            $file->ext = $uploader->getFileExt();
            $file->form = $type;
            $file->description = Yii::app()->request->getParam('description');
            $file->user_file_name = $uploader->getUserFileName();
            $file->file_size = $result['size'];
            if ($folderObject) {
                $file->parent_id = $folderObject->id;
            }
            if (!$file->save()) {
                echo CJSON::encode(array('success' => false, 'message' => Yii::t('Front', 'Error')));
                Yii::app()->end();
            }

            $html = Widget::create(
                'WLinkDrive', 'WLinkDrive',
                array()
            )->renderFilesGridInPopup($folderId, true);

            echo CJSON::encode(
                array(
                    'success' => true,
                    'message' => Yii::t('Front', 'File «:fileName.:ext» is successfully uploaded.',
                            array(':fileName' => $uploader->getUserFileName(), ':ext' => $uploader->getFileExt())),
                    'html' => $html,
                )
            );
            Yii::app()->end();
        } else {
            echo CJSON::encode(array('success' => false, 'message' => $result['error']));
            Yii::app()->end();
        }
    }

    public function actionCreateFolder()
    {
        $parentId = Yii::request()->getParam('parent', 0, 'int');
        $name = Yii::request()->getParam('name', '', 'string');
        $type = Yii::request()->getParam('type', '', 'string');

        $name = stripslashes($name);

        $parent = Users_Files::model()->currentUser()->findByPk($parentId);

        $folder = new Users_Files();
        $folder->scenario = 'folder';
        $folder->user_file_name = $name;
        $folder->name = $name;
        $folder->user_id = Yii::user()->getCurrentId();
        $folder->document_type = 'folder';
        if ($parent) {
            $folder->parent_id = $parent->id;
        }

        if ($folder->save()) {
            if($type == 'memo'){
                $html = Widget::create(
                    'WLinkDrive', 'WLinkDrive',
                    array()
                )->renderMemoGridInPopup($parentId, true);
            } else {
                $html = Widget::create(
                    'WLinkDrive', 'WLinkDrive',
                    array()
                )->renderFilesGridInPopup($parentId, true);
            }

            echo CJSON::encode(array(
                'success' => true,
                'html' => $html,
                'message' => Yii::t('Drive', 'folder_was_created'),
            ));
        }
    }

    public function actionOpenFolder()
    {
        $folderId = Yii::request()->getParam('folder', 0, 'int');
        $up = Yii::request()->getParam('up', 0, 'boolean');
        $type = Yii::request()->getParam('type', 'files', 'list', array('memo', 'files'));
        $entity = Yii::request()->getParam('entity', '');
        $entityId = Yii::request()->getParam('entity_id', '');

        $folder = Users_Files::model()->currentUser()->findByPk($folderId);
        if ($up) {
            if (!$folder->parent) {
                $folderId = 0;
            } else {
                $folderId = $folder->parent->id;
            }
        }

        if($type == 'memo'){
            $html = Widget::create(
                'WLinkDrive', 'WLinkDrive',
                array()
            )->renderMemoGridInPopup($folderId, true, $entity, $entityId);
        } else {
            $html = Widget::create(
                'WLinkDrive', 'WLinkDrive',
                array()
            )->renderFilesGridInPopup($folderId, true, $entity, $entityId);
        }

        echo CJSON::encode(array(
            'success' => true,
            'html' => $html,
            'folder' => $folderId,
        ));
    }
}