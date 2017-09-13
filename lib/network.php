<?php
	function ping($ip)
	{
		$url = 'http://' . $ip . '/script/systeme.php';
		$headers = @get_headers($url, 1);
		if($headers[0]=='') return 0;
		return !((preg_match('/404/',$headers[0]))==1);
	}
?>
