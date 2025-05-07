<?php
include(dirname(__FILE__) . "/config.php");

$playerid = isset($_GET['playerid']) ? $_GET['playerid'] : '0';
if (!is_numeric($playerid)) $playerid = 0;

$weaponid = isset($_GET['weaponid']) ? $_GET['weaponid'] : '0';
if (!is_numeric($weaponid)) $weaponid = 0;

$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname, $dbport);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$query  = $conn->query('SELECT * FROM ' . $dbtblprefix . '`c_plr_weapons` WHERE `plrid` = ' . $playerid . ' AND `weaponid` = ' . $weaponid);

$plr_accuracy		=	0;
$plr_shots			=	0;
$plr_shot_head		=	0;
$plr_shot_rightarm	=	0;
$plr_shot_rightleg	=	0;
$plr_shot_chest		=	0;
$plr_shot_leftarm	=	0;
$plr_shot_stomach	=	0;
$plr_shot_leftleg	=	0;

if ($query->num_rows > 0)
{
	while($row = $query->fetch_assoc())
	{
		$hits_one_pct											=	$row['hits'] / 100;
		$plr_accuracy											=	round($row['accuracy'], 0) . '%';
		if ($row['shot_head']		!= 0) $plr_shot_head		=	round(($row['shot_head']		/ $hits_one_pct), 0);
		if ($row['shot_rightarm']	!= 0) $plr_shot_rightarm	=	round(($row['shot_rightarm']	/ $hits_one_pct), 0);
		if ($row['shot_rightleg']	!= 0) $plr_shot_rightleg	=	round(($row['shot_rightleg']	/ $hits_one_pct), 0);
		if ($row['shot_chest']		!= 0) $plr_shot_chest		=	round(($row['shot_chest']		/ $hits_one_pct), 0);
		if ($row['shot_leftarm']	!= 0) $plr_shot_leftarm		=	round(($row['shot_leftarm']		/ $hits_one_pct), 0);
		if ($row['shot_stomach']	!= 0) $plr_shot_stomach		=	round(($row['shot_stomach']		/ $hits_one_pct), 0);
		if ($row['shot_leftleg']	!= 0) $plr_shot_leftleg		=	round(($row['shot_leftleg']		/ $hits_one_pct), 0);
	}
}
mysqli_free_result($query);
$conn->close();

$hitbox = '';

$hitbox .=<<<HEADER
<!DOCTYPE html>
<html lang="en">
<head>
<title>PLAYER HITBOX</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style>
html{
	-webkit-user-select: none;
	-moz-user-select: none;
	user-select: none;
}

body {
  margin: 0;
  padding: 0;
}

.hitbox_container{
	position: relative;
	width: 584px;
	height: 646px;
	margin: 0 auto;
}

.hitbox_container img{
	position: absolute;
}

.hitbox_container p{
	position: absolute;
	font-family: "Arial Black";
	font-weight: bold;
}
</style>
</head>

<body>
<div class="hitbox_container">
HEADER . PHP_EOL;
$filter = '';
$hue = 40;
$max_hue = 70;
$saturation = 170;
$hitbox .= '	<img src="img/hitbox/hitbox_bg.png" draggable="false" style="width: 584px; height: 646px;" alt="" title="">' . PHP_EOL;

$hue_rotate = ($plr_shot_head < $max_hue) ? ($plr_shot_head + $hue) : $max_hue;
$filter = ($plr_shot_head > 0) ? ' filter: hue-rotate(-' . $hue_rotate . 'deg) saturate(' . $saturation . '%);' : '';
$hitbox .= '	<img src="img/hitbox/hg_head.png" draggable="false" style="margin-left: 257px; margin-top: 8px; width: 70px; height: 86px;' . $filter . '" alt="" title="Head">' . PHP_EOL;

$hue_rotate = ($plr_shot_rightarm < $max_hue) ? ($plr_shot_rightarm + $hue) : $max_hue;
$filter = ($plr_shot_rightarm > 0) ? ' filter: hue-rotate(-' . $hue_rotate . 'deg) saturate(' . $saturation . '%);' : '';
$hitbox .= '	<img src="img/hitbox/hg_rightarm.png" draggable="false" style="margin-left: 27px; margin-top: 99px; width: 214px; height: 143px;' . $filter . '" alt="" title="Right Arm">' . PHP_EOL;

$hue_rotate = ($plr_shot_rightleg < $max_hue) ? ($plr_shot_rightleg + $hue) : $max_hue;
$filter = ($plr_shot_rightleg > 0) ? ' filter: hue-rotate(-' . $hue_rotate . 'deg) saturate(' . $saturation . '%);' : '';
$hitbox .= '	<img src="img/hitbox/hg_rightleg.png" draggable="false" style="margin-left: 167px; margin-top: 273px; width: 127px; height: 364px;' . $filter . '" alt="" title="Right Leg">' . PHP_EOL;

$hue_rotate = ($plr_shot_leftarm < $max_hue) ? ($plr_shot_leftarm + $hue) : $max_hue;
$filter = ($plr_shot_leftarm > 0) ? ' filter: hue-rotate(-' . $hue_rotate . 'deg) saturate(' . $saturation . '%);' : '';
$hitbox .= '	<img src="img/hitbox/hg_leftarm.png" draggable="false" style="margin-left: 341px; margin-top: 96px; width: 214px; height: 143px;' . $filter . '" alt="" title="Left Arm">' . PHP_EOL;

$hue_rotate = ($plr_shot_leftleg < $max_hue) ? ($plr_shot_leftleg + $hue) : $max_hue;
$filter = ($plr_shot_leftleg > 0) ? ' filter: hue-rotate(-' . $hue_rotate . 'deg) saturate(' . $saturation . '%);' : '';
$hitbox .= '	<img src="img/hitbox/hg_leftleg.png" draggable="false" style="margin-left: 292px; margin-top: 270px; width: 123px; height: 363px;' . $filter . '" alt="" title="Left Leg">' . PHP_EOL;

$hue_rotate = ($plr_shot_chest < $max_hue) ? ($plr_shot_chest + $hue) : $max_hue;
$filter = ($plr_shot_chest > 0) ? ' filter: hue-rotate(-' . $hue_rotate . 'deg) saturate(' . $saturation . '%);' : '';
$hitbox .= '	<img src="img/hitbox/hg_chest.png" draggable="false" style="margin-left: 228px; margin-top: 86px; width: 133px; height: 117px;' . $filter . '" alt="" title="Chest">' . PHP_EOL;

$hue_rotate = ($plr_shot_stomach < $max_hue) ? ($plr_shot_stomach + $hue) : $max_hue;
$filter = ($plr_shot_stomach > 0) ? ' filter: hue-rotate(-' . $hue_rotate . 'deg) saturate(' . $saturation . '%);' : '';
$hitbox .= '	<img src="img/hitbox/hg_stomach.png" draggable="false" style="margin-left: 218px; margin-top: 196px; width: 147px; height: 85px;' . $filter . '" alt="" title="Stomach">' . PHP_EOL;

$hitbox .=<<<FOOTER
<!--HEAD-->
	<p style="margin-left: 20px; margin-top: 35px; font-size: 25px;">Head</p>
	<p style="margin-left: 20px; margin-top: 70px; font-size: 18px;">{$plr_shot_head}%</p>
<!--RIGHT ARM-->
	<p style="margin-left: 20px; margin-top: 280px; font-size: 25px;">Right Arm</p>
	<p style="margin-left: 20px; margin-top: 315px; font-size: 18px;">{$plr_shot_rightarm}%</p>
<!--RIGHT LEG-->
	<p style="margin-left: 20px; margin-top: 390px; font-size: 25px;">Right Leg</p>
	<p style="margin-left: 20px; margin-top: 425px; font-size: 18px;">{$plr_shot_rightleg}%</p>
<!--CHEST-->
	<p style="margin-left: 490px; margin-top: 80px; font-size: 25px;">Chest</p>
	<p style="margin-left: 490px; margin-top: 115px; font-size: 18px;">{$plr_shot_chest}%</p>
<!--LEFT ARM-->
	<p style="margin-left: 450px; margin-top: 250px; font-size: 25px;">Left Arm</p>
	<p style="margin-left: 450px; margin-top: 285px; font-size: 18px;">{$plr_shot_leftarm}%</p>
<!--STOMACH-->
	<p style="margin-left: 450px; margin-top: 360px; font-size: 25px;">Stomach</p>
	<p style="margin-left: 450px; margin-top: 395px; font-size: 18px;">{$plr_shot_stomach}%</p>
<!--LEFT LEG-->
	<p style="margin-left: 460px; margin-top: 480px; font-size: 25px;">Left Leg</p>
	<p style="margin-left: 460px; margin-top: 515px; font-size: 18px;">{$plr_shot_leftleg}%</p>
<!--ACCURACY-->
	<p style="margin-left: 80px; margin-top: 603px; font-size: 20px;">{$plr_accuracy}</p>
</div>
</body>
</html>
FOOTER . PHP_EOL;

echo $hitbox;

?>