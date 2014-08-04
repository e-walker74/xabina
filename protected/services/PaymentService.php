<?php
class PaymentService
{
    const PENDING_STATUS = 0;
    const APPROVED_STATUS = 1;
    const REJECTED_STATUS = 2;
    
    const METHOD_CREDITCARD = 1;
    const METHOD_IDEAL = 2;
    
    public static $methods = array(
        self::METHOD_CREDITCARD => 'creditcard',
        self::METHOD_IDEAL => 'ideal',
    );

    /**
     * getHtmlStatus
     *
     * @param $status
     * @return string
     */
    public static function getHtmlStatus($status)
    {
        switch ($status) {
            case self::PENDING_STATUS:

                return '<img src="/css/layout/account/img/statuses-ico-pen.png" alt=""/>';
                break;
            case self::APPROVED_STATUS:
                return '<img src="/css/layout/account/img/statuses-ico-ok.png" alt=""/>';
                break;
            case self::REJECTED_STATUS:
                return '<img src="/css/layout/account/img/statuses-ico-rej.png" alt=""/>';
                break;
        }
    }
}