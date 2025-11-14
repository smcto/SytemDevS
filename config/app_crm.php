<?php return [
    // Compte
    'typeProfilKonitys' => [1, 2, 3, 10, 11, 12],
    "roles" => ["admin", 'projet', 'finance', 'logistique', 'commercial', 'compta'],
    'niveau_info' => ['expert'=>'Expert', 'bonnes_connaissances'=>'Bonnes connaissances', 'moyen'=>'Moyen', 'debutant'=>'Débutant'],
    'source' => ['ami'=>'Ami','famille'=>'Famille','reseaux_pro'=>'Réseaux pro', 'reseaux_sociaux'=>'Réseaux sociaux','prospection'=>'Prospection','autre'=>'Autres'],
    // Form vente
    'nbMois' => ['36' => '36 Mois', '24' => '24 Mois', '18' => '18 Mois'],
    'nbMoisLongueDurees' => ['12' => '1 an', '18' => '18 mois'],
    'is_agency' => [1 => 'Oui', 0 => 'Non'],
    'is_agency_template' => [1 => 'Oui', 0 => '-'],
    'yes_or_no' => [1 => 'Oui', 0 => 'Non'], // affiché dans liste déroulante vente/étape
    'yes_or_no_template' => [1 => 'Oui', 0 => '-'], // affiché dans vue vente/recap ou fiche
    'facturation_achat_type' => [0 => 'Facturer le client', 1 => 'Facturer une autre entité'],
    'entity_jurids' => ['client' => 'Client', 'grenke' => 'Grenke', 'leasecom' => 'Leasecom', 'autre' => 'Autres'],
    'vente_statut' => ['en_attente' => 'Attente de traitement', 'en_prepa' => 'En cours de préparation', 'pret_exp' => 'Prête à expédier', 'expedie' => 'Expédiée'],
    'vente_statut_couleur' => ['en_attente' => 'text-secondary', 'en_prepa' => 'text-danger', 'pret_exp' => 'text-success', 'expedie' => 'text-primary'],
    'vente_etat_facturation' => ['accompte_regle' => 'Accompte réglé', 'regelement_ok' => 'Réglement ok', 'accompte_attente' => 'Attente règlement acompte', 'facturation_envoyee' => 'Facture envoyée', 'attente_facturation' => 'Attente facturation' ],
    'livraison_type_date' => ['aussitot' => 'Dès que possible', 'client' => 'À définir avec le client', 'precis' => 'Date précise'],

    // Form vente consommable
    'vente_etat_consommable' => ['en_attente_traitement' => 'En attente de traitement', 'en_cours_prepa' => 'En cours de préparation', 'expedie_partiel' => 'Commande expédiée partiellement', 'expedie' => 'Commande expédiée', 'annule' => 'Commande annulée' ],
    'vente_etat_consommable_couleur' => ['en_attente_traitement' => 'text-dark', 'en_cours_prepa' => 'text-success', 'expedie' => 'text-primary', 'expedie_partiel'=> 'text-warning', 'annule' => 'text-danger'],
    'vente_consommable_etat_facturation' => ['en_cours_traitement' => 'Attente de traitement', 'accompte_regle' => 'Accompte réglé', 'regelement_ok' => 'Réglement ok', 'accompte_attente' => 'Attente règlement acompte', 'facturation_envoyee' => 'Facture envoyée', 'attente_facturation' => 'Attente facturation' ],
    
    // chart
    'colors' => ['#01caf1','#ff4f70','#22ca80','#b022ca','#dee92f','#ca2287','#b8ca22','#5f76e8'],

    // Clients
    'genres' => ['corporation' => 'Professionnel', 'person' => 'Particulier'],
    'genres_short' => ['corporation' => 'Pro', 'person' => 'Part'],
    'type_commercials' => ['client' => 'Client', 'prospect' => 'Prospect'],
    'type_commercials_short' => ['client' => 'Client', 'prospect' => 'Prosp'],
    'connaissance_selfizee' => ["internet" => "Site internet", "ami" => "Recommandation d'un ami / contact", "evenement" => "Découvert lors d'un événement", "salon" => "Salon", "rencontre" => "Rencontre avec quelqu'un de notre équipe", "reseaux_sociaux" => "Réseaux sociaux", "recommendation" => "Recommandation partenaire professionnel", "doc" => "Document pub papier", "autre" => "Autre"],
    'filtres_contrats' => [
        'is_brandeet' => 'Brandeet',
        'is_digitea' => 'Digitea',
        'is_location_event' => 'Location Event',
        'is_location_financiere' => 'Location financière',
        'is_location_lng_duree' => 'Loc Longue Durée',
        'is_borne_occasion' => 'Borne d\'occasion',
        'is_selfizee_part' => 'Selfizee part',
        'is_vente' => 'Vente',
    ],

    // Devis et factures
    'moyen_reglements' => ['cheque' => 'Chèque', 'virement' => 'Virement bancaire', 'prelevement' => 'Prélèvement', 'carte' => 'Carte bancaire', 'especes' => 'Espèces', 'billet' => 'Billet à ordre relevé'],
    'delai_reglements' => ['commande' => 'à la commande', '30j' => 'à 30 jours', '15j' => 'à 15 jours', '60j' => 'à 60 jours','90j' => 'à 90 jours','120j' => 'à 120 jours', 'reception' => 'A réception de facture', 'echeances' => 'Plusieurs échéances', 'prelevement_trim' => 'Prélèvement trimestriel', 'prelevement_sem' => 'Prélèvement semestriel', 'prelevement_an' => 'Prélèvement annuel'],
    'periodes' => ['current_month' => 'Ce mois-ci', 'last_month' => 'Le mois dernier', 'list_month' => 'Mois', 'current_year' => 'Cette année', 'last_year' => "L'année dernière", 'custom_threshold' => 'Période personnalisée'],
    'categorie_tarifaire' => ['ht' => 'Tarif HT - document HT', 'ttc' => 'Tarif TTC - document TTC'],
    'devis_adresse_defaut' => ' Sas Konitys <br> 2 Place Konrad Adenauer <br> 22 190 Plérin <br><br>',
    
    // Devis
    // NE PAS CHANGER L'ORDER CAR JE CALCULE L'UPDATE AUTO DEPUIS MAILJET EN FONCTION DE L'ORDRE POUR EVITER QUE MAILJET UPDATE UN DEVIS paid VERS draft PAR EXEMPLE
    'devis_status' => [
        'draft' => 'Brouillon',
        'expedie' => 'Mail expédié',
        'error' => 'Erreur',
        'blocked' => 'Bloqué',
        'spam' => 'Spam',
        'relance' => 'Relancé',
        'sent' => 'Envoyé', 
        'lu' => 'Lu', 
        'open' => 'Ouvert', 
        'clicked' =>'Cliqué',
        'accepted' => 'Accepté', 
        'acompte' => 'Acompte', 
        'canceled' => 'Annulé' , 
        'expired' => 'Expiré', 
        'billing' => 'À facturer', 
        'billed' => 'Facturé', 
        'partially_billed' => 'Partiellement facturé', 
        'refused' => 'Refusé', 
        'paid' => 'Payé', 
        'partially_paid' => 'Règlement partiel', 
        'delay' => 'Retard'
    ],
    // 'expedie' => 'Expédié', 'done' => 'Validé', 'paid' => 'Payé', ], // classe dynamique ex: .draft, .expedie, etc
    'type_bornes' => ['classik' => 'Classik', 'spherik' => 'Sphérik'],
    'type_prelevements' => ['trimestriel' => 'Trimestriel', 'semestriel' => 'Semestriel', 'annuel' => 'Annuel'],

    // Factures
    'devis_factures_status' => ['draft' => 'Brouillon', 'fix' => 'A régler', 'partial-payment' => 'Paiement partiel', 'paid' => 'Payée', 'delay' => 'Retard', 'canceled' => 'Annulé', 'relance' => 'Relancé',],
    'facture_situations_status' => ['draft' => 'Brouillon', 'fix' => 'A régler', 'partial-payment' => 'Paiement partiel', 'paid' => 'Payée', 'delay' => 'Retard', 'canceled' => 'Annulé'],
    'devis_factures_progression' => ['en_retard' => 'En retard', 'relance1' => 'Relance 1', 'relance2' => 'Relance 2', 'relance3' => 'Relance 3', 'lr' => 'LR', 'injonction' => 'Injonction'],

    // Avoirs
    'devis_avoirs_status' => ['draft' => 'Brouillon', 'fix' => 'A solder', 'partial-payment' => 'Partiel', 'paid' => 'Soldé', 'canceled' => 'Annulé', 'relance' => 'Relancé',],
    

    // reglement 
    'type_reglement' => ['credit' => 'Crédit', 'debit' => 'Débit'],
    //'etat_reglement' => ['confirmed' => 'Confirmé'],
    'etat_reglement' => ['draft'=>'Brouillon','validate' => 'Validé','confirmed' => 'Confirmé'],
    
    // paiement stripe
    'api_key' => [
//        'dev' => [
//            'public' => 'pk_test_yvF9kIFglZ4bnaJD7e3HamMQ009m18ry7r',
//            'secret' => 'sk_test_9xPUtJOazWTEmAOPtI4EXDcQ00cIi1E40K'
//        ],
        'dev' => [
            'public' => 'pk_test_TYooMQauvdEDq54NiTphI7jx',
            'secret' => 'sk_test_4eC39HqLyjWDarjtT1zdp7dc'
        ],
        'prod' => [
            'public' => 'pk_live_lXWlGRA7678YVO79S7GAabem',
            'secret' => 'sk_live_TIznVVFdv4sXL2n69NWJWsRH'
        ],
    ],

    // Produit
    'types' => ['is_pro' => 'Professionnel', 'is_particulier' => 'Particulier'],
    'accompte_unities' => ['%' => '%', '€' =>'€'],
    'url_payement' => 'booking.selfizee.fr',
    'https_payement' => 'https://booking.selfizee.fr',
    //'all_url_domaine' => '*.konitys.mg'
    
    // contact
    'civilite' => ['M' => 'M', 'Mme' => 'Mme', 'Mlle' => 'Mlle'],

    // bornes
    'garantie_durees' => [
        '12_mois' => '12 Mois',
        '18_mois' => '18 Mois',
        '24_mois' => '24 Mois',
        '36_mois' => '36 Mois',
    ],

    // objectifs commerciaux
    'annees' => [
        '2025' => '2025',
        '2024' => '2024', 
        '2023' => '2023', 
        '2022' => '2022', 
        '2021' => '2021', 
        '2020' => '2020', 
        '2019' => '2019', 
        '2018' => '2018', 
        '2017' => '2017', 
        '2016' => '2016', 
    ],
    'mois' => ['janvier' => 'Janvier', 'fevrier' => 'Fevrier', 'mars' => 'Mars', 'avril' => 'Avril', 'mai' => 'Mai', 'juin' => 'Juin', 'juillet' => 'Juillet', 'aout' => 'Août', 'septembre' => 'Septembre', 'octobre' => 'Octobre', 'novembre' => 'Novembre', 'decembre' => 'Décembre', ],
    
    // BC
    'type_date' => ['1' => 'Le plus tôt possible', '2' => 'à définir avec le client', '3' => 'date précise'],
    // BP
    'statut_ligne' => ['complet' => 'Complet', 'incomplet' => 'Incomplet', 'attente_traitement' => 'En attente de traitement'],
    'bp_statut' => ['en_attente' => 'Attente de traitement', 'en_prepa' => 'En cours de préparation', 'pret_exp' => 'Prête à expédier', 'expedie' => 'Expédiée'],

    // Stock
    'etat_stock' => ['Neuf' => 'Neuf', 'Occasion' => 'Occasion', 'A réparer' => 'A réparer','Hs' => 'Hs', 'rebus' => 'Rebus']
];
