<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Mailer\Email;
use Cake\Mailer\Transport\DebugTransport;
use Cake\Core\Configure;

/**
 * Emails Model
 *
 * @property \App\Model\Table\EmailsHasUsersTable|\Cake\ORM\Association\HasMany $EmailsHasUsers
 *
 * @method \App\Model\Entity\Email get($primaryKey, $options = [])
 * @method \App\Model\Entity\Email newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Email[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Email|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Email|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Email patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Email[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Email findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class EmailsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('emails');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('EmailsHasUsers', [
            'foreignKey' => 'email_id'
        ]);

        $this->belongsToMany('Expediteurs', [
            'className' => 'Users',
            'through' => 'EmailsHasUsers',
            'joinTable' => 'emails_has_users',
            'targetForeignKey' =>'user_id',
            'foreignKey' => 'email_id',
            'conditions' => ['EmailsHasUsers.is_expediteur' => true]
        ]);

        $this->belongsToMany('Destinateurs', [
            'className' => 'Users',
            'through' => 'EmailsHasUsers',
            'joinTable' => 'emails_has_users',
            'targetForeignKey' =>'user_id',
            'foreignKey' => 'email_id',
            'conditions' => ['EmailsHasUsers.is_destinateur' => true]
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('objet')
            ->maxLength('objet', 255)
            ->allowEmpty('objet');

        $validator
            ->scalar('contenu')
            ->allowEmpty('contenu');

        $validator
            ->boolean('is_sent')
            ->allowEmpty('is_sent');

        return $validator;
    }

    /**
     * 
     * @param  [type] $data    [description]
     * @param  [type] $options test si non specifié à false n'envoie pas d'email
     * @return [type]          [description]
     */
    public  function sendTo($data, $options = null, $attachmentsOptions = null)
    {
        $email = new Email();
        // $options['test'] = true; // en debug, force l'envoi à non si test à true

        if (!isset($options['test']) || $options['test'] == false) {
            if (!isset($options['transport'])) {
                $email->setTransport('mailjet');
            } else {
                $email->setTransport($options['transport']);
            }
        } else {
            $transport = new DebugTransport();
            $email->transport($transport);
        }

        $fromEmail = $options['fromEmail'];
        $additional_headers = ['From' => $fromEmail, 'Content-type' => 'multipart/mixed; charset=iso-8859-1', 'MIME-Version' => '1.0', 'Return-Path' => $fromEmail, 'X-Priority' => 3, 'X-Mailer' => "PHP", ];

        $template = !isset($options['template']) ? 'send' : $options['template'];
        $layout = !isset($options['layout']) ? 'default' : $options['layout'];

        $emails = $data['email'];

        if(is_array($emails)){
            $emails = array_unique($emails);
        }

        $email
            ->setTo($emails)
            ->setFrom([$fromEmail => $options['from']])
            // ->setSender('erwan.lesolleu@ventdouest-impression.fr', 'Erwan')
            // ->AddHeaders($additional_headers)
            ->setSubject($options['subject']);
            
        if (!empty($attachmentsOptions)) {
            $email->setAttachments($attachmentsOptions);
        }

        if (isset($data['bcc']) && !empty($data['bcc'])) {
            $bcc = $data['bcc'];
            if(is_array($bcc)){
                $bcc = array_unique($bcc);
            }
            $email->setBcc($bcc);
        }
        
        if (isset($options['message'])) {
            return $email->send($options['message']) ? true : false;
        }

        $email
            ->emailFormat('html')
            ->setTemplate($template)
            ->setLayout($layout)
            ->viewVars($data)
        ;

        // echo $email->getViewVars()['signature'];
        if($email = $email->send())
        {
            return $email;
        }
    }

}
