<?php
class PersonalManager extends QWidget {
	
    public function run()
    {
        $manager = null;//Yii::app()->cache->get('managerWidget_'.Yii::app()->user->id);
        if (!$manager) {
            $model = new Users();
            $manager = $model->findByPk(Yii::app()->user->id)->personalManagers;
            if ( isset($manager[0]) ) {
                $manager = $manager[0];
                Yii::app()->cache->set('managerWidget_'.Yii::app()->user->id, $manager, 3600*24);
            } else {
                $defManagerModel = PersonalManagers::model()->findAll('is_default = 1');
                $usersPersonalManagers = new UsersPersonalManagers;
                $usersPersonalManagers->user_id = Yii::app()->user->id;
                $usersPersonalManagers->manager_id = $defManagerModel[0]['id'];
                $usersPersonalManagers->widget_state = 1;
                $usersPersonalManagers->save();

                $manager = $defManagerModel[0];
            }
        }

        $this->render('personal_manager/html', array('manager' => $manager));
    }
}