<?php
//iNCLUSION DES AUTRES FICHIERS
include('config.php');
include('fonctions.php');

//Déclaration des variables
$nbre_conseils = 0;


// if(!(isset ($_GET['plage']))):
if((isset($_GET['plage'])) AND ($_GET['plage'] != '')):

//Le fichier plages.json contient la liste des plages ainsi que leurs localisation et leurs caractéristiques
/*$plages_json = file_get_contents("datas/plages.json");
$plages = json_decode($plages_json);
$nom = "myrtle";

$plage = $plages->{$nom};
//On envoie le nom de la ville de la plage à l'Api
*/

$plage = securize($_GET['plage']);
$location = get_meteo($plage, 3, $apikey);
$caracteristiques = array();
//Prévisions d'aujourd'hui
$caracteristiques['prevision_general'] = $location->Headline->Text;
$caracteristiques['lever_soleil'] = $location->DailyForecasts[0]->Sun->Rise;
$caracteristiques['coucher_soleil'] = $location->DailyForecasts[0]->Sun->Set;
$caracteristiques['temp_min'] = ftoc($location->DailyForecasts[0]->Temperature->Minimum->Value)."°C";
$caracteristiques['temp_max'] = ftoc($location->DailyForecasts[0]->Temperature->Maximum->Value)."°C";
$caracteristiques['qualite_air'] = $location->DailyForecasts[0]->AirAndPollen[0]->Category;
$caracteristiques['index_uv'] = $location->DailyForecasts[0]->AirAndPollen[5]->Value;
$caracteristiques['prevision_journee'] = $location->DailyForecasts[0]->Day->ShortPhrase;
$caracteristiques['probabilite_pluie_journee'] = $location->DailyForecasts[0]->Day->RainProbability;
$caracteristiques['probabilite_neige_journee'] = $location->DailyForecasts[0]->Day->SnowProbability;
$caracteristiques['vitesse_vent_journee'] = $location->DailyForecasts[0]->Day->Wind->Speed;
$caracteristiques['direction_vent_journee'] = $location->DailyForecasts[0]->Day->Wind->Direction->Degrees.' degrees '.$location->DailyForecasts[0]->Day->Wind->Direction->English;;
$caracteristiques['mm_pluie_journee'] = itomm($location->DailyForecasts[0]->Day->Rain->Value)."mm";
$caracteristiques['prevision_soiree'] = $location->DailyForecasts[0]->Night->ShortPhrase;
$caracteristiques['probabilite_pluie_soiree'] = $location->DailyForecasts[0]->Night->RainProbability;
$caracteristiques['probabilite_neige_soiree'] = $location->DailyForecasts[0]->Night->SnowProbability;
$caracteristiques['vitesse_vent_soiree'] = $location->DailyForecasts[0]->Night->Wind->Speed;
$caracteristiques['direction_vent_soiree'] = $location->DailyForecasts[0]->Night->Wind->Direction->Degrees.' degrees'.$location->DailyForecasts[0]->Day->Wind->Direction->English;;
$caracteristiques['mm_pluie_soiree'] = itomm($location->DailyForecasts[0]->Night->Rain->Value)." mm";
//Prévisions de demain
$caracteristiques['lever_soleil_demain'] = $location->DailyForecasts[1]->Sun->Rise;
$caracteristiques['coucher_soleil_demain'] = $location->DailyForecasts[1]->Sun->Set;
$caracteristiques['temp_min_demain'] = ftoc($location->DailyForecasts[1]->Temperature->Minimum->Value)."°C";
$caracteristiques['temp_max_demain'] = ftoc($location->DailyForecasts[1]->Temperature->Maximum->Value)."°C";
$caracteristiques['qualite_air_demain'] = $location->DailyForecasts[1]->AirAndPollen[0]->Category;
$caracteristiques['index_uv_demain'] = $location->DailyForecasts[1]->AirAndPollen[5]->Value;
$caracteristiques['prevision_journee_demain'] = $location->DailyForecasts[1]->Day->ShortPhrase;
$caracteristiques['probabilite_pluie_journee_demain'] = $location->DailyForecasts[1]->Day->RainProbability;
$caracteristiques['probabilite_neige_journee_demain'] = $location->DailyForecasts[1]->Day->SnowProbability;
$caracteristiques['vitesse_vent_journee_demain'] = $location->DailyForecasts[1]->Day->Wind->Speed;
$caracteristiques['direction_vent_journee_demain'] = $location->DailyForecasts[1]->Day->Wind->Direction->Degrees.' degrees '.$location->DailyForecasts[0]->Day->Wind->Direction->English;;
$caracteristiques['mm_pluie_journee_demain'] = itomm($location->DailyForecasts[1]->Day->Rain->Value)."mm";
$caracteristiques['prevision_soiree_demain'] = $location->DailyForecasts[1]->Night->ShortPhrase;
$caracteristiques['probabilite_pluie_soiree_demain'] = $location->DailyForecasts[1]->Night->RainProbability;
$caracteristiques['probabilite_neige_soiree_demain'] = $location->DailyForecasts[1]->Night->SnowProbability;
$caracteristiques['vitesse_vent_soiree_demain'] = $location->DailyForecasts[1]->Night->Wind->Speed;
$caracteristiques['direction_vent_soiree_demain'] = $location->DailyForecasts[1]->Night->Wind->Direction->Degrees.' degrees'.$location->DailyForecasts[0]->Day->Wind->Direction->English;;
$caracteristiques['mm_pluie_soiree_demain'] = itomm($location->DailyForecasts[1]->Night->Rain->Value)." mm";
//Prévisions de après-demain
$caracteristiques['lever_soleil_apdemain'] = $location->DailyForecasts[2]->Sun->Rise;
$caracteristiques['coucher_soleil_apdemain'] = $location->DailyForecasts[2]->Sun->Set;
$caracteristiques['temp_min_apdemain'] = ftoc($location->DailyForecasts[2]->Temperature->Minimum->Value)."°C";
$caracteristiques['temp_max_apdemain'] = ftoc($location->DailyForecasts[2]->Temperature->Maximum->Value)."°C";
$caracteristiques['qualite_air_apdemain'] = $location->DailyForecasts[2]->AirAndPollen[0]->Category;
$caracteristiques['index_uv_apdemain'] = $location->DailyForecasts[2]->AirAndPollen[5]->Value;
$caracteristiques['prevision_journee_apdemain'] = $location->DailyForecasts[2]->Day->ShortPhrase;
$caracteristiques['probabilite_pluie_journee_apdemain'] = $location->DailyForecasts[2]->Day->RainProbability;
$caracteristiques['probabilite_neige_journee_apdemain'] = $location->DailyForecasts[2]->Day->SnowProbability;
$caracteristiques['vitesse_vent_journee_apdemain'] = $location->DailyForecasts[2]->Day->Wind->Speed;
$caracteristiques['direction_vent_journee_apdemain'] = $location->DailyForecasts[2]->Day->Wind->Direction->Degrees.' degrees '.$location->DailyForecasts[0]->Day->Wind->Direction->English;;
$caracteristiques['mm_pluie_journee_apdemain'] = itomm($location->DailyForecasts[2]->Day->Rain->Value)."mm";
$caracteristiques['prevision_soiree_apdemain'] = $location->DailyForecasts[2]->Night->ShortPhrase;
$caracteristiques['probabilite_pluie_soiree_apdemain'] = $location->DailyForecasts[2]->Night->RainProbability;
$caracteristiques['probabilite_neige_soiree_apdemain'] = $location->DailyForecasts[2]->Night->SnowProbability;
$caracteristiques['vitesse_vent_soiree_apdemain'] = $location->DailyForecasts[2]->Night->Wind->Speed;
$caracteristiques['direction_vent_soiree_apdemain'] = $location->DailyForecasts[2]->Night->Wind->Direction->Degrees.' degrees'.$location->DailyForecasts[0]->Day->Wind->Direction->English;;
$caracteristiques['mm_pluie_soiree_apdemain'] = itomm($location->DailyForecasts[2]->Night->Rain->Value)." mm";


//Analyse des différentes variables
$recommandations = array();
$caracteristiques['uv_cheklist'] = get_uv_conseil(deriv_uv($caracteristiques['index_uv']));
$nbre_conseils = (mb_substr_count($caracteristiques['uv_cheklist'], "<br/>")) + 1;

//$i va me permettre de suivre l'indexation du tableau hahaha je suis vraiment Evrard LEBOSSS!!!
$i = 1;
//Analysons la probabilité qu'il pleuve
$pluie = get_proba_pluie($caracteristiques['probabilite_pluie_journee'], $caracteristiques['probabilite_pluie_soiree']);
if ($pluie){
	$i++;
$caracteristiques['rain_checklist'] = $pluie;
}

//Analysons la probabilité qu'il neige
$neige = get_proba_neige($caracteristiques['probabilite_neige_journee'], $caracteristiques['probabilite_neige_soiree']);
if ($neige){
	$i++;
	$caracteristiques['snow_checklist'] = $neige;
}



// dump($location->Headline->TextHeadline->Text);
$caracteristiques = json_encode($caracteristiques, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
header('Content-Type: application/json');
echo $caracteristiques;
else:
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Beach & Safe</title>

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
	<h1>Beach Hackerz present Beach & Safe</h1>
	<div id="body">
		<form action="" method="GET" >
		<input type="text" name="plage" placeholder="Veuillez entrer le nom de votre plage" size="50"/>
		<input type="submit" value="Consulter"/> 
		</form>
	</div>
		
	<p class="footer">Powered by <em>Beach Hackerz Team</em> for <em>2017 Space Apps Challenge</em></p>
</div>

</body>
</html>
<?php
endif;
?>
