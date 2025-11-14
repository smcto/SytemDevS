<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Chronos\Chronos;
use App\Traits\AppTrait;
use \Mailjet\Resources;

class ReglementsShell extends Shell
{
    
    /**
     * Start the shell and interactive console.
     *
     * @return int|null
     */
    public function main()
    {
        $this->out('Choisir la methode à lancer');
    }

    public function updateBank() {
        
        $this->loadModel('Reglements');
        $reglements = $this->Reglements->find('all')->where(['user_id is null']);
        foreach ($reglements as $reglement) {
            $reglement = $this->Reglements->patchEntity($reglement, ['info_bancaire_id' => 2], ['validate' => false]);
            $this->Reglements->save($reglement);
            $this->out($reglement->id);
            $this->out('Reglements enregistré');
        }
    }
    
    
    public function updateMontantLie() {
        
        $this->loadModel('Reglements');
        $reglements = $this->Reglements->find('all')->contain(['ReglementsHasDevisFactures' => function ($q) {
            return $q->where(['ReglementsHasDevisFactures.montant_lie is null']);
        }]);
        $i = 0;
        foreach ($reglements as $reglement) {
            
            if (count($reglement->reglements_has_devis_factures) == 1) {
                $i++;
                $this->out("reglement id : " . $reglement->id);
                
                $reglementFacture = $reglement->reglements_has_devis_factures[0];
                $reglementFacture = $this->Reglements->ReglementsHasDevisFactures->patchEntity($reglementFacture, ['montant_lie' => $reglement->montant]);
                $this->Reglements->ReglementsHasDevisFactures->save($reglementFacture);
            }
        }
        
    }
}
