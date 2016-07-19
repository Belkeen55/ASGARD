<?php
	function ping($ip)
	{
			if(exec("ping " . $ip . " -w 1"))
		{
			return "on";
		}
		else
		{
			return "off";
		}
	}
?>