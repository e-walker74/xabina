<?php

class AlertsHTMLHelper
{
    static $models = null;

    /**
     * @return array
     */
    public static function getAlertsChoices()
    {
        return CHtml::listData(self::getAlertsRequiredAccount(), 'code', 'name');
    }

    /**
     * @return array
     */
    public static function getAlertsOptions()
    {
        $result = array();
        foreach (self::getAlertsRequiredAccount() as $alert) {
            $result[$alert->code] = array('data-use-rules' => $alert->use_rules);
        }
        return $result;
    }

    /**
     * @return Alerts[]
     */
    private static function getAlertsRequiredAccount()
    {
        if(!self::$models)
            self::$models = Alerts::model()->withAccount()->findAll();
        return self::$models;
    }

} 