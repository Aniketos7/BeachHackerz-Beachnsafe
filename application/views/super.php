<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Liste des Plages : Beach'n Go</title>

	<style type="text/css">

	::optionion { background-color: #E13300; color: white; }
	::-moz-optionion { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>	
<body>

<div id="container">
	<h1>Informations relatives à la Plage de <?php echo $plage; ?></h1>

	<div id="body">
    <div class="container">
    <ul>
    <li><strong>UVI: </strong><?php echo $uvi; ?></li>
    <li><strong>Température minaimale: </strong><?php echo $temperature_min; ?></li>
    <li><strong>Température Maximale: </strong><?php echo $temperature_max; ?></li>
    <li><strong>Vitesse minimale du vent: </strong><?php echo $vit_vent_min; ?></li>
    <li><strong>Vitesse maximale du vent: </strong><?php echo $vit_vent_max; ?></li>
    <li><strong>Hauteur minimale des vagues: </strong><?php echo $vague_min; ?></li>
    <li><strong>Hauteur maximale des vagues: </strong><?php echo $vague_max; ?></li>
    <li><strong>Température de l'eau: </strong><?php echo $temp_eau; ?></li>
    </ul>
    </div>
    <hr />
    Si vous souhaitez visiter la plage de <?php echo $plage;?>, nous avons quelques conseils pour vous.<br />
    <div class="container"><?php echo $conseil_uvi;?><br /><?php echo $conseil_temps." ".$proba_precipitation;?></div>
		
	</div>
		
	<p class="footer"></p>
</div>

</body>
</html>