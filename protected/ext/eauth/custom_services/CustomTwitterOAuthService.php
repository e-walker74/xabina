<?php
/**
 * TwitterOAuthService class file.
 *
 * Register application: https://dev.twitter.com/apps/new
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

require_once dirname(dirname(__FILE__)) . '/services/TwitterOAuthService.php';

/**
 * Twitter provider class.
 * @package application.extensions.eauth.services
 */
class CustomTwitterOAuthService extends TwitterOAuthService {

	protected $name = 'twitter';
	protected $title = 'Twitter';
	protected $type = 'OAuth';
	protected $jsArguments = array('popup' => array('width' => 900, 'height' => 550));

	protected $key = '';
	protected $secret = '';
	protected $providerOptions = array(
		'request' => 'https://api.twitter.com/oauth/request_token',
		'authorize' => 'https://api.twitter.com/oauth/authenticate', //https://api.twitter.com/oauth/authorize
		'access' => 'https://api.twitter.com/oauth/access_token',
	);

	protected function fetchAttributes() {
		$info = $this->makeSignedRequest('https://api.twitter.com/1.1/account/verify_credentials.json');
		
		$this->attributes['soc_id'] = $info->id;
		$this->attributes['full_name'] = $info->name;
		$this->attributes['login'] = $info->screen_name;
		$this->attributes['url'] = ($info->screen_name) ? 'twitter.com/'.$info->screen_name : 'http://twitter.com/account/redirect_by_id?id=' . $info->id_str;
        $this->attributes['avatar'] = $info->profile_image_url;

		/*$this->attributes['username'] = $info->screen_name;
		$this->attributes['language'] = $info->lang;
		$this->attributes['timezone'] = timezone_name_from_abbr('', $info->utc_offset, date('I'));
		$this->attributes['photo'] = $info->profile_image_url;*/
	}

	/**
	 * Authenticate the user.
	 *
	 * @return boolean whether user was successfuly authenticated.
	 */
	public function authenticate() {
		if (isset($_GET['denied'])) {
			$this->cancel();
		}

		return parent::authenticate();
	}

    public function getProviderName(){
        return $this->name;
    }
}