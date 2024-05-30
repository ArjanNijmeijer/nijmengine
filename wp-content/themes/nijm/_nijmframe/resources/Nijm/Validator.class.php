<?php

/*
 * The main template class with the validator functions.
 */

class Validator 
{	
	

	/* 
	 * Check if the given value is a proper Time value.
	 */
	public function checkTime($var)
	{ 
		// return (preg_match('/^[0-9]+$/', $var) ? true : false);
		$time = strtotime($var);
		
		if ($time >= 0 && false !== $time)
		{
			return true;
		}
		
		return false;
	}
	
	/* 
	 * Check if the given value is a proper Date value.
	 */
	public function checkDate($var)
	{
		if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $var, $parts))
		{		
			if(checkdate($parts[2],$parts[3],$parts[1]))
				return true;
			else
				return false;
		}
		
 		return false;
	}
	
	/* 
	 * Check if the given value is an integer.
	 */
	public function checkInt($var)
	{ 
		return (preg_match('/^[0-9]+$/', $var) ? true : false);
	}
	 
	/* 
	 * Check if the given value is an price.
	 */
	public function checkNumeric($var)
	{ 
		return (is_numeric($var) ? true : false);
  	}
	
	/* 
	 * Check if the given value is an integer.
	 */
	public function checkString($var, $allowEmpty = true)
	{
		return (is_string($var) && ( !(!$allowEmpty && !strlen(trim($var))) || $allowEmpty) ? true : false);
  	}
  
	/*
	 * Check if the given value has alphabetic characters only.
	 */
    public static function checkCharacters($var) 
    {
        return (preg_match("/^[aA-zZ]+$/", $var) ? true : false);
    }
  	
	/* 
	 * Check if the given value is an integer.
	 */
	public function checkArray($var, $allowEmpty = true)
	{ 
		return (is_array($var) && ( (!$allowEmpty && !empty($var)) || $allowEmpty) ? true : false);
  	}

	
	/* 
	 * Check the syntax of an emailaddress
	 */
	public function checkEmail($email) 
	{
 		return (!preg_match('/^( [a-zA-Z0-9] )+( [a-zA-Z0-9\._-] )*@( [a-zA-Z0-9_-] )+( [a-zA-Z0-9\._-] +)+$/' , $email) ? true : false);
	}

	/*
	 * Validate Dutch thelephone numbers.
	 */
	public function checkDutchZipcode($zipcode) 
	{
        return (preg_match('/^[0-9]{4}\s?[A-Z]{2}$/', strtoupper($zipcode)) ? true : false); 
	}
    
	/*
	 * Validate Dutch telephone numbers.
	 */
    public static function checkDutchPhoneNumber($phonenumber) 
    {
        return (preg_match('/^(\d{3}-?\d{7}|\d{4}-?\d{6})$/', $phonenumber) ? true : false);
    }
 
	/**
	 * Validate URL.
	 */
    public static function checkURL($var) 
    {
        return (preg_match('/^https?:\/\/([a-z0-9\-@]+\.?):?\.([a-z]{2,4}|[a-z]{2,4}:[0-9]{1,6})\/?$/i', $var) ? true : false); 
    }
	
	/**
	 * Validate ENUM.
	 */
	function checkEnum($var, $allowedValues)
	{
		return (self::checkArray($allowedValues) && in_array($var, $allowedValues) ? true : false);
	}
} 
?>