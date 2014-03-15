<?php
class AccountService {

	public static function generateNumber(){
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
		$number[] = $checkSum;
		$number = implode($number);
		if(!self::checkNumber($number)){
			return self::generateNumber();
		}
		return $number;
	}
	
	public static function checkNumber($number){
		$sum = 0;
		$number = str_split($number);
		if(count($number) != 12){
			return false;
		}
		foreach($number as $key => $value){
			if($key%2 == 0){
				$value = $value*2;
				if($value >= 10){
					$value = $value-9;
				}
			}
			$sum = $value + $sum;
		}
		if($sum%10){
			return false;
		} else {
			return true;
		}
	}

}