<?php
class PaymentService
{
    const PENDING_STATUS = 0;
    const APPROVED_STATUS = 1;
    const REJECTED_STATUS = 2;

    /**
     * getHtmlStatus
     * 
     * @return string
     */
    public static function getHtmlStatus($status)
    {
        switch ($status) {
            case self::PENDING_STATUS:
                return '<span class="pending">'. Yii::t('Front', 'Pending') .'</span>';
                break;
            case self::APPROVED_STATUS:
                return '<span class="approved">'. Yii::t('Front', 'Approved') .'</span>';
                break;
            case self::REJECTED_STATUS:
                return '<span class="rejected">'. Yii::t('Front', 'Rejected') .'</span>';
                break;
        }
    }
}