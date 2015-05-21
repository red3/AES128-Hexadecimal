<?php

/**
*与java oc互通的AES 128bit ecb mode 加解密算法
*@author jiayuan
*/
class Aes {
	/**
	*加密
	*@param string $input 明文
	*@param string $key  密钥
	*@return  string 加密后转16进制的字符串
	*@example：
	* 明文：123456
	* 密钥：
	* 返回：
	*/
	public static function encrypt($input, $key) {
		$size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
		$input = self::pkcs5_pad($input, $size);
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
		$iv = mcrypt_create_iv (mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
		mcrypt_generic_init($td, $key, $iv);
		$data = mcrypt_generic($td, $input);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		$data = bin2hex($data);
		return $data;
	}
	 /**
	 *兼容java pkcs5字符串补位
	 *@param string $text 待加密串
	 *@param string $blocksize aes 128bit 算法的待加密串的块长度
	 *@return string 补位后的字符串
	 */
	private static function pkcs5_pad ($text, $blocksize) {
		$pad = $blocksize - (strlen($text) % $blocksize);
		return $text . str_repeat(chr($pad), $pad);
	}
 	/**
 	*AES字符串解密
 	*@param string $sStr 密文
 	*@param string $sKey 密钥
 	*@return string 解密的结果
	*@example：
	* 密文：
	* 密钥：
	* 返回：123456
 	*/
	public static function decrypt($sStr, $sKey) {
		$sStr = self::hex2str($sStr);
		$decrypted= mcrypt_decrypt(
			MCRYPT_RIJNDAEL_128,
			$sKey,
			$sStr,
			MCRYPT_MODE_ECB
		);
 
		$dec_s = strlen($decrypted);
		$padding = ord($decrypted[$dec_s-1]);
		$decrypted = substr($decrypted, 0, -$padding);
		return $decrypted;
	}
	/**
	*hex转bin
	*@param string $hex 16进制字符串
	*@return string 返回二进制字符串
	*/
	public static function hex2str($hex)
	 {
	     $bin="";
	     for($i=0; $i<strlen($hex)-1; $i+=2)
	     {
	         $bin.=chr(hexdec($hex[$i].$hex[$i+1]));
	     }
	     return $bin;
	 }
}
?>
