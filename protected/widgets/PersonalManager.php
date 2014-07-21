<?php
class PersonalManager extends QWidget {
	
    public function run()
    {
        $manager = Yii::app()->cache->get('managerWidget_'.Yii::app()->user->id);
        if (!$manager) {
            $model = new Users();
            $manager = $model->findByPk(Yii::app()->user->id)->personalManagers;
            if ( isset($manager[0]) ) {
                $manager = $manager[0];
                Yii::app()->cache->set('managerWidget_'.Yii::app()->user->id, $manager, 3600*24);
            } else {
                $defManagerModel = PersonalManagers::model()->find('is_default = 1');
                if ($defManagerModel) {
                    $usersPersonalManagers = new UsersPersonalManagers;
                    $usersPersonalManagers->user_id = Yii::app()->user->id;
                    $usersPersonalManagers->manager_id = $defManagerModel['id'];
                    $usersPersonalManagers->widget_state = 1;
                    $usersPersonalManagers->save();
                }

                $manager = $defManagerModel;
            }
        }

        $this->render('personal_manager/html', array('manager' => $manager));
    }
}