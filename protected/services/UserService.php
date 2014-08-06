<?php

class UserService {


    public static function getStatusImageUrl($status)
    {
        switch($status){
            case Users::USER_ACTIVITY_STATUS_ONLINE:
                return '/images/validation_status_ok.png';
                break;
            case Users::USER_ACTIVITY_STATUS_BUSY:
                return '/images/time_ico.png';
                break;
            case Users::USER_ACTIVITY_STATUS_OFFLINE:
                return '/images/validation_status_er.png';
                break;
        }
    }
}
