<?php
/* Main Functions */
/*********************************************************************************************/

# General Functions

	function currentPage() {
		return basename($_SERVER['PHP_SELF'], '.php');
	}
	
	function uniq_id($lenght = 13) {
		if (function_exists("random_bytes")) {
			$bytes = random_bytes(ceil($lenght / 2));
		} elseif (function_exists("openssl_random_pseudo_bytes")) {
			$bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
		} else {
			throw new Exception("no cryptographically secure random function available");
		}
		return substr(bin2hex($bytes), 0, $lenght);
	}
	
# Financial Functions

	function btcToSatoshi($btc) {
		return ($btc)*(pow(10, 8)); 
	}
	
	function satoshiToBTC($satoshi, $length = null) {
		return $value = isset($length) ? rtrim(rtrim(sprintf('%.'.$length.'f', $satoshi / 100000000), '0'), '.') : rtrim(rtrim(sprintf('%.8f', $satoshi / 100000000), '0'), '.');
	}
	
	function btcToUSD($btc, $crypto_rates) {
		return number_format((float)$btc * $crypto_rates["btcusd"], 2, '.', '');;
	}
		
	function usdToBTC($usd) {
		$data = file_get_contents("https://apirone.com/api/v1/tobtc?currency=USD&value=" .$usd. "");
		return $data;
	}
	
# Validation Functions

	function validate_email($email) {
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
		else return true;
	}
	
# Debug Functions

	function printr($array) {
		echo "<pre>";
		print_r($array);
		echo "</pre>";
	}

	function pp($a) {
	    echo "<pre style='color:snow; font-size: 14px;'>";
	    print_r($a);
	    echo "</pre>";
	}

	function writeToFile($content, $file, $single_line = false) {
		if($single_line == true) $fp = fopen($file, "w");
		else {
			$content = $content. PHP_EOL;
			$fp = fopen($file, "a");
		}
		fwrite($fp, $content);
		fclose($fp);
	}
	
# Sanitization Functions

	function sanitize($str) {
		$str = str_replace(array("$", "%", "#", "", "|", "€", "", "{", "[", "]", "}", "}", "£", "'", "="), "", $str);
		$str = strip_tags($str);
		$str = stripslashes($str);
		if(strlen($str) > 501) {
			die("String exceeded maximum length.");
		}
		return $str;
	}
	
# Output Functions

	function get_time_ago($time) {
		$time_difference = time() - $time;
		if($time_difference < 60 * 5) { return "online"; }
		$condition = array(12 * 30 * 24 * 60 * 60 => "year",
					30 * 24 * 60 * 60 => "month",
					24 * 60 * 60 => "day",
					60 * 60 => "hour",
					60 => "minute",
					1 => "second"
		);
		foreach($condition as $secs => $str) {
			$d = $time_difference / $secs;
			if($d >= 1) {
				$t = round( $d );
				return $t . " ". $str . ( $t > 1 ? "s" : "" ) . " ago";
			}
		}
	}
	
	function get_time_ago_plain($time) {
		$time_difference = time() - $time;
		$condition = array(12 * 30 * 24 * 60 * 60 => "year",
					30 * 24 * 60 * 60 => "month",
					24 * 60 * 60 => "day",
					60 * 60 => "hour",
					60 => "minute",
					1 => "second"
		);
		foreach($condition as $secs => $str) {
			$d = $time_difference / $secs;
			if($d >= 1) {
				$t = round( $d );
				return $t . " ". $str . ( $t > 1 ? "s" : "" ) . " ago";
			}
		}
	}
	
	function get_time_ago_days($time) {
		$time_difference = time() - $time;
		$condition = array(
					24 * 60 * 60 => ""
		);
		foreach($condition as $secs => $str) {
			$d = $time_difference / $secs;
			if($d >= 1) {
				$t = round( $d );
				return $t;
			}
		}
	}
	
	function time_left($time_left = 0, $endtime = null) {
		if($endtime != null) 
			$time_left = $endtime - time(); 
		if($time_left > 0) { 
			$days = floor($time_left / 86400); 
			$time_left = $time_left - $days * 86400; 
			$hours = floor($time_left / 3600); 
			$time_left = $time_left - $hours * 3600; 
			$minutes = floor($time_left / 60); 
			$seconds = $time_left - $minutes * 60; 
		} else { 
			return array(0, 0, 0, 0); 
		} 
		return array($days, $hours, $minutes, $seconds); 
	}

	function shortenString($string, $length, $trailingChar = '') {
		if(is_string($string) === false) {
			return false;
		}
		if(mb_strlen($string) > $length) {
			return mb_substr($string, 0, ($length - mb_strlen($trailingChar))) . $trailingChar;
		} else {
			return $string;
		}
	}

	function arrayKeyValueSearch($array, $key, $value) {
	    $results = array();
	    if (is_array($array)) {
	        if (isset($array[$key]) && str_contains($array[$key], $value)) {
	            $results[] = $array;
	        }
	        foreach ($array as $subArray) {
	            $results = array_merge($results, arrayKeyValueSearch($subArray, $key, $value));
	        }
	    }
	    return $results;
	}

	function highlight_word($content, $word, $color) {
	    $replace = '<span style="background-color: ' . $color . ';">' . $word . '</span>'; // create replacement
	    $content = str_ireplace($word, $replace, $content); // replace content

	    return $content; // return highlighted data
	}	
?>