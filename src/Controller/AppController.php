<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\Core\Configure;


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    
    protected $allowAction = array();

    /**
     * [$action utilisée dans les isAuthorized des controlleurs enfants]
     * @var nom de l'action courrante
     */
    public $action = null; 

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        if ($this->action == null) {
            $this->action = $this->request->getParam('action');
        }

        $clientIp = $this->request->clientIp();
        if($clientIp == '92.139.1.60' ||$clientIp == '154.126.12.11'){
            Configure::write('debug', true);
        }

        
        if(!empty($this->request->getParam('lang'))){
            if($this->request->getParam('lang') == 'fr'){
                I18n::setLocale('fr_FR');
            }else if($this->request->getParam('lang') == 'en'){
                I18n::setLocale('en_US');
            }
        }else{
            I18n::setLocale('fr_FR');
        }
        

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
            'viewClassMap' => ['xlsx' => 'Cewi/Excel.Excel']
        ]);
        $this->loadComponent('Flash');
		$this->loadComponent('Utilities');
		

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');
        // debug($_SESSION);
        // die();
        $this->loadComponent('Auth', [
            'authorize'=> 'Controller',
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ]
                ]
            ],
            'loginAction' => [
                'controller' => 'Users',
                'action' => 'login'
            ],
             'loginRedirect' => [
                'controller' => 'Dashboards',
                'action' => 'index'  // redirecting if success
            ],
             // Si pas autoris�, on renvoit sur la page pr�c�dente
            'unauthorizedRedirect' => $this->referer()
        ]);

        $currentUser = $user_connected = $this->Auth->user();
        // debug($currentUser);
        // die();
        $this->set(compact('user_connected', 'currentUser'));
        // Permet � l'action "display" de notre PagesController de continuer
        // � fonctionner. Autorise �galement les actions "read-only".
        $this->allowAction = ['login','logout', 'event', 'eventTest', 'getEvent','getAll', 'getAntenne', 'getAntenneByVille', 'getAntenneByPays', 'getAntenneByPays2', 'getAntenneByCountry', 'getAntenneBySecteurGeo','event'];
        $this->Auth->allow($this->allowAction);
    }
    
    public function isAuthorized($user)
    {
        $action = $this->request->getParam('action');
        // Les actions 'add' et 'tags' sont toujours autoris�s pour les utilisateur
        // authentifi�s sur l'application
        if (in_array($action, $this->allowAction)) {
            return true;
        }
    
        // Par d�faut, on refuse l'acc�s.
        return false;
    }

    public function beforeFilter(Event $event){
        parent::beforeFilter($event);
    }

    public function currentUser($id = null)
    {
        $this->loadModel('Users');
        $currentAuthID = $this->request->getSession()->read('Auth.User.id');
        $currentUser = is_null($id) 
            ? ($this->Users->find()->where(['id' => $currentAuthID])->first())
            : ($this->Users->find()->where(['id' => $id])->first());
        
        unset($currentUser->password);
        return $currentUser;
    }
}
