<?php

/**
 * VKontakteOAuthService class file.
 *
 * Register application: http://vk.com/editapp?act=create&site=1
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */
require_once dirname(dirname(__FILE__)) . '/services/VKontakteOAuthService.php';

/**
 * VKontakte provider class.
 * @package application.extensions.eauth.services
 */
class CustomVKontakteOAuthService extends VKontakteOAuthService
{

    protected $name        = 'vkontakte';
    protected $title       = 'VK.com';
    protected $type        = 'OAuth';
    protected $jsArguments = array('popup' => array('width'  => 585, 'height' => 350));
    protected $client_id       = '';
    protected $client_secret   = '';
    protected $scope           = 'friends';
    protected $providerOptions = array(
        'authorize'    => 'http://api.vk.com/oauth/authorize',
        'access_token' => 'https://api.vk.com/oauth/access_token',
    );
    protected $uid = null;

    protected function fetchAttributes()
    {
        $info = (array) $this->makeSignedRequest('https://api.vk.com/method/users.get.json', array(
			'query' => array(
				'uids'   => $this->uid,
//				'fields' => '', // uid, first_name and last_name is always available
				'fields' => 'nickname, sex, bdate, city, country, timezone, photo_big, screen_name',
			),
		));

        $info = $info['response'][0];
		
        $this->attributes['soc_id']    = $info->uid;
        $this->attributes['name']      = $info->first_name;
        $this->attributes['surname']   = $info->last_name;
        $this->attributes['login']     = ($info->screen_name) ? $info->screen_name : $info->first_name;
        $this->attributes['sex']       = ($info->sex == 1) ? 2 : 1;
        $this->attributes['avatar']    = $info->photo_big;
        $this->attributes['full_name'] = $info->first_name . ' ' . $info->last_name;
        $this->attributes['url']       = ($info->screen_name) ? 'vk.com/'.$info->screen_name : 'vk.com/id'.$info->uid;

        /* if (!empty($info->nickname))
          $this->attributes['username'] = $info->nickname;
          else
          $this->attributes['username'] = 'id'.$info->uid;

          $this->attributes['gender'] = $info->sex == 1 ? 'F' : 'M';

          $this->attributes['city'] = $info->city;
          $this->attributes['country'] = $info->country;

          $this->attributes['timezone'] = timezone_name_from_abbr('', $info->timezone*3600, date('I'));;

          $this->attributes['photo'] = $info->photo;
          $this->attributes['photo_medium'] = $info->photo_medium;
          $this->attributes['photo_big'] = $info->photo_big;
          $this->attributes['photo_rec'] = $info->photo_rec; */
    }

}