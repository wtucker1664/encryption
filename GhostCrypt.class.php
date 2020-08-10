<?php

/**
 *
 * GhostCrypt 2.5
 *
 *  Minimal php-5.3.3
 *  Author: Nick Daniels
 *  Version: 2.5
 *
 */

class GhostCrypt
{
	// Data to be encrypted. 
	private $data;
	
	// Public Key to be used, 
	// if used within class construction
	private $pubKey;
   
   // Class construction.
	public function __construct($inFile = null, $outFileExt = '', $pubKey = '')
	{
		// Check whether the input file is empty or null.
		if(empty($inFile) || $inFile == null)
		{
			die("Err: Your input inFile is Blank or Null!" . PHP_EOL);
		}
		// Public key, unless one is inserted, generate a random public key.
		$this->pubKey = ( empty($pubKey) ) ? openssl_random_pseudo_bytes(32) : $pubKey;
		$this->data = file_get_contents($inFile);
		$this->data = $this->encrypt();
		$inFileInfo = pathinfo($inFile);
		list($outFile,) = explode($inFileInfo['extension'], $inFile);
		$outFile = $outFile . (empty($fileExt) ? 'enc.' . $inFileInfo['extension'] : $fileExt);
		file_put_contents($outFile, $this->decrypt().$this->data);
	}

	// Class Encryption
	private function encrypt()
	{
		// Public ? : or Private key, 
		// whether GhostHash is implemented within your environment.
		$k = ( method_exists('GhostHash','returnHash') ) ? GhostHash::returnHash($this->pubKey) : $this->pubKey;
		$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
		$encrypted = openssl_encrypt($this->data, 'aes-256-cbc', $k, 0, $iv);
		$encrypted = "#:#" . $encrypted . ':' . base64_encode($iv) . ':' . base64_encode($this->pubKey);
		return $encrypted;
	}
   
   // Class decryption/ Self Decrypt function.
	private function decrypt()
	{
		return '<?php
$data = file_get_contents(__FILE__);
$lines = explode(PHP_EOL, $data);
foreach($lines as $key => $line)
{
	if(substr($line, 0, 3) == "#:#")
	{
		$part = explode(":", substr($line, 3));
		$k = ( method_exists("GhostHash","returnHash") ) ? GhostHash::returnHash(base64_decode($part[2])) : base64_decode($part[2]);
		eval( "?>" . openssl_decrypt($part[0], "aes-256-cbc", $k, 0, base64_decode($part[1])) );
	}
}

';
	}
}