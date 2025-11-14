<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Datasource\ModelAwareTrait;
use Cake\ORM\TableRegistry;
use Cake\Filesystem\File;
use DateTime;
use DateInterval;
use DatePeriod;


class UtilitiesComponent extends Component
{
    use ModelAwareTrait;

    public $controller;

    public function initialize(array $config = []){
        parent::initialize($config);
        $this->controller = $this->getController();
    }
    
    // Encryption
    function slEncryption($data){
            $key = 1;
            $encryption_key = base64_decode($key);
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
            $encrypted = openssl_encrypt($data, 'aes-256-cbc', $encryption_key, 0, $iv);
            $slEncryption = base64_encode($encrypted . '::' . $iv);

            $slEncryption = base64_encode(base64_encode(base64_encode($data)));

            return $slEncryption;
    }
	
    // Decryption
    function slDecryption($data) {
            $key = 1;
            $encryption_key = base64_decode($key);
            list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
            openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);

            $slDecryption = base64_decode(base64_decode(base64_decode($data)));
            return $slDecryption;
    }

    public function loadModels($models) {
        foreach ($models as $key => $model) $this->controller->loadModel($model);
    }
	
    function logginto($string, $file, $erase = false)
    {
        $filename = ROOT.DS.'logs'.DS.$file.'.log';
        new File($filename, true, 0777);
        if ($erase == true) {
            file_put_contents($filename, "");
        }
        $file = file_get_contents($filename);
        $newContent = date('Y-m-d H:i:s', time()). ' '. print_r($string, true)."\n";
        $content = $newContent.' ' . $file;
        file_put_contents($filename, $content);
    }

    function checkIfColExists(array $options = null) : bool
    {
        $cm = new \Cake\Datasource\ConnectionManager;
        $config = $cm::get('default')->config();
        $bdd = $config['database'];
        $column = $options['column'];
        $table = $options['table'];
        $res = $cm::get('default')->execute("SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '{$bdd}' AND TABLE_NAME = '{$table}' AND COLUMN_NAME='{$column}'");
        return (bool) $res->fetch();
    }

    public function checkPage($entity, $buildedUrl) {
        if (!$entity) {
            $this->Flash->error("Cette page n'existe pas");
            $this->response = $this->redirect($buildedUrl);
            $this->response->send();
            exit();
        }
    }

    public function incrementIndent($lastEntity = null, $prefix = 'DK-', $invoice_number = '00001') {
        $prefix .= date('Ym');
        if ($lastEntity) {
            $lastInvoiceNumber = $lastEntity->indent;
            $arrayIndent = explode('-', $lastEntity->indent);
            $number = end($arrayIndent);
            $number ++;
            $number = sprintf("%05d", $number);
            $invoice_number = $prefix.'-'.$number;
        } else {
            $invoice_number = $prefix.'-'.$invoice_number;
        }

        return $invoice_number;
    } 
    
    public function incrementIndentByMonth($lastEntity = null, $prefix = 'BCK-', $invoice_number = '00001') {
        $prefix .= date('Ym');
        
        if ($lastEntity) {
            $lastInvoiceNumber = $lastEntity->indent;
            $arrayIndent = explode('-', $lastEntity->indent);
            
            if ($arrayIndent[1] ==  date('Ym')) {
                
                $number = end($arrayIndent);
                $number ++;
                $number = sprintf("%05d", $number);
                $indent = $prefix.'-'.$number;
            } else {
                $indent = $prefix.'-'.$invoice_number;
            }
        } else {
            $indent = $prefix.'-'.$invoice_number;
        }

        return $indent;
    } 

    public function incrementNumeroOpportunite(){
        $this->Opportunites = TableRegistry::get('Opportunites');
        $last = $this->Opportunites->find()->orderAsc('numero')->last();
        $numero = 'OPP-00001';
        if($last){
            $lastNumero = $last->numero;
            $ar = explode('-', $lastNumero);
            $number = end($ar);
            $number ++;
            $number = sprintf("%05d", $number);
            $numero = 'OPP-'.$number;
        }
        return $numero;
    }

    /**
     * retour la clé si trouvé
     * @param  [type] $keyword [description]
     * @param  [type] $data    [description]
     * @return [type]          [description]
     */
    public function searchInArray($keyword, $data)
    {
        $input = preg_quote($keyword, '~'); 
        $result = preg_filter('~' . $keyword . '~', null, $data);
        return current(array_flip($result));
    }

    /**
     * met les mois en 0 si pas de valeurs pour y
     * dans les dashboards l'array doit contenir, x = année, y = valeur
     * @param  [type] $datas  tableau contenant x et y
     * @param  [type] $year   annee courant
     * @param  [type] $type_y null pour les courbes, 0 pour les batons
     * @return [type]         json courbe de Jeremy
     */
    public function buildJsonCurve($datas, $year = null, $type_y = null, $mois = null)
    {
        $year = $year ?? date('Y');

        $this->loadModel('Mois');
        if (!$mois) {
            $mois = $this->Mois->find()->select(['id', 'annee_mois' => 'concat('.$year.', "-", Mois.id)'])->order(['id' => 'ASC'])->indexBy('annee_mois');
        }
        $datas = collection($datas)->indexBy('annee_mois')->toArray();
        $curve = [];
        
        foreach ($mois as $annee_mois => $moi) {
            if (isset($datas[$annee_mois])) {
                $data = $datas[$annee_mois];
                $curve[] = [
                    'x' => $data['x'] ?? null,
                    'y' => $data['y'] ?? ($type_y === null ? null : 0),
                ];
            } else {
                $curve[] = [
                    'x' => $annee_mois,
                    'y' => ($type_y === null ? null : 0)
                ];
            }
        }
        
        return json_encode($curve, JSON_PRETTY_PRINT);
    }
    
    
    public function monthInDate($start = null, $end = null) {

        $month = [];
        $start    = new DateTime($start);
        $start->modify('first day of this month');
        $end      = new DateTime($end);
        $end->modify('first day of next month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end);

        foreach ($period as $dt) {
            $month[$dt->format("Y-m")] = $dt->format("M") . '. ' . (int) $dt->format("y");
        }
        return $month;
    }
    
    public function listMois() {

        $month = [];
        $start = new DateTime('now');

        $month[$start->format("m/Y")] = [
            'Ym' => $start->format("Y-m"),
            'My' => $start->format("M. y")
        ];

        for ($i = 1; $i < 12; $i++) {
            $dt = new DateTime(" - $i month");
            $month[$dt->format("m/Y")] = [
                'Ym' => $dt->format("Y-m"),
                'My' => $dt->format("M. y")
            ];
        }
        return $month;
    }
}