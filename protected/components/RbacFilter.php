<?php   

class RbacFilter extends CFilter 
{
    protected function preFilter($filterChain)
    {
        // logic being applied before the action is executed

        $executeAction = false; // false if the action should not be executed
        $ca = ucwords($filterChain->controller->getId()).'.'.ucwords($filterChain->action->getId());
        if(Yii::app()->user->checkRbacAccess($ca)) {
            Yii::app()->user->checkRbacAccess($ca);
            $executeAction = true; 
        } else {
            throw new CHttpException(403,   Yii::t('Front', 'RBAC: You are not authorized to perform this action.'));
        }

        return $executeAction;
    }
 
    protected function postFilter($filterChain)
    {
        // logic being applied after the action is executed
    }

}