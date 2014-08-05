<?php

class QHttpRequest extends CHttpRequest
{
    const PARAM_TYPE_LIST = 'list';
    public $noCsrfValidationRoutes = array();
    private $_pathInfo;

    private $_requestUri;

    public function getUrl()
    {
        return $this->getOriginalUrl();
    }

    public function getOriginalUrl()
    {
        return $this->getOriginalRequestUri();
    }

    public function getOriginalRequestUri()
    {
        return DMultilangHelper::addLangToUrl($this->getRequestUri());
    }

    public function getRequestUri()
    {
        if ($this->_requestUri === null)
            $this->_requestUri = DMultilangHelper::processLangInUrl(parent::getRequestUri());

        return $this->_requestUri;
    }

    /**
     * @param string $Name
     * @param string $Default default value
     * @param null $type types int, str, double, float, checkbox
     * @param array  $list
     * @return float|int|mixed|null|string
     */
    public function getParam($Name, $Default = "", $type = null, $list = array())
    {

        $r = $Default;
        if (isset($_GET [$Name])) {
            $r = $_GET [$Name];
        } else if (isset($_POST [$Name])) {
            $r = $_POST [$Name];
        }
        if ($type == self::PARAM_TYPE_LIST) {
            $r = self::checkFromList($r, $Default, $list);
        } else {
            $r = self::toTypeConvert($r, $type, $list);
        }
        return $r;
    }

    private function checkFromList($value, $default, $list)
    {
        if (in_array($value, $list)) {
            return $value;
        }
        return $default;
    }

    private function toTypeConvert($value = null, $type = null)
    {
        switch ($type) {
            case 'int':
                if ($value >= 2147483647) {
                    $value = (double)$value;
                } else {
                    $value = intval($value);
                }
                break;
            case 'str':
                $value = strval($value);
                break;
            case 'double':
                $value = doubleval($value);
                break;
            case 'float':
                $value = floatval(str_replace(',', '.', $value));
                break;
            case 'checkbox':
                $value = ($value == 'on') ? 1 : 0;
                break;
            default:
                break;
        }
        return $value;
    }


    /**
     * Returns the path info of the currently requested URL.
     * This refers to the part that is after the entry script and before the question mark.
     * The starting and ending slashes are stripped off.
     * @return string part of the request URL that is after the entry script and before the question mark.
     * Note, the returned pathinfo is decoded starting from 1.1.4.
     * Prior to 1.1.4, whether it is decoded or not depends on the server configuration
     * (in most cases it is not decoded).
     * @throws CException if the request URI cannot be determined due to improper server configuration
     */
    public function getPathInfo()
    {
        if ($this->_pathInfo === null) {
            $pathInfo = $this->getRequestUri();

            if (($pos = strpos($pathInfo, '?')) !== false)
                $pathInfo = substr($pathInfo, 0, $pos);

            $pathInfo = $this->decodePathInfo($pathInfo);

            $scriptUrl = $this->getScriptUrl();
            $baseUrl = $this->getBaseUrl();
            if (strpos($pathInfo, $scriptUrl) === 0) {
                //d('1');
                $pathInfo = substr($pathInfo, strlen($scriptUrl));
            } else if ($baseUrl === '' || strpos($pathInfo, $baseUrl) === 0) {
                //	d('2');
                $pathInfo = substr($pathInfo, strlen($baseUrl));
            } else if ($baseUrl === '' || strpos($_SERVER['REQUEST_URI'], $pathInfo) === 0) {
                //d('3');
                $pathInfo = $pathInfo;
            } else if (strpos($_SERVER['PHP_SELF'], $scriptUrl) === 0) {
                //d('4');
                $pathInfo = substr($_SERVER['PHP_SELF'], strlen($scriptUrl));
            } else
                throw new CException(Yii::t('yii', 'CHttpRequest is unable to determine the path info of the request.'));

            $this->_pathInfo = trim($pathInfo, '/');
        }
        return $this->_pathInfo;
    }

    public function redirect($url, $terminate = true, $statusCode = 302)
    {

        if (strpos($url, '/') === 0)
            $url = $this->getHostInfo() . $url;

        if ($statusCode == 301)
            header("HTTP/1.1 301 Moved Permanently");

        header('Location: ' . $url);

        if ($terminate)
            Yii::app()->end();
    }

    /**
     * Normalizes the request data.
     * This method strips off slashes in request data if get_magic_quotes_gpc() returns true.
     * It also performs CSRF validation if {@link enableCsrfValidation} is true.
     */
    protected function normalizeRequest()
    {
        parent::normalizeRequest();
        if ($this->getIsPostRequest() && $this->enableCsrfValidation && !$this->checkCurrentRoute())
            Yii::app()->detachEventHandler('onbeginRequest', array($this, 'validateCsrfToken'));
    }

    /**
     * Checks if current route should be validated by validateCsrfToken()
     * @return boolean true if current route should be validated
     */
    private function checkCurrentRoute()
    {
        foreach ($this->noCsrfValidationRoutes as $checkPath) {
            if (($pos = strpos($checkPath, "*")) !== false) {
                $checkPath = substr($checkPath, 0, $pos - 1);
                if (strpos($this->pathInfo, $checkPath) == 0)
                    return false;
            } elseif ($this->pathInfo === $checkPath) {
                return false;
            }
        }
        return true;
    }
}

?>