<?php
namespace Account\Model;

class Utilities
{
	private static function crypto_rand_secure($min, $max) {
		$range = $max - $min;
		if ($range < 0) return $min; // not so random...
		$log = log($range, 2);
		$bytes = (int) ($log / 8) + 1; // length in bytes
		$bits = (int) $log + 1; // length in bits
		$filter = (int) (1 << $bits) - 1; // set all lower bits to 1
		do {
			$rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
			$rnd = $rnd & $filter; // discard irrelevant bits
		} while ($rnd >= $range);
		return $min + $rnd;
	}
	
	public static function genToken($length, $digits = false){
		$token = "";
		$codeAlphabet = "";
		if (!$digits)
		{
			$codeAlphabet .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
			$codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
		}
		$codeAlphabet.= "0123456789";
		for($i=0;$i<$length;$i++){
			$token .= $codeAlphabet[self::crypto_rand_secure(0,strlen($codeAlphabet))];
		}
		return $token;
	}
}