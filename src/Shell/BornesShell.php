<?php

namespace App\Shell;

use Cake\Console\Shell;
use Cake\Chronos\Chronos;
use App\Controller\Component\SpreadSheetComponent;
use Cake\Controller\ComponentRegistry;
use App\Traits\AppTrait;
use \Mailjet\Resources;

class BornesShell extends Shell {

    /**
     * Start the shell and interactive console.
     *
     * @return int|null
     */
    public function main() {
        $this->out('Choisir la methode à lancer');
    }

    public function genererNumSerie() {

        $this->loadModel('Bornes');
        $bornes = $this->Bornes->find('all')->contain(['ModelBornes' => 'GammesBornes'])->order(['sortie_atelier' => 'ASC', 'numero' => 'ASC']);
        $annee = 0;
        $semaine = '';
        $i = 1;
        foreach ($bornes as $borne) {
            if ($borne->sortie_atelier) {

                $this->out($borne->id);
                $this->out($borne->sortie_atelier->format('Y-m-d'));
                $date = Chronos::parse($borne->sortie_atelier->format('Y-m-d'));

                if ($date->format('y') != $annee) {
                    $semaine = $date->format('W');
                    $annee = $date->format('y');
                    $i = 1;
                } elseif ($semaine != $date->format('W')) {
                    $semaine = $date->format('W');
                    $i = 1;
                } else {
                    $i++;
                }

                $gamme = @$borne->model_borne->gammes_borne->notation;

                $numSerie = "$gamme$annee$semaine" . sprintf("%02d", $i);

                $borne = $this->Bornes->patchEntity($borne, ['numero_serie' => $numSerie], ['validate' => false]);
                $this->Bornes->save($borne);
                $this->out('Borne enregistré');
            }
        }
    }

    public function updateTarif() {

        $this->loadModel('Bornes');
        $this->loadModel('LotProduits');
        $this->loadModel('EquipementBornes');
        $bornes = $this->Bornes->find('all')->contain(['ModelBornes' => 'GammesBornes', 'EquipementBornes' => ['Equipements', 'NumeroSeries' => 'LotProduits']]);

        foreach ($bornes as $borne) {

            $gamme_id = @$borne->model_borne->gamme_borne_id;

//            if ($gamme_id == 2) {
//
//                $this->out($borne->id);
//
//                if ($borne->equipement_bornes) {
//                    
//                    $defaultEquipements = [1=> 2, 2=> 11, 3=>23, 4=>12, 7=>47,8=>20, 12=>51, 22=>105];
//                    $prixEquipements = [1=> 790, 2=> 350, 3=>451, 4=>345, 7=>180,8=>20, 12=>1130, 22=>25];
//
//                    foreach ($borne->equipement_bornes as $equipement) {
//
//                        unset($defaultEquipements[$equipement->type_equipement_id]);
//                        $data = [];
//
//                        if ($equipement->numero_series !== null) {
//
//                            if ($equipement->numero_series->lot_produit) {
//
//                                if (!$equipement->numero_series->lot_produit->tarif_achat_ht) {
//
//                                    $lotProduit = $equipement->numero_series->lot_produit;
//
//                                    if ($equipement->equipement_id == 106) {
//                                        $data['tarif_achat_ht'] = 41;
//                                    }
//                                    if ($equipement->equipement_id == 105) {
//                                        $data['tarif_achat_ht'] = 25;
//                                    }
//                                    if ($equipement->equipement_id == 12) {
//                                        $data['tarif_achat_ht'] = 345;
//                                    }
//                                    if ($equipement->equipement_id == 18) {
//                                        $data['tarif_achat_ht'] = 386;
//                                    }
//                                    if ($equipement->type_equipement_id == 8) {
//                                        $data['tarif_achat_ht'] = 146;
//                                    }
//                                    if ($equipement->type_equipement_id == 2) {
//                                        $data['tarif_achat_ht'] = 350;
//                                    }
//                                    if ($equipement->type_equipement_id == 3) {
//                                        $data['tarif_achat_ht'] = 451;
//                                    }
//                                    if ($equipement->type_equipement_id == 7) {
//                                        $data['tarif_achat_ht'] = 180;
//                                    }
//                                    if ($equipement->type_equipement_id == 1) {
//                                        $data['tarif_achat_ht'] = 790;
//                                    }
//
//                                    $lotProduit = $this->LotProduits->patchEntity($lotProduit, $data, ['validate' => false]);
//                                    $this->LotProduits->save($lotProduit);
//                                    $this->out('update produit ' . $lotProduit->id);
//                                }
//                            } else {
//
//                                $lotProduit = $this->LotProduits->newEntity();
//
//                                $data['equipement_id'] = $equipement->equipement_id;
//                                $data['type_equipement_id'] = $equipement->type_equipement_id;
//                                $data['etat'] = 'Neuf';
//                                $data['quantite'] = 1;
//                                $data['serial_nb'] = $equipement->numero_series->serial_nb;
//
//                                if ($equipement->equipement_id == 106) {
//                                    $data['tarif_achat_ht'] = 41;
//                                }
//                                if ($equipement->equipement_id == 105) {
//                                    $data['tarif_achat_ht'] = 25;
//                                }
//                                if ($equipement->equipement_id == 12) {
//                                    $data['tarif_achat_ht'] = 345;
//                                }
//                                if ($equipement->equipement_id == 18) {
//                                    $data['tarif_achat_ht'] = 386;
//                                }
//                                if ($equipement->type_equipement_id == 8) {
//                                    $data['tarif_achat_ht'] = 146;
//                                }
//                                if ($equipement->type_equipement_id == 2) {
//                                    $data['tarif_achat_ht'] = 350;
//                                }
//                                if ($equipement->type_equipement_id == 3) {
//                                    $data['tarif_achat_ht'] = 451;
//                                }
//                                if ($equipement->type_equipement_id == 7) {
//                                    $data['tarif_achat_ht'] = 180;
//                                }
//                                if ($equipement->type_equipement_id == 1) {
//                                    $data['tarif_achat_ht'] = 790;
//                                }
//
//                                $lotProduit = $this->LotProduits->patchEntity($lotProduit, $data, ['validate' => false]);
//                                if ($this->LotProduits->save($lotProduit)) {
//                                    
//                                    $numero_series = $equipement->numero_series;
//                                    $numero_series = $this->LotProduits->NumeroSeries->patchEntity($numero_series, ['lot_produit_id' => $lotProduit->id], ['validate' => false]);
//                                    if ($this->LotProduits->NumeroSeries->save($numero_series)) {
//                                        $this->out('ici creation produit ' . $lotProduit->id);
//                                    }else {
//                                        debug($numero_series->getMessage());
//                                    }
//                                } else {
//                                    debug($lotProduit->getMessage());
//                                }
//                            }
//                        } elseif (! $equipement->precisions) {
//                            
//                            // borne n'a pas produit
//
//                            // equipement par default
//                            $defaultEquipement = [1=> 2, 3=>23, 4=>12, 7=>47,12=>51, 22=>105];
//                            $prixEquipement = [1=> 790, 3=>451, 4=>345, 7=>180, 12=>1130, 22=>25];
//                            $this->addNewEquipementBornes($borne->id, $defaultEquipement[$equipement->type_equipement_id], $equipement->type_equipement_id, $prixEquipement[$equipement->type_equipement_id], $equipement);
//                        }
//                    }
//                    
//                    // importer le reste
//                    if (count($defaultEquipements)) {
//                        
//                        foreach($defaultEquipements as $typeEquipement => $equip) {
//                            $this->addNewEquipementBornes($borne->id, $equip, $typeEquipement, $prixEquipements[$typeEquipement]);
//                        }
//                    }
//                    
//                } else {
//                    // borne n'a pas d'equipement (new import)
//                    
//                    // add structure metallique
//                    $this->addNewEquipementBornes($borne->id, 51, 12, 1130);
//                    // add Porte standard
//                    $this->addNewEquipementBornes($borne->id, 105, 22, 25);
//                    // add ordinateur
//                    $this->addNewEquipementBornes($borne->id, 12, 4, 345);
//                    // add Appareil photo 2000D
//                    $this->addNewEquipementBornes($borne->id, 11, 2, 350);
//                    // add 2094L 
//                    $this->addNewEquipementBornes($borne->id, 23, 3, 451);
//                    // add Appareil photo 2000D
//                    $this->addNewEquipementBornes($borne->id, 2, 1, 790);
//                    // add Bornier Legrand
//                    $this->addNewEquipementBornes($borne->id, 47, 7, 180);
//                    
//                }
//            }

            if ($gamme_id == 3) {

                $this->out($borne->id);
                $this->out('Spherique');

                if ($borne->equipement_bornes) {
                    
                    $defaultEquipement = [4=>16, 6=>58, 11=>21, 12=>52, 13=>53, 14=>54];
                    $prixEquipement = [4=>525, 6=>212, 11=>137, 12=>268, 13=>65, 14=>36];
                            
                    foreach ($borne->equipement_bornes as $equipement) {
                        unset($defaultEquipement[$equipement->type_equipement_id]);
                        $data = [];

                        if ($equipement->numero_series) {

                            if ($equipement->numero_series->lot_produit) {

                                if (!$equipement->numero_series->lot_produit->tarif_achat_ht) {

                                    $lotProduit = $equipement->numero_series->lot_produit;

                                    if ($equipement->equipement_id == 58) {
                                        $data['tarif_achat_ht'] = 212;
                                    }
                                    if ($equipement->equipement_id == 16) {
                                        $data['tarif_achat_ht'] = 525;
                                    }
                                    if ($equipement->equipement_id == 52) {
                                        $data['tarif_achat_ht'] = 268;
                                    }
                                    if ($equipement->equipement_id == 54) {
                                        $data['tarif_achat_ht'] = 36;
                                    }
                                    if ($equipement->type_equipement_id == 11) {
                                        $data['tarif_achat_ht'] = 137;
                                    }
                                    if ($equipement->type_equipement_id == 13) {
                                        $data['tarif_achat_ht'] = 65;
                                    }
                                    if ($equipement->type_equipement_id == 14) {
                                        $data['tarif_achat_ht'] = 36;
                                    }

                                    if ($equipement->type_equipement_id == 1) {
                                        $data['tarif_achat_ht'] = 790;
                                    }
                                    $lotProduit = $this->LotProduits->patchEntity($lotProduit, $data, ['validate' => false]);
                                    $this->LotProduits->save($lotProduit);
                                    $this->out('update produit ' . $lotProduit->id);
                                }
                            } else {

                                $lotProduit = $this->LotProduits->newEntity();

                                $data['equipement_id'] = $equipement->equipement_id;
                                $data['type_equipement_id'] = $equipement->type_equipement_id;
                                $data['etat'] = 'Neuf';
                                $data['quantite'] = 1;
                                $data['serial_nb'] = $equipement->numero_series->serial_nb;

                                if ($equipement->equipement_id == 58) {
                                    $data['tarif_achat_ht'] = 212;
                                }
                                if ($equipement->equipement_id == 16) {
                                    $data['tarif_achat_ht'] = 525;
                                }
                                if ($equipement->equipement_id == 52) {
                                    $data['tarif_achat_ht'] = 268;
                                }
                                if ($equipement->equipement_id == 54) {
                                    $data['tarif_achat_ht'] = 36;
                                }
                                if ($equipement->type_equipement_id == 11) {
                                    $data['tarif_achat_ht'] = 137;
                                }
                                if ($equipement->type_equipement_id == 13) {
                                    $data['tarif_achat_ht'] = 65;
                                }
                                if ($equipement->type_equipement_id == 14) {
                                    $data['tarif_achat_ht'] = 36;
                                }
                                if ($equipement->type_equipement_id == 1) {
                                    $data['tarif_achat_ht'] = 790;
                                }
                                $lotProduit = $this->LotProduits->patchEntity($lotProduit, $data, ['validate' => false]);
                                $this->LotProduits->save($lotProduit);
                                $numero_series = $equipement->numero_series;
                                $numero_series = $this->LotProduits->NumeroSeries->patchEntity($numero_series, ['lot_produit_id' => $lotProduit->id], ['validate' => false]);
                                if ($this->LotProduits->NumeroSeries->save($numero_series)) {
                                    $this->out('creation produit ' . $lotProduit->id);
                                }else {
                                    debug($numero_series->getMessage());
                                }
                            }
                        } elseif (! $equipement->precisions) {
                            
                            // borne n'a pas produit
                            
                            // equipement par default
                            $defaultEquipement = [4=>16, 6=>58, 11=>21, 12=>52, 13=>53, 14=>54];
                            $prixEquipement = [4=>525, 6=>212, 11=>137, 12=>268, 13=>65, 14=>36];
                            $this->addNewEquipementBornes($borne->id, $defaultEquipement[$equipement->type_equipement_id], $equipement->type_equipement_id, $prixEquipement[$equipement->type_equipement_id], $equipement);
                        }
                    }
                    
                    // importer le reste
//                    if (count($defaultEquipement)) {
//                        
//                        foreach($defaultEquipement as $typeEquipement => $equip) {
//                            $this->addNewEquipementBornes($borne->id, $equip, $typeEquipement, $prixEquipement[$typeEquipement]);
//                        }
//                    }
                } else {
                    
//                    // borne n'a pas d'equipement (new import)
//                    
//                    // add structure metallique
//                    $this->addNewEquipementBornes($borne->id, 52, 12, 268);
//                    // add Microsoft Surface go 128go
//                    $this->addNewEquipementBornes($borne->id, 16, 4, 525);
//                    // add Dock
//                    $this->addNewEquipementBornes($borne->id, 21, 11, 137);
//                    // add Anneau lumineux
//                    $this->addNewEquipementBornes($borne->id, 53, 13, 65);
//                    // add 2094L 
//                    $this->addNewEquipementBornes($borne->id, 23, 3, 451);
//                    // add Trépied Berlebach
//                    $this->addNewEquipementBornes($borne->id, 58, 6, 212);
//                    // add Support imprimante
//                    $this->addNewEquipementBornes($borne->id, 54, 14, 36);
                }
            }
        }
    }
    
    public function addNewEquipementBornes($borne_id, $equipement_id, $type_equipement_id, $tarif, $equipement_borne = null) {
        
        if ($equipement_id && $type_equipement_id && $tarif) {
            
            $data['equipement_id'] = $equipement_id;
            $data['type_equipement_id'] = $type_equipement_id;
            $data['etat'] = 'Neuf';
            $data['quantite'] = 1;
            $data['serial_nb'] = '';
            $data['tarif_achat_ht'] = $tarif;

            $lotProduit = $this->LotProduits->newEntity($data, ['validate' => false]);
            if ($this->LotProduits->save($lotProduit)) {

                $data_num_serie = [
                    'serial_nb' => '',
                    'lot_produit_id' => $lotProduit->id,
                    'equipement_id' => $equipement_id,
                    'borne_id' => $borne_id,
                ];
                $numero_series = $this->LotProduits->NumeroSeries->newEntity($data_num_serie, ['validate' => false]);

                if ($this->LotProduits->NumeroSeries->save($numero_series)) {

                    if ($equipement_borne === null) {

                        $equipement_borne = $this->EquipementBornes->newEntity();
                    }
                    $data_metallique = [
                        'equipement_id' => $equipement_id,
                        'type_equipement_id' => $type_equipement_id,
                        'numero_serie_id' => $numero_series->id,
                        'borne_id' => $borne_id
                    ];
                    $equipement_borne = $this->EquipementBornes->patchEntity($equipement_borne,$data_metallique, ['validate' => false]);

                    if ($this->EquipementBornes->save($equipement_borne)) {

                        $this->out('Nouveau enregistrement reussit');
                    }
                }
            }
        }
    }


    public function addNewProtectionBornes($borne_id, $equipement_id, $type_equipement_id, $tarif) {
        
        if ($equipement_id && $type_equipement_id && $tarif) {
            
            $data['equipement_id'] = $equipement_id;
            $data['type_equipement_id'] = $type_equipement_id;
            $data['etat'] = 'Neuf';
            $data['quantite'] = 1;
            $data['serial_nb'] = '';
            $data['tarif_achat_ht'] = $tarif;

            $lotProduit = $this->LotProduits->newEntity($data, ['validate' => false]);
            if ($this->LotProduits->save($lotProduit)) {

                $data_num_serie = [
                    'serial_nb' => '',
                    'lot_produit_id' => $lotProduit->id,
                    'equipement_id' => $equipement_id,
                    'borne_id' => $borne_id,
                ];
                $numero_series = $this->LotProduits->NumeroSeries->newEntity($data_num_serie, ['validate' => false]);

                if ($this->LotProduits->NumeroSeries->save($numero_series)) {

                    $equipement_borne = $this->EquipementsProtectionsBornes->newEntity();

                    $data = [
                        'equipement_id' => $equipement_id,
                        'type_equipement_id' => $type_equipement_id,
                        'numero_serie_id' => $numero_series->id,
                        'borne_id' => $borne_id,
                        'qty' => 1,
                    ];
                    $equipement_borne = $this->EquipementsProtectionsBornes->patchEntity($equipement_borne,$data, ['validate' => false]);

                    if ($this->EquipementsProtectionsBornes->save($equipement_borne)) {

                        $this->out('Nouveau enregistrement reussit');
                    }
                }
            }
        }
    }


    public function addProtectBornesClassik() {

        $this->loadModel('Bornes');
        $this->loadModel('Equipements');
        $this->loadModel('LotProduits');
        $this->loadModel('EquipementsProtectionsBornes');
        $this->SpreadSheet = new SpreadSheetComponent(new ComponentRegistry);
     
        $listBornes = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/Housses_Bornes_2.csv');

        $this->out('Chargement csv...');

        foreach ($listBornes as $i => $ligne) {
            $item = (object) $ligne;
            $numBorne = $item->A;
            $nomEquip1 = $item->B;
            $nomEquip2 = $item->C;
            $nomEquip3 = $item->D;
            
            $prixEquipements = [
                '62' => 227,
                '63' => 129,
                '64' => 99,
                '67' => 29,
                '66' => 35,
            ];
            
            $borne = $this->Bornes->findByNumero($numBorne)->first();
            $this->out($numBorne);
            
            if ($borne) {
                
                $equipement1 = $this->Equipements->findByValeur($nomEquip1)->first();
                
                if ($equipement1) {
                    $this->addNewProtectionBornes($borne->id, $equipement1->id, 15, $prixEquipements[$equipement1->id]);
                }
                
                $equipement2 = $this->Equipements->findByValeur($nomEquip2)->first();
                
                if ($equipement2) {
                    $this->addNewProtectionBornes($borne->id, $equipement2->id, 15, $prixEquipements[$equipement2->id]);
                }
                
                $equipement3 = $this->Equipements->findByValeur($nomEquip3)->first();
                
                if ($equipement3){
                    $this->addNewProtectionBornes($borne->id, $equipement3->id, 15, $prixEquipements[$equipement3->id]);
                }
                
                $this->out('Saved');
            }
        }
    }

    
    
    public function addProtectBornesSpherik() {

        $this->loadModel('Bornes');
        $this->loadModel('Equipements');
        $this->loadModel('LotProduits');
        $this->loadModel('EquipementsProtectionsBornes');
        $this->SpreadSheet = new SpreadSheetComponent(new ComponentRegistry);
     
        $listBornes = $this->SpreadSheet->read(WWW_ROOT.'/uploads/import_csv/Housses_Bornes_Spherik.csv');

        $this->out('Chargement csv...');

        foreach ($listBornes as $i => $ligne) {
            $item = (object) $ligne;
            $numBorne = $item->A;
            $nomEquip1 = $item->B;
            $nomEquip2 = $item->C;
            
            $prixEquipements = [
                '69' => 149,
                '70' => 200,
                '68' => 149,
                '71' => 14,
                '66' => 35,
            ];
            
            $borne = $this->Bornes->findByNumero($numBorne)->first();
            $this->out($numBorne);
            
            if ($borne) {
                
                $equipement1 = $this->Equipements->findByValeur($nomEquip1)->first();
                
                if ($equipement1) {
                    $this->addNewProtectionBornes($borne->id, $equipement1->id, $equipement1->type_equipement_id, $prixEquipements[$equipement1->id]);
                }
                
                $equipement2 = $this->Equipements->findByValeur($nomEquip2)->first();
                
                if ($equipement2) {
                    $this->addNewProtectionBornes($borne->id, $equipement2->id, $equipement1->type_equipement_id, $prixEquipements[$equipement2->id]);
                }
                
                $this->out('Saved');
            }
        }
    }
}
