<?php
/**
 * Created by Evgeniy Kazak Studio
 * @author Evgeniy Kazak
 * @author http://evgeniykazak.com/
 * User: ekazak
 * Date: 09.09.14
 * Time: 18:17
 */

class CurrencyService {

    /**
     * @return Currencies[]
     */
    public static function getCurrenciesList()
    {
        $list = Yii::app()->cache->get('currencies_list');
        if (!$list || !is_array($list)) {
            $list = Currencies::model()->findAll();
            Yii::app()->cache->set('currencies_list', $list, 3600);
        }
        return $list;
    }

    public static function getConversionData()
    {
        $rates = Yii::app()->cache->get('currencies_rates_list');
        if (!$rates) {
            foreach (CurrencyService::getCurrenciesList() as $currency) {
                $rates[$currency->code] = array(
                    'title' => $currency->title,
                    'last_value' => $currency->last_value,
                    'last_update' => $currency->last_update,
                );
                foreach (CurrencyService::getCurrenciesList() as $curr) {
                    $rates[$currency->code]['rates'][$curr->code] = array(
                        'title' => $curr->title,
                        'rate' => $curr->last_value / $currency->last_value,
                    );
                }
            }
            Yii::app()->cache->set('currencies_rates_list', $rates, 3600);
        }
        return $rates;
    }

} 