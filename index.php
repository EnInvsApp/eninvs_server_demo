<?php

date_default_timezone_set('Europe/Moscow');
include '/html/head_foot/head_1.php';

// ------------

if ($user_has_access)
{
	if (in_array($siteUserLogin___, $Terminal_GroupLogins) && $siteUserLogin___ != 'Admin')
	{
		echo '<script>window.location.replace("http://eninvs.com/client_stat.php?client=',$siteUserLogin___,'");</script>';
	}
	else
	{
		if ($african_user)
		{
			echo '<script>window.location.replace("http://eninvs.com/companies_JSE.php");</script>';
		}
		else
		{
			if 
			(
				!in_array($_COOKIE_user, $US_subscriber_Login) && 
				in_array($_COOKIE_user, $RF_subscriber_Login)
			)
				echo '<script>window.location.replace("http://eninvs.com/companies_all.php");</script>';
			else
			{
				if 
				(
					in_array($_COOKIE_user, $US_subscriber_Login) && 
					!in_array($_COOKIE_user, $RF_subscriber_Login)
				)
				{
					echo '<script>window.location.replace("http://eninvs.com/companies_all_world.php");</script>';
				}
				{
					$HM = date('H:i');
					if (($header_lang_keep == 'RU' || !$foreign_user) && ($HM > '09:00' && $HM < '19:00'))
					{
						echo '<script>window.location.replace("http://eninvs.com/companies_all.php");</script>';
					}
					else 
					{
						echo '<script>window.location.replace("http://eninvs.com/companies_all_world.php");</script>';
					}
				}
			}
		}
	}
}
else
{
	if ($african_user)
	{
		echo '<script>window.location.replace("http://eninvs.com/companies_JSE.php");</script>';
	}
	else
	{
		if ($header_lang_keep == 'RU' || true)
		{
			echo '<script>window.location.replace("http://eninvs.com/about.php");</script>';
		}
		else 
		{
			echo '<script>window.location.replace("http://eninvs.com/project/join.html");</script>';
		}
	}
}

?>