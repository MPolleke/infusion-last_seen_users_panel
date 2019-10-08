<?php
/*-------------------------------------------------------+
| PHP-Fusion Content Management System
| Copyright (C) 2002 - 2008 Nick Jones
| http://www.php-fusion.co.uk/
+--------------------------------------------------------+
| This program is released as free software under the
| Affero GPL license. You can redistribute it and/or
| modify it under the terms of this license which you
| can read by viewing the included agpl.txt or online
| at www.gnu.org/licenses/agpl.html. Removal of this
| copyright header is strictly prohibited without
| written permission from the original author(s).
+--------------------------------------------------------*/

/* 
	Modified by Marwelln
	WWW: http://engine.redward.org
	Original creator: Unknown
*/

if (!defined("IN_FUSION")) { header("Location:../../index.php"); exit; }

if (file_exists(INFUSIONS."last_seen_users_panel/locale/".$settings['locale'].".php")) {
	include INFUSIONS."last_seen_users_panel/locale/".$settings['locale'].".php";
} else { include INFUSIONS."last_seen_users_panel/locale/English.php"; }

openside($locale['LSUP_000']);

echo "<table cellpadding='0' cellspacing='0' width='100%'  class=''>";
$result = dbquery("SELECT * FROM ".DB_PREFIX."users ORDER BY user_lastvisit DESC LIMIT 10");
if (dbrows($result) != 0) {
	$user_count = 0;
	while ($data = dbarray($result)) {

		// Check if user has ever logged in
		if ($data['user_lastvisit'] != 0) {
			$lastseen = time() - $data['user_lastvisit'];
			$iW=sprintf("%2d",floor($lastseen/604800));
			$iD=sprintf("%2d",floor($lastseen/(60*60*24)));
			$iH=sprintf("%02d",floor((($lastseen%604800)%86400)/3600));
			$iM=sprintf("%02d",floor(((($lastseen%604800)%86400)%3600)/60));
			$iS=sprintf("%02d",floor((((($lastseen%604800)%86400)%3600)%60)));
			if ($lastseen < 60){
				$lastseen="".$locale['LSUP_001']."";
			} elseif ($lastseen < 360){
				$lastseen="".$locale['LSUP_002']."";
			} elseif ($iW > 0){
				if ($iW == 1) {
					$Text = $locale['LSUP_003'];
				} else {
					$Text = $locale['LSUP_004'];
				}
				$lastseen = "".$iW." ".$Text."";
			} elseif ($iD > 0){
				if ($iD == 1) {
					$Text = $locale['LSUP_005'];
				} else {
					$Text = $locale['LSUP_006'];
				}
				$lastseen = "".$iD." ".$Text."";
			} else {
				$lastseen = $iH.":".$iM.":".$iS;
			}
		} else {
			$lastseen = $locale['LSUP_007'];
		}
		echo "<tr>
<td align='left'>".THEME_BULLET." 
<a href='".BASEDIR."profile.php?lookup=".$data['user_id']."'><span title='".$data['user_name']."'>".$data['user_name']."</span></a>
</td>
<td class='small2' align='right'>".$lastseen."</td>
</tr>";
		$user_count ++;
	}
}
echo "</table>";

closeside();
?>