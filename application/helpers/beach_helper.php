<?php

function add_meta_title ($string)
{
	$CI =& get_instance();
	$CI->data['meta_title'] = e($string) . ' - ' . $CI->data['meta_title'];
}

function btn_edit ($uri)
{
	return anchor($uri, '<i class="icon-edit"></i>');
}

function btn_delete ($uri)
{
	return anchor($uri, '<i class="icon-remove"></i>', array(
		'onclick' => "return confirm('You are about to delete a record. This cannot be undone. Are you sure?');"
	));
}

function article_link($article){
	return 'article/' . intval($article->id) . '/' . e($article->slug);
}

function deriv_uv($uvi){
    $heure = 0;
    $actu = getdate();
    $heure = $actu['hours'] + ($actu['minutes']/60) + ($actu['seconds'] / 60);
    $nuc = ($heure <= 12)?(($heure/12) * $uvi):((1/($heure - 12)) * $uvi); 
    return ceil($nuc);

    return $uvi;
}

function temp_conseil(){
    $actu = getdate();
    if($actu['hours'] < 7 OR $actu['hours']>20){
        return "A cette heure-ci, nous ne vous conseillons pas trop d'y aller. Sinon, ";
    }
}

function get_uv_conseil($uv){
    if ($uv <= 2){
			return "Aucune disposition particulière, ça ira";
	}
	else if ($uv > 2 AND $uv <= 5){
			return "Il est conseillé de vous couvrir et porter un chapeau. Appliquez un écran solaire de protection moyenne (indice de protection de 15 à 29), surtout pour une exposition à l’extérieur pendant plus de trente minutes. Rechercher l’ombre aux alentours de midi, quand le soleil est au zénith.";
	}
	else if ($uv > 5 AND $uv <= 7){
			return "Il est conseillé de réduire l’exposition entre 11 h et 17 h. Appliquez si vous le pouvez, un écran solaire de haute protection (indice de 30 à 50), portez un chapeau et des lunettes de soleil, placez-vous à l’ombre.";
	}
	else if ($uv > 7 AND $uv <= 10){
			return "Sans protection, votre peau sera endommagée et peut brûler. L’exposition au soleil peut être dangereuse entre 11 h et 17 h ; la recherche de l’ombre est donc importante. Nous vous recommandons le port de vêtements longs, d'un chapeau et de lunettes de soleil, ainsi que l'application d'un écran solaire de très haute protection (indice + 50).";
	}
	else{
			return "La peau non protégée sera endommagée et peut brûler en quelques minutes. Toute exposition au soleil est dangereuse, et en cas de sortie il faut se couvrir absolument (chapeau, lunettes de soleil, application d'un écran solaire de très haute protection d'indice + 50).";
	}
		
}


function uv_index($lat, $long){
	
	
	// $url = "http://api.owm.io/air/1.0/uvi/list?lat=".$lat."&lon=".$long;
	// $url = "http://api.owm.io/air/1.0/uvi/current?lat=".$lat."&lon=".$long."&appid=5ad9e512c84ed88275b29cdbec28c010";
	 //$url = "http://api.openweathermap.org/data/2.5/weather?q=Cotonou,bj&APPID=5ad9e512c84ed88275b29cdbec28c010";
	$url = "https://uvimate.herokuapp.com/api/getUVI/6.3603/2.3942/";
	
	
	// 76cfa5f8de1a0949e2ce589e3cf30f6e
	
	// 19006eca-f5f6-422c-a33a-bc2104215fad
	
	// curl --header "x-access-token: 76cfa5f8de1a0949e2ce589e3cf30f6e" https://uvimate.herokuapp.com/api/getUVI/-31.9604/115.8721
	// curl --header "x-access-token: 76cfa5f8de1a0949e2ce589e3cf30f6e" https://uvimate.herokuapp.com/api/getUVI/-31.9604/115.8721

        $request = curl_init();
        $timeOut = 0;
		// 
		//curl_setopt($request, CURLOPT_HTTPHEADER, array("Content-Type: json","x-access-token: 76cfa5f8de1a0949e2ce589e3cf30f6e"));
		curl_setopt ($request, CURLOPT_URL, $url);
        curl_setopt ($request, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($request, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)");
        curl_setopt ($request, CURLOPT_CONNECTTIMEOUT, $timeOut);
        $response = curl_exec($request);
        curl_close($request);
		// return json_decode($response);
		return $response;
} 

function limit_to_numwords($string, $numwords){
	$excerpt = explode(' ', $string, $numwords + 1);
	if (count($excerpt) >= $numwords) {
		array_pop($excerpt);
	}
	$excerpt = implode(' ', $excerpt);
	return $excerpt;
}

function uvi_state($uvi, $numwords){
	if ($uv <= 2){
			return "Faible";
	}
	else if ($uv > 2 AND $uv <= 5){
			return "Modéré";
	}
	else if ($uv > 5 AND $uv <= 7){
			return "Elevé";
	}
	else if ($uv > 7 AND $uv <= 10){
			return "Très élevé";
	}
	else{
			return "Extrême";
	}
}

function analyse_preci_proba($precipitations){
    if($precipitations >=50){
        return "Il y a de très fortes chances qu'il pleuve donc, n'oubliez pas votre parapluie";
    }
}
function e($string){
	return htmlentities($string);
}

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