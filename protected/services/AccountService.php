<?php
class AccountService
{
	public static function generateNumber()
    {
		$sum = 0;
		$number = array();
		for($i = 1; $i <= 11; $i++){
			$rand = rand(0, 9);
			$number[] = $rand;
			if($i%2 != 0){
				$rand = $rand*2;
				if($rand >= 10){
					$rand = $rand-9;
				}
			}
			$sum = $rand + $sum;
		}
		$checkSum = 10 - $sum%10;
		if($checkSum == 10){
			$checkSum = 0;
		}
		if(!$checkSum && $checkSum !== 0){
			return self::generateNumber(); //TODO do not generate numbers length 11
		}
		$number[] = $checkSum;
		$number = implode($number);
		if(!self::checkNumber($number)){
			return self::generateNumber();
		}
		return $number;
	}
	
	public static function checkNumber($number, $len = 12)
    {
		$sum = 0;
		$number = str_split($number);
		if(count($number) != $len){
			return false;
		}
		$last = array_pop($number);
		$number = array_reverse($number);
		foreach($number as $key => $value){
			if($key%2 == 0){
				$value = $value*2;
				if($value >= 10){
					$value = $value-9;
				}
			}
			$sum = $value + $sum;
		}
		$sum = $sum + $last;
		if($sum%10){
			return false;
		} else {
			return true;
		}
	}

	public static function checkNumberCard($number)
    {
		$sum = 0;
		$number = str_split($number);
		if(count($number) != 16){
			return false;
		}
		$chekSumm = array_pop($number);
		$number = array_reverse($number);
		foreach($number as $key => $value){
			if($key%2 == 0){
				$value = $value*2;
				if($value >= 10){
					$value = $value-9;
				}
			}
			$sum = $value + $sum;
		}
		d($number);
		d($sum);
		die;
		
		if($sum%10){
			return false;
		} else {
			return true;
		}
	}
}