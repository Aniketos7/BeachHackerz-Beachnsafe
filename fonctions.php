<?php
//Fonction de lecture des fichiers json

//Fonction pour récupérer les infos météo pour une certaine plage (ou ville)
function get_meteo($nom_atrouver, $nbre_jours = 1, $apikey){
	//D'abord récupérer le location key:
	$url = "http://dataservice.accuweather.com/locations/v1/search?apikey=".$apikey."&q=".urlencode($nom_atrouver);
	
	 $request = curl_init();
        $timeOut = 0;
		// 
		curl_setopt ($request, CURLOPT_URL, $url);
        curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($request, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
        $response = curl_exec($request);
        curl_close($request);
		$response = json_decode($response);
		if(!($response)){exit('Sorry! We could not find the beach you request for! Please try with another request.');}
		$cle = $response[0]->{'Key'};
		//Ensuite refaire la requete pour recupérer les infos de la météo
		
		$url = "http://dataservice.accuweather.com/forecasts/v1/daily/5day/".$cle."?apikey=".$apikey."&language=fr-FR&details=true";
		
		$request = curl_init();
        $timeOut = 0;
		//curl_setopt($request, CURLOPT_HTTPHEADER, array("Content-Type: json","x-access-token: 76cfa5f8de1a0949e2ce589e3cf30f6e"));
		curl_setopt ($request, CURLOPT_URL, $url);
        curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($request, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
        $response = curl_exec($request);
        curl_close($request);
		$response = json_decode($response);
		return $response;
	
}

// Fonction pour passer de dégrée F au dégré Celsius
function ftoc($temperature){
		return round(($temperature - 32)/1.8);
}
// Fonction pour passer de inch(pouce) à millimètre
function itomm($inch){
		return ($inch * 25.4);
}

// fonction pour retourner la class couleur correspondant à un certain uvindex
function uvicolor($uvi){
	$uvi = (int) $uvi;
	if ($uv <= 2){
			return "low";
	}
	else if ($uv > 2 AND $uv <= 5){
			return "moderate";
	}
	else if ($uv > 5 AND $uv <= 7){
			return "high";
	}
	else if ($uv > 7 AND $uv <= 10){
			return "very_high";
	}
	else{
			return "extreme";
	}
}

function get_proba_pluie($journee, $soiree){
	if (($journee == 0) AND ($soiree == 0)){
			return null;
	}
	else{
	$actu = getdate();
	$aafficher = ($actu > 17) ? $journee:$soiree;
	$temps = ($actu > 17) ? 'the day':'the evening';
    return "There are ".$aafficher."% chance of rain in ".$temps;
	}
}

function get_proba_neige($journee, $soiree){
	if (($journee == 0) AND ($soiree == 0)){
			return null;
	}
	else{
	$actu = getdate();
	$aafficher = ($actu > 17) ? $journee:$soiree;
	$temps = ($actu > 17) ? 'the day':'the evening';
    return "There are ".$aafficher."% chance of snow in ".$temps;
	}
} //Bon Officiellement Rien Illumine Serieusement Et Voilà, Rien A Réellement Dédaigner

function nbre_phrases($str){
    return preg_match_all('/[^\s](\.|\!|\?)(?!\w)/',$str,$match);
}

function get_uv_conseil($uv){
    if ($uv <= 2){
			return "There is a low danger from the sun's UV rays for the average person.<br/>Wear sunglasses on bright days.<br/>If you burn easily, cover up and use broad spectrum SPF 30+ sunscreen. Bright surfaces, such as sand, water and snow, will increase UV exposure.";
	}
	else if ($uv > 2 AND $uv <= 5){
			return "There is moderate risk of harm from unprotected sun exposure. <br/>Stay in shade near midday when the sun is strongest. <br/>If outdoors, wear sun protective clothing, a wide-brimmed hat, and UV-blocking sunglasses. Generously apply broad spectrum SPF 30+ sunscreen every 2 hours, even on cloudy days, and after swimming or sweating. Bright surfaces, such as sand, water and snow, will increase UV exposure.";
	}
	else if ($uv > 5 AND $uv <= 7){
			return "There is high risk of harm from unprotected sun exposure. <br/>Protection against skin and eye damage is needed. <br/>Reduce time in the sun between 10 a.m. and 4 p.m. <br/>If outdoors, seek shade and wear sun protective clothing, a wide-brimmed hat, and UV-blocking sunglasses. Generously apply broad spectrum SPF 30+ sunscreen every 2 hours, even on cloudy days, and after swimming or sweating.<br/> Bright surfaces, such sand, water and snow, will increase UV exposure.";
	}
	else if ($uv > 7 AND $uv <= 10){
			return "There is very high risk of harm from unprotected sun exposure. <br/>Take extra precautions because unprotected skin and eyes will be damaged and can burn quickly. <br/>Minimize sun exposure between 10 a.m. and 4 p.m. If outdoors, seek shade and wear sun protective clothing, a wide-brimmed hat, and UV-blocking sunglasses. <br/>Generously apply broad spectrum SPF 30+ sunscreen every 2 hours, even on cloudy days, and after swimming or sweating. Bright surfaces, such as sand, water and snow, will increase UV exposure.";
	}
	else{
			return "extreme risk of harm from unprotected sun exposure. <br/>Take all precautions because unprotected skin and eyes can burn in minutes. Try to avoid sun exposure between 10 a.m. and 4 p.m. If outdoors, seek shade and wear sun protective clothing, a wide-brimmed hat, and UV-blocking sunglasses. <br/>Generously apply broad spectrum SPF 30+ sunscreen every 2 hours, even on cloudy days, and after swimming or sweating. Bright surfaces, such as sand, water and snow, will increase UV exposure.";
	}
		
}

function conseil_gle(){
	
}
// Fonction pour securiser la variable envoyé a mon api
	function securize($getvaria){
		$retour = trim(strip_tags($getvaria));
		return $retour;
	}
	
	function deriv_uv($uvi){
    $heure = 0;
    $actu = getdate();
    $heure = $actu['hours'] + ($actu['minutes']/60) + ($actu['seconds'] / 60);
    $nuc = ($heure <= 12)?(($heure/12) * $uvi):((1/($heure - 12)) * $uvi); 
    return ceil($nuc);

  //  return $uvi;
}

//fonction d'analyse des variables
function analyze_var(){
		//analyser l'indice UV
		
		
		//Analyser l'heure de la journee
		
		//analyse de la probabilité qu'il pleuve
		
		//analyse de la houle et de la vitesse du vent

}
//Fonction de dump de variables
/**
 * Dump helper. Functions to dump variables to the screen, in a nicley formatted manner.
 * @author Joost van Veen
 * @version 1.0
 */
if (!function_exists('dump')) {
    function dump ($var, $label = 'Dump', $echo = TRUE)
    {
        // Store dump in variable 
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        
        // Add formatting
        $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
        $output = '<pre style="background: #FFFEEF; color: #000; border: 1px dotted #000; padding: 10px; margin: 10px 0; text-align: left;">' . $label . ' => ' . $output . '</pre>';
        
        // Output
        if ($echo == TRUE) {
            echo $output;
        }
        else {
            return $output;
        }
    }
}

if (!function_exists('dump_exit')) {
    function dump_exit($var, $label = 'Dump', $echo = TRUE) {
        dump ($var, $label, $echo);
        exit;
    }
}

?>