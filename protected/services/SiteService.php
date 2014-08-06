<?php

class SiteService {

    public static function timeToDate($time, $day = false)
    {
        if($day){
            $result = self::getRusMonth(date("j m Y", $time), ' ', '2');
        } else {
            $result = date("Y-m-d H:i", $time);
        }
        return $result;
    }

    public static function dateFormat($dbDate){
        $aDate = explode('-', $dbDate);
        $return = round($aDate[2]) . ' ' . $aDate[1] . ' ' . $aDate[0];
        return self::getRusMonth($return, ' ', '2');
    }

    public static function getRusMonth($date,$delimiter,$month_position){
        $temp=explode($delimiter,$date);
        if($temp[$month_position-1] > 12 || $temp[$month_position-1] < 1) return FALSE;
        $aMonth = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
        $temp[$month_position-1]= Yii::t('Site', $aMonth[$temp[$month_position-1] - 1]);
        return implode($delimiter,$temp);
   }

    public static function getDataMothStr($date) {
        if($date > 10000) {
                $date = $date;
            } else {
                $date = strtotime($date);
            }

            $month = array(1 => 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
            $res = date('j ' . $month[date('n', $date)].' Y',$date);
            return $res;
    }
   
    public static function arrayTranslate($template, &$array)
    {
        $result = array();
        foreach($array as $key => $val)
        {
            $result[$key] = Yii::t($template, $val);
        }
        return $result;
    }

    public static function subStrEx($str, $len)
    {
        if(mb_strlen($str) <= $len){
            return $str;
        }
        return mb_substr($str, 0, $len, 'utf8').'&hellip;';
    }

    public static function getCorectWordsT($template, $word, $number)
    {
        $words = Yii::t($template, $word);
        $wArr = explode('|', $words);
		
        $c = $number % 10;
        if ($number > 10 && $number < 20)
            return $wArr[1];
        if ($c == 1)
            return $wArr[0];
        if ($c > 1 && $c <= 4)
            return $wArr[2];
        if ($c > 4 || $c == 0){
			if(isset($wArr[1])){
				return $wArr[1];
			}else{
				Yii::log('No message for translete:' . $word . 'in template:' . $template);
				return $word;
			}
		}
    }

    public static function timeRange($from, $to) {
        $differenceFull  = $to - $from;
        $differenceYear  = floor(($differenceFull) /32140800);
        $differenceMonth = floor(($differenceFull) /2592000);
        $differenceDay   = floor(($differenceFull) /86400);
        $differenceHour  = floor(($differenceFull) /3600);
        $differenceMin   = floor(($differenceFull) /60);
        $differenceSec   = $differenceFull;

        if($differenceFull <= 10){
            $differenceSec = 1;
        }
        if ($differenceYear >= 1){
            return $differenceYear . ' ' . self::getCorectWordsT('Site', 'year', $differenceYear);
        }
        if ($differenceMonth >= 1){
            $return = $differenceMonth . ' ' . self::getCorectWordsT('Site', "month", $differenceMonth);
            $differenceDay = floor(($differenceFull - ($differenceMonth * 2592000)) / 86400);
            $return .= ' ' . Yii::t('Site', 'and') . ' ' . $differenceDay . ' ' . self::getCorectWordsT('Site', "day", $differenceDay);
            return $return;
        }
        if ($differenceDay >= 1){
            return $differenceDay . ' ' . self::getCorectWordsT('Site', "day", $differenceDay);
        }
        if ($differenceHour >= 1){
            return $differenceHour . ' ' . self::getCorectWordsT('Site', "hour", $differenceHour);
        }
        if ($differenceMin >= 1){
            return $differenceMin . ' ' . self::getCorectWordsT('Site', "minute", $differenceMin);
        }
        if ($differenceSec < 60){
            return $differenceSec . ' ' . self::getCorectWordsT('Site', "second", $differenceSec);
        }
    return $from;
    }
	
	public static function getStrDate($date) {
            if($date > 10000) {
               $date = $date;
            } else {
                $date = strtotime($date);
            }

            if (date('Y.m.d', $date) == date("Y.m.d")) {
                $res = "сегодня в " . date('H:i', $date);
            }
            elseif (date('Y.m.d', $date) == date("Y.m.d", mktime(0, 0, 0, date("m"), date("d") - 1, date("Y"))))
            {
                $res = "вчера в " . date('H:i', $date);
            }
            elseif (date('Y.m.d', $date) == date("Y.m.d", mktime(0, 0, 0, date("m"), date("d") - 2, date("Y"))))
            {
                $res = "позавчера в " . date('H:i', $date);
            }
            else {
                $month = array(1 => 'января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря');
                $res = date('j ' . $month[date('n', $date)] . ' Y в H:i',$date);
            }
            return $res;
    }
	
	public static function getPublicObjectVars($obj) {
	  return get_object_vars($obj);
	}
	
	public static function normalizeStringTranslit($string)
	{

		static $lang2tr = array(
		// russian
			'й'=>'j','ц'=>'c','у'=>'u','к'=>'k','е'=>'e','н'=>'n','г'=>'g','ш'=>'sh',
			'щ'=>'sh','з'=>'z','х'=>'h','ъ'=>'','ф'=>'f','ы'=>'y','в'=>'v','а'=>'a',
			'п'=>'p','р'=>'r','о'=>'o','л'=>'l','д'=>'d','ж'=>'zh','э'=>'e','я'=>'ja',
			'ч'=>'ch','с'=>'s','м'=>'m','и'=>'i','т'=>'t','ь'=>'','б'=>'b','ю'=>'ju','ё'=>'e','и'=>'i',

			'Й'=>'J','Ц'=>'C','У'=>'U','К'=>'K','Е'=>'E','Н'=>'N','Г'=>'G','Ш'=>'SH',
			'Щ'=>'SH','З'=>'Z','Х'=>'H','Ъ'=>'','Ф'=>'F','Ы'=>'Y','В'=>'V','А'=>'A',
			'П'=>'P','Р'=>'R','О'=>'O','Л'=>'L','Д'=>'D','Ж'=>'ZH','Э'=>'E','Я'=>'JA',
			'Ч'=>'CH','С'=>'S','М'=>'M','И'=>'I','Т'=>'T','Ь'=>'','Б'=>'B','Ю'=>'JU','Ё'=>'E','И'=>'I',
			// czech
			'á'=>'a', 'ä'=>'a', 'ć'=>'c', 'č'=>'c', 'ď'=>'d', 'é'=>'e', 'ě'=>'e',
			'ë'=>'e', 'í'=>'i', 'ň'=>'n', 'ń'=>'n', 'ó'=>'o', 'ö'=>'o', 'ŕ'=>'r',
			'ř'=>'r', 'š'=>'s', 'Š'=>'S', 'ť'=>'t', 'ú'=>'u', 'ů'=>'u', 'ü'=>'u',
			'ý'=>'y', 'ź'=>'z', 'ž'=>'z',

			'і'=>'i', 'ї' => 'i', 'b' => 'b', 'І' => 'i',
			// special
			' '=>'-', '\''=>'', '"'=>'', '\t'=>'', '«'=>'', '»'=>'', '?'=>'', '!'=>'', '*'=>'', '.'=>'.', '-'=>'_',
		);
		$url = preg_replace( '/[\-]+/', '-', preg_replace( '/[^\w\-\*.]/', '', strtolower( strtr( $string, $lang2tr ) ) ) );
		//echo $url."<br>";
		return  $url;
	}
	
	public function getYouTubeId($url){
		$url = parse_url($url);
		if(isset($url['v'])){
			return $url['v'];
		}
		return false;;
	}
}
