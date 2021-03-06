<?php
/**
 * FacebookOAuthService class file.
 *
 * Register application: https://developers.facebook.com/apps/
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
require_once dirname(dirname(__FILE__)).'/services/FacebookOAuthService.php';

/**
 * Facebook provider class.
 * @package application.extensions.eauth.services
 */
class CustomFacebookOAuthService extends FacebookOAuthService {

	protected function fetchAttributes() {
		$info = (object) $this->makeSignedRequest('https://graph.facebook.com/me');
		$this->attributes['soc_id'] = $info->id;
                if(isset($info->email)){
                    $this->attributes['email'] = $info->email;
                }
                $this->attributes['avatar'] = 'https://graph.facebook.com/' . $info->id . '/picture?type=large';
                $this->attributes['full_name'] = '';
                if(isset($info->first_name)){
                    $this->attributes['full_name'] = $info->first_name;
                    $this->attributes['name'] = $info->first_name;
                }
                if(isset($info->last_name)){
                    $this->attributes['full_name'] = $this->attributes['full_name'] . ' ' . $info->last_name;
                    $this->attributes['surname'] = $info->last_name;
                }
                if(isset($info->username)){
                    $this->attributes['login'] = $info->username;
                }
                if(isset($info->gender)){
                    $this->attributes['sex'] = ($info->gender == 'male') ? 1 : 2;
                }
                $this->attributes['url'] = substr($info->link, 12);;

	}
}
