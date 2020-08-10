<?php

/**
 * See the following thread for clarification and understanding
 *  of this section of the GhostCrypt/GhostHash.
 *   - http://www.phpclasses.org/discuss/package/9381/thread/3/
 */

class GhostHash
{
	public static function returnHash($publicKey)
	{
		$privateKey = 'PrIvAcY'; // md5('PrIvAcY');
		return md5($privateKey . $publicKey);
	}
}