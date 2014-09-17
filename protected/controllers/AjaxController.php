<?php

/**
 * Class AjaxController
 * For all common ajax requests
 */
class AjaxController extends Controller
{

    public $layout = '';
    public $title = '';

    /**
     *  Ajax request countries autocomleate action
     *
     */
    public function actionCountryAutoComplete()
    {

        if (isset($_GET['q'])) {

            $criteria = new CDbCriteria;
            $criteria->addSearchCondition('name', $_GET['q'] . '%', false);
            if (isset($_GET['limit']) && is_numeric($_GET['limit'])) {
                $criteria->limit = $_GET['limit'];
            }

            $countries = countries::model()->findAll($criteria);

            $resStr = '';
            foreach ($countries as $country) {
                $resStr .= $country->name . "\n";
            }
            echo $resStr;
        }
    }

    public function actionGetRoleRights($roleId)
    {
        $rights = RbacRoleAccessRights::model()->with('role')->findAll(
            array(
                'condition' => 't.role_id = :rid AND role.create_uid = :cuid',
                'params' => array(
                    ':rid' => Yii::app()->request->getParam('roleId', '', 'int'),
                    ':cuid' => Yii::app()->user->id,
                ),
            )
        );
        echo CJSON::encode($rights);
    }

    public function actionSetManagerWidgetState()
    {
        if (isset($_GET['state'])) {
            $model = new UsersPersonalManagers();
            $model->updateAll(array('widget_state' => $_GET['state']), 'user_id="' . Yii::app()->user->id . '"');
        }
    }

    public function actionGetManagerWidgetState()
    {
        $model = new UsersPersonalManagers();
        $ret = $model->find('user_id = ' . Yii::app()->user->id);
        echo $ret['widget_state'];
    }

    public function actionGetUserRights()
    {
        $addUserForm = new RbacAddUserForm();
        if (isset($_GET['RbacAddUserForm'])) {
            $addUserForm->attributes = $_GET['RbacAddUserForm'];
            if ($addUserForm->validate()) {

                $query = "SELECT
                t.*,
                account.number
                FROM `rbac_user_access_rights` `t`
                LEFT OUTER JOIN `users` `user` ON (`t`.`user_id`=`user`.`id`)
                LEFT OUTER JOIN `accounts` `account` ON (`t`.`account_id`=`account`.`id`)
                LEFT OUTER JOIN `rbac_roles` `role` ON (`t`.`role_id`=`role`.`id`)
                WHERE (
                t.role_id = {$addUserForm->role}
                AND role.create_uid = " . Yii::app()->user->id . "
                AND account.number = {$addUserForm->account}
                AND user.login = {$addUserForm->user}
                )";

                $command = Yii::app()->db->createCommand($query);
                echo CJSON::encode($command->queryAll());
                Yii::app()->end();
            }
        }
        echo CJSON::encode(array('success' => false));

    }

    /**
     * Set activity state in system.
     * user activity status (online = 1 | busy = 2 | offline = 0)
     *
     */
    public function actionSetUserActivityStatus()
    {
        Yii::app()->user->setActivityStatus(Yii::request()->getParam('status', 1, 'list', array(0, 1, 2)));
        $users = Users::model()->findByPk(Yii::app()->user->id);
        $users->activity_status = Yii::request()->getParam('status', 1, 'list', array(0, 1, 2));

        if ($users->save()) {
            echo CJSON::encode(array('success' => true));
        }
    }

	public function actionGetNotifications() {

		$model = new Users_NotificationsStatuses('search');
		$model->user_id = Yii::app()->user->id;
		$this->renderPartial('notifications',array(
			'model'=>$model,
		));
	}

	public function actionSetSeeNotifications() {

		$model = new Users_NotificationsStatuses('search');
		$model->user_id = Yii::app()->user->id;
		$items = $model->search()->getData();
		foreach($items as $item) {
			if($item->status != Users_NotificationsStatuses::STATUS_DONE && in_array($item->message->type, array(Users_Notifications::TYPE_PROMOTION, Users_Notifications::TYPE_INFORMATION ))){
				$item->status = Users_NotificationsStatuses::STATUS_SEE;
				$item->save();
			}
		}

		 echo CJSON::encode(array('success' => true));
	}

	public function actionSetReadNotification($id) {

		$model = Users_NotificationsStatuses::model()->findByAttributes(array('id' => $id, 'user_id' => Yii::app()->user->id));
		if ($model != null) {
			$model->status = Users_NotificationsStatuses::STATUS_SEE;
			$model->save();
		}

		 echo CJSON::encode(array('success' => true));
	}

    public function actionRemoveTag($id, $entity, $entity_id, $cross_type)
    {
        if (!Yii::request()->isAjaxRequest) {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $sql = "
            DELETE FROM cross_links
            where entity_name = :entity_type
            AND entity_id = :entity_id
            AND link_table_name = :link_table_name
            AND link_table_id = :tag_id
            AND user_id = :uid;
        ";

        Yii::app()->db->createCommand($sql)->execute(array(
            ':tag_id' => $id,
            ':entity_id' => $entity_id,
            ':entity_type' => $entity,
            ':uid' => Yii::user()->getCurrentId(),
            ':link_table_name' => $cross_type,
        ));

        echo CJSON::encode(array('success' => true, 'message' => Yii::t('Ajax', 'remove_success')));
    }

    public function actionAddtag($id, $entity)
    {
        $text = Yii::request()->getParam('text', '');

        $tag_id = Yii::request()->getParam('tag_id', '', 'int');

        if ($text) {
            foreach (explode(',', $text) as $tag) {
                $tag = trim($tag);
                if (!$tag) {
                    continue;
                }

                $utag = Users_Tags::model()->findByAttributes(array(
                    'user_id' => Yii::user()->getCurrentId(),
                    'title' => $tag,
                ));
                if (!$utag) {
                    $utag = new Users_Tags();
                    $utag->title = $tag;
                    $utag->user_id = Yii::user()->getCurrentId();
                    $utag->save();
                }

                try {
                    $cross = new CrossLinks();
                    $cross->entity_id = $id;
                    $cross->entity_name = $entity;
                    $cross->link_table_id = $utag->id;
                    $cross->link_table_name = $utag->tableName();
                    $cross->user_id = Yii::user()->getCurrentId();
                    $cross->save();
                } catch (CException $e) {
                    echo CJSON::encode(
                        array(
                            'success' => false,
                            'message' => Yii::t('Tags', '{tag}_tag_was_added', array('{tag}' => $utag->title))
                        )
                    );
                    Yii::app()->end();
                }
            }
        } elseif ($tag_id) {
            try {
                $cross = new CrossLinks();
                $cross->entity_id = $id;
                $cross->entity_name = $entity;
                $cross->link_table_id = $tag_id;
                $cross->link_table_name = 'users_tags';
                $cross->user_id = Yii::user()->getCurrentId();
                $cross->save();
            } catch (CException $e) {
                echo CJSON::encode(
                    array(
                        'success' => false,
                        'message' => Yii::t('Tags', 'this_tag_was_added')
                    )
                );
                Yii::app()->end();
            }
        }

        echo CJSON::encode(
            array(
                'success' => true,
                'message' => Yii::t('Tags', 'tag_was_added_successfully'),
                'entityTagsHtml' => Widget::get('UsersTagsWidget')->renderTransactionTags($id, true)
            )
        );
    }

    public function actionCrossCategory()
    {
        $cross_id = Yii::request()->getParam('cross_id', 0, 'int');
        $cross_category = Yii::request()->getParam('cross_category');

        if(!$cross_id){
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        if($cross_category && !is_numeric($cross_category)){
            $category = new Users_Categories();
            $category->user_id = Yii::user()->getCurrentId();
            $category->data_type = 'cross_links';
            $category->value = $cross_category;
            $category->save();
            $cross_category_id = $category->id;
        } elseif($cross_category) {
            $cross_category_id = $cross_category;
        } else {
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $cross = CrossLinks::model()->currentUser()->findByPk($cross_id);
        $cross->category_id = $cross_category_id;
        $cross->save();

        echo CJSON::encode(array('success' => true, 'message' => Yii::t('Cross', 'Category was saved')));
    }

    public function actionCrossComment()
    {
        $cross_id = Yii::request()->getParam('cross_id', 0, 'int');
        $cross_comment = Yii::request()->getParam('cross_comment');

        if(!$cross_id || !is_numeric($cross_id) || !$cross_comment){
            throw new CHttpException(404, Yii::t('Front', 'Page not found'));
        }

        $cross = CrossLinks::model()->currentUser()->findByPk($cross_id);
        $cross->comment = $cross_comment;
        $cross->save();

        echo CJSON::encode(array('success' => true, 'message' => Yii::t('Cross', 'Category was saved')));
    }
}