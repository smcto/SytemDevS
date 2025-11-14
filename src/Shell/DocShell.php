<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Chronos\Chronos;
use Cake\ORM\TableRegistry;

/**
 * Doc shell command.
 */
class DocShell extends Shell
{
    public function initialize(array $config = [])
    {
        parent::initialize($config);
        $this->loadModel('Devis');
        $this->loadModel('DevisFactures');
    }

    /**
     * dans crontab
     * @param  string $doctype [description]
     */
    public function majStatut($doctype = 'devis')
    {
        if ($doctype == 'devis') {
            $devis = $this->Devis->find()->where([
                'date_sign_before <' => date('Y-m-d'),
                'status IN' => ['draft', 'expedie', 'error', 'blocked', 'spam', 'sent', 'lu', 'open', 'clicked']
            ]);

            foreach ($devis as $key => $devi) {
                $this->out('maj id : '.$devi->id);
                $devi = $this->Devis->patchEntity($devi, ['status' => 'expired'], ['validate' => false]);
                if ($this->Devis->save($devi)) {
                    $this->out('maj id : '.$devi->id);
                }
            }
        }
        $this->out('fin');
    }


    public function majFacturesRetard()
    {
        $now = Chronos::now();

        $devisFactures = $this->Devis->DevisFactures
            ->find()
            ->contain(['DevisFacturesEcheances'])
            ->where(['delai_reglements IN' => ['commande', 'reception', '30j', '15j', '60j', '90j', '120j', 'echeances'], 'status NOT IN' => ['canceled', 'paid', 'draft']])
            // ->where(['status' => 'partial-payment', 'delai_reglements' => 'echeances'])
            ->order(['DevisFactures.id' => 'DESC'])
            // ->limit(1)
            // ->where(['DevisFactures.id' => 3653])
        ;

        $dataRetard = [
            'status' => 'delay',
            'date_prevu_echeance' => Chronos::now()->addDay(-1)
        ];

        foreach ($devisFactures as $devisFacture) {

            $diffJours = $now->diffInDays($devisFacture->date_crea);

            // retard => date de facturation + 15 jours
            if ($devisFacture->delai_reglements == 'reception' && $devisFacture->date_crea < $now && $diffJours > 15) {
                $devisFacture = $this->DevisFactures->patchEntity($devisFacture, $dataRetard, ['validate' => false]);
                $this->DevisFactures->save($devisFacture);
                $this->out('saved num :'.$devisFacture->indent.', delai reception');
            }

            // retard => date de facturation + 8 jours
            else if ($devisFacture->delai_reglements == 'commande' && $devisFacture->date_crea < $now && $diffJours > 8) {
                $devisFacture = $this->DevisFactures->patchEntity($devisFacture, $dataRetard, ['validate' => false]);
                $this->DevisFactures->save($devisFacture);
                $this->out('saved num :'.$devisFacture->indent.', delai commande');
            }

            // paiement "à 30 jours" ou "60 jours" etc..

            else if ( in_array($devisFacture->delai_reglements, ['30j', '15j', '60j', '90j', '120j']) && $devisFacture->date_crea < $now) {

                $delaiInt = (int) $devisFacture->delai_reglements;
                
                if ($diffJours > $delaiInt+1) {
                    $devisFacture = $this->DevisFactures->patchEntity($devisFacture, $dataRetard, ['validate' => false]);
                    $this->DevisFactures->save($devisFacture);
                    $this->out('saved num :'.$devisFacture->indent.', delai jours');

                }
            }
    
            // retard => date de la prochaine échéance à régler + 1 jours
            else if ($devisFacture->delai_reglements == 'echeances') {
                $prochaineEcheance = collection($devisFacture->devis_factures_echeances ?? [])->firstMatch(['is_payed' => 0]);
                if ($prochaineEcheance) {
                    $prochaineEcheanceDate = $prochaineEcheance->date;

                    $diffJours = $now->diffInDays($prochaineEcheanceDate);

                    if ($prochaineEcheanceDate < $now && $diffJours+1) {

                        $devisFacture = $this->DevisFactures->patchEntity($devisFacture, $dataRetard, ['validate' => false]);
                        $this->DevisFactures->save($devisFacture);
                        $this->out('saved num :'.$devisFacture->indent.', delai prochaine_echeance');
                    }
                }
            }
        }
    }

    public function majRetard()
    {
        $devisFactures = $this->Devis->DevisFactures
            ->find()
            ->contain(['DevisFacturesEcheances', 'FactureReglements'])
            ->where(['status' => 'delay', 'delai_reglements' => 'echeances'])
            ->order(['DevisFactures.id' => 'DESC'])
            // ->limit(1)
            // ->where(['DevisFactures.id' => 3612])
        ; 


        foreach ($devisFactures as $key => $devisFacture) {
            $paidEcheances = collection($devisFacture->devis_factures_echeances ?? [])->match(['is_payed' => 1])->count();
            
            if ($paidEcheances == 1) {
                $devisFacture = $this->DevisFactures->patchEntity($devisFacture, ['status' => 'partial-payment'], ['validate' => false]);
                $this->DevisFactures->save($devisFacture);
                $this->out('saved num :'.$devisFacture->indent.', reglement partiel');
            }
        }
    }

    public function majRetardPaid()
    {
        $devisFactures = $this->Devis->DevisFactures
            ->find()
            ->contain(['DevisFacturesEcheances', 'FactureReglements'])
            ->where(['status' => 'delay'])
            ->order(['DevisFactures.id' => 'DESC'])
            // ->limit(1)
            // ->where(['DevisFactures.id' => 3612])
        ; 

        foreach ($devisFactures as $key => $devisFacture) {
            if ($devisFacture->get('ResteEcheanceImpayee') == 0) {
                $devisFacture = $this->DevisFactures->patchEntity($devisFacture, ['status' => 'paid'], ['validate' => false]);
                $this->DevisFactures->save($devisFacture);
                $this->out('saved num :'.$devisFacture->indent.', paid');
            }
        }
    }

    public function majDevisFacturesMontantLie()
    {
        $this->loadModel('ReglementsHasDevisFactures');
        $reglementsHasDevisFactures = $this->ReglementsHasDevisFactures->find()->where(['devis_factures_id >' => 0])->contain(['Reglements']);
        foreach ($reglementsHasDevisFactures as $key => $reglementsHasDevisFacture) {
            $date = $reglementsHasDevisFacture->reglement->date;
            $r = $this->ReglementsHasDevisFactures->patchEntity($reglementsHasDevisFacture, ['created' => $date], ['validate' => false]);
            $r = $this->ReglementsHasDevisFactures->save($r);
            $this->out('maj id : '.$r->id);
        }
    }

    /**
     * en dev local perso seulement; 
     * @return [type] [description]
     */
    public function allegerLocalDocs()
    {
        $devisTable = TableRegistry::get('Devis');
        $listeDevis = $devisTable->find()->where(['status IN' => ['expired', 'draft', 'sent', 'clicked', 'open', 'lu', 'expedie']]);
        foreach ($listeDevis as $key => $devis) {
            $devisTable->delete($devis);
        }
    }
}
