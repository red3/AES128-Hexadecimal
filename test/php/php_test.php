<?php

include 'aes.class.php';
define('AUTH_KEY','zA}nH(sd3eR[gy7>'); //AES加解密用的key

class Test {

	public function decode($str) {
		return Aes::decrypt($str, AUTH_KEY);
	}
	public function encode($str) {
		return Aes::encrypt($str, AUTH_KEY);
	}

}

$test = new Test();
$array = getopt("m:c:");
// var_dump($array);
$method = $array['m'];
$context = $array['c'];

if (method_exists($test, $method)) {
	$str = $test->$method($context);
	echo $str;
}
else {
	echo 'fuction '. $method . ' is not exist!';
}
exit;

?>
