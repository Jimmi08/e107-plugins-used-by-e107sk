<?php

/**
  * UNITED-NUKE CMS: Just Manage!
  * http://united-nuke.openland.cz/
  * http://united-nuke.openland.cz/forums/
  *
  * 2002 - 2005, (c) Jiri Stavinoha
  * http://united-nuke.openland.cz/weblog/
  *
  * Portions of this software are based on PHP-Nuke
  * http://phpnuke.org - 2002, (c) Francisco Burzi
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License
  * as published by the Free Software Foundation; either version 2
  * of the License, or (at your option) any later version.
**/
 

$outsidevotes = 0;
$anonvotes = 0;
$outsidevoteval = 0;
$anonvoteval = 0;
$regvoteval = 0;	
$truecomments = $totalvotesDB;
 
//	while($vrow = $db->sql_fetchrow($voteresult)) {
   foreach($voteresult AS $vrow) {             
		$ratingDB = $vrow['rating'];
		$ratinguserDB = $vrow['ratinguser'];
		$ratingcommentsDB = stripslashes(check_html($vrow['ratingcomments'], "nohtml"));
		if ($ratingcommentsDB=="") $truecomments--;
			if ($ratinguserDB==$anonymous) {  print_a($anonymous) ;
				$anonvotes++;
				$anonvoteval += $ratingDB;
			}
			if ($useoutsidevoting == 1) {
				if ($ratinguserDB=='outside') {
					$outsidevotes++;
					$outsidevoteval += $ratingDB;
				}
			} else { 
				$outsidevotes = 0;
			}
			if ($ratinguserDB!=$anonymous && $ratinguserDB!="outside") { 
				$regvoteval += $ratingDB;
			}
	}

$regvotes = $totalvotesDB - $anonvotes - $outsidevotes;
if ($totalvotesDB == 0) { 
	$finalrating = 0;
} else if ($anonvotes == 0 && $regvotes == 0) {
	/* Figure Outside Only Vote */
	$finalrating = $outsidevoteval / $outsidevotes;
	$finalrating = number_format($finalrating, 4); 
} else if ($outsidevotes == 0 && $regvotes == 0) {
	/* Figure Anon Only Vote */
	$finalrating = $anonvoteval / $anonvotes;
	$finalrating = number_format($finalrating, 4); 
} else if ($outsidevotes == 0 && $anonvotes == 0) {
	/* Figure Reg Only Vote */
	$finalrating = $regvoteval / $regvotes;                   
	$finalrating = number_format($finalrating, 4);
} else if ($regvotes == 0 && $useoutsidevoting == 1 && $outsidevotes != 0 && $anonvotes != 0 ) {
	/* Figure Reg and Anon Mix */
	$avgAU = $anonvoteval / $anonvotes;
	$avgOU = $outsidevoteval / $outsidevotes;
		if ($anonweight > $outsideweight ) {
			/* Anon is 'standard weight' */
			$newimpact = $anonweight / $outsideweight;
			$impactAU = $anonvotes;
			$impactOU = $outsidevotes / $newimpact;
			$finalrating = ((($avgOU * $impactOU) + ($avgAU * $impactAU)) / ($impactAU + $impactOU));
			$finalrating = number_format($finalrating, 4); 
		} else {
			/* Outside is 'standard weight' */
			$newimpact = $outsideweight / $anonweight;
			$impactOU = $outsidevotes;
			$impactAU = $anonvotes / $newimpact;
			$finalrating = ((($avgOU * $impactOU) + ($avgAU * $impactAU)) / ($impactAU + $impactOU));
			$finalrating = number_format($finalrating, 4); 
		}
} else {
	/* Registered User vs. Anonymous vs. Outside User Weight Calutions */
	$impact = $anonweight;
	$outsideimpact = $outsideweight;
		if ($regvotes == 0) {
			$regvotes = 0;
		} else { 
			$avgRU = $regvoteval / $regvotes;
		}
		if ($anonvotes == 0) {
			$avgAU = 0;
		} else {
			$avgAU = $anonvoteval / $anonvotes;
		}
		if ($outsidevotes == 0 ) {
			$avgOU = 0;
		} else {
			$avgOU = $outsidevoteval / $outsidevotes;
		}
	$impactRU = $regvotes;
	$impactAU = $anonvotes / $impact;
	$impactOU = $outsidevotes / $outsideimpact;
	$finalrating = (($avgRU * $impactRU) + ($avgAU * $impactAU) + ($avgOU * $impactOU)) / ($impactRU + $impactAU + $impactOU);
	$finalrating = number_format($finalrating, 4); 
}

?>