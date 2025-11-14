<?php

namespace App\Shell;

use Cake\Console\Shell;

class OppShell extends Shell
{
    public function staffsToUser(){
        //die;
        $this->loadModel('Opportunites');
        $this->loadModel('Users');
        $this->loadModel('OpportuniteUsers');
        $opportunites = $this->Opportunites->find()->contain(['Staffs']);
        foreach ($opportunites as $opportunite) {
            foreach($opportunite->staffs as $staff){
                $user = $this->Users->find()->where(['email'=>$staff->email])->first();
                //debug($user);
                if(!empty($user)){
                    $data['user_id'] = $user->id;
                    $data['opportunite_id'] = $opportunite->id;
                    $isRelationExiste = $this->OpportuniteUsers->find()->where($data)->first();
                    if(empty($isRelationExiste)){
                        $oppUser = $this->OpportuniteUsers->newEntity($data);
                        if($this->OpportuniteUsers->save($oppUser)){
                            $this->out('Relatin saved');
                        }
                    }
                }
            }
        }
    }

    public function commentaireOpportunite()
    {   
        $this->loadModel('OpportuniteCommentaires');
        $this->loadModel('Users');
        $commentaires = $this->OpportuniteCommentaires->find()
                                                ->contain(['Staffs'])
                                                ->where(['user_id IS' => NULL]);
        foreach($commentaires as $commentaire){
            $user = $this->Users->find()
                            ->where(['email'=>$commentaire->staff->email])
                            ->first();
            if(!empty($user)){
                $commentaire->user_id = $user->id;
                if($this->OpportuniteCommentaires->save($commentaire)){
                    $this->out('Save user commentaire');
                }
            }
        }
    }

}