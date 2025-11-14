<?php
    $eventsList = [];
    $clientType = ['corporation'=>'Professionel' , 'person'=>'Particulier' ];
    if(!empty($events)){
        foreach($events as $key => $event){
            $nom_event = $event->evenement->nom_event;
            $lieu_event = $event->evenement->lieu_exact;
            $nom_client = $event->evenement->client->full_name;
            $type_client = $clientType[$event->evenement->client->client_type];
            $type_event = $event->evenement->type_evenement->nom;
            $type_animation = $event->evenement->type_animation->nom;
            $ev ['id'] = $event->id;
            $ev ['date_debut'] = $event->date_debut->format('Y-m-d');
            $ev ['date_fin'] = $event->date_fin->format('Y-m-d');


            $ev ['nom_event'] = $nom_event;
            $ev ['lieu_event'] = $lieu_event;
            $ev ['nom_client'] = $nom_client;
            $ev ['type_client'] = $type_client;

            $bg = "";
            if($type_animation == "Selfizee" ){
                $bg = "#eb115f";
            } else if($type_animation == "Brandeet" ){
                $bg = "#eb5a46";
            } else if($type_animation == "Digitea" ){
                $bg = "#026aa7";
            }
            //$ev ['title'] = "<div style="text-align: left;">".$nom_event." - ".$lieu_event."<br>".$nom_client." - ".$type_client."</div>";
            $ev ['title'] = $nom_event." - ".$lieu_event." ".$nom_client." - ".$type_client;
            $ev ['start'] = $event->date_debut->format('Y-m-d')." 00:00";
            $ev ['end'] = $event->date_fin->format('Y-m-d')." 23:59:59";
            $ev ['backgroundColor'] = $bg;

            //===== Periode Immobilisation
            $periode_immobilisation ['nom_event'] = 'Periode immobilisation ( '.$nom_event.' )';
            $periode_immobilisation ['lieu_event'] = "";
            $periode_immobilisation ['nom_client'] = "";
            $periode_immobilisation ['type_client'] = "";
            $periode_immobilisation ['title'] = 'Periode immobilisation';
            $periode_immobilisation ['start'] = $event->evenement->date_debut_immobilisation->format('Y-m-d')." 00:00";
            $periode_immobilisation ['end'] = $event->evenement->date_fin_immobilisation->format('Y-m-d')." 23:59:59";
            $periode_immobilisation ['backgroundColor'] = '#000';

        $eventsList [] = $ev;
        $eventsList [] = $periode_immobilisation;
        }
    }
    echo json_encode($eventsList);
?>