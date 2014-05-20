<?php   

class RbacFilter extends CFilter 
{
    protected function preFilter($filterChain)
    {
        // logic being applied before the action is executed

        $ca = ucwords($filterChain->controller->getId()).'.'.$filterChain->action->getId();

        return true; // false if the action should not be executed
    }
 
    protected function postFilter($filterChain)
    {
        // logic being applied after the action is executed
    }

}