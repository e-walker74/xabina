<?php
class UrlManager extends CUrlManager
{
    public function createUrl($route, $params=array(), $ampersand='&')
    {
		$lang = false;
		if(isset($params['language'])){
			$lang = $params['language'];
			unset($params['language']);
		}
        $url = parent::createUrl($route, $params, $ampersand);
        return DMultilangHelper::addLangToUrl($url, $lang);
    }
}