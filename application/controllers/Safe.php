<?php

class Safe extends Frontend_Controller {
	public function __construct(){
        parent::__construct();
        $this->load->helper("url");
        $this->load->library("form_validation");
    }

    public function index() {
        
     if (!(isset($_POST["plage"])))
                {
            $this->load->view('accueil');
        }
     else
    {
        $fichier = $_POST['plage'];
        $data['plage'] = $fichier;
 		//Récupérer les données actuelles en fonction de la 
        $alire = file_get_contents(site_url("datas/".$fichier.".json"));
       
       // add_meta_title("Liste des Plages");
        
        $data['nbre_conseils'] = 0;
   //     $i = &$data['nbre_conseils'];
        
        $donnees = json_decode($alire, true);
        foreach ($donnees as $champ => $valeur) {
        // Les variables sont des indices du tableau généré à partir du fichier json
        $data['uvi'] = deriv_uv($valeur["uviData"]["uviMax"]);
        $data['proba_precipitation'] =  $valeur["weather"]["precipProbability"];  
        $data['temperature_min'] =  $valeur["weather"]["temperature_min"];
        $data['temperature_max'] =  $valeur["weather"]["temperature_max"];  
        $data['vit_vent_min'] =  $valeur["weather"]["windSpeed_min"];
        $data['vit_vent_max'] =  $valeur["weather"]["windSpeed_max"];
        $data['vague_min'] =  $valeur["weather"]["wave_min"];
        $data['vague_max'] =  $valeur["weather"]["wave_max"];
        $data['temp_eau'] =  $valeur["weather"]["temperature_water"];
         
         //Conseils
         //Uvi
        $data['conseil_uvi'] = get_uv_conseil($data['uvi']);
        $data['nbre_conseils']++;
        
        //On récupère les conseils en fonction de l'heure. S'il n'y en a pas, on n'incrémente pas $nbre_conseils
       $data['conseil_temps'] = temp_conseil();
        if(!(is_null($data['conseil_temps']))){
            $data['nbre_conseils']++; 
        } 
        $data['proba_precipitation'] = analyse_preci_proba($data['proba_precipitation']);
        if(!(is_null($data['proba_precipitation']))){
            $data['nbre_conseils']++;  
        } 
        
        $this->load->view('super', $data);
        //echo "Nous avons au total <strong>".$this->data['nbre_conseils']."</strong> pour vous:<br/><ul><li>Valeur de l'UVI: <strong>".$this->data['uvi']." ->".get_uv_conseil($this->data['uvi'])."</li></strong></li></ul>";
}

                }
		
	}
    
    public function prevision($fichier = "cadjehoun", $heure) {
		//Récupérer les données actuelles en fonction de la 
        $alire = file_get_contents(site_url('datas/'.$fichier.".json"));
        
        $dangerosite = 0;
        
        $donnees = json_decode($alire, true);
        foreach ($donnees as $field => $value) {
    // Les variables sont des indices du tableau généré à partir du fichier json
        $uvi = deriv_uv($value["uviData"]["uviMax"]);                                                              
       //dump(deriv_uv($uvi)); 
       
        echo get_uv_conseil($uvi);
        
        
}
		
	}
}