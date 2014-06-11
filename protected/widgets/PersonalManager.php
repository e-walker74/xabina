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
                $manager = null;
            }
        }

        $this->render('personal_manager/html', array('manager' => $manager));
    }
}