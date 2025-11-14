<?php
namespace App\Controller\Component;

use Cake\Controller\Component;

class TeamviewerAPIComponent extends Component
{

    public function connexion(){
        $url = 'https://webapi.teamviewer.com/api/v1/account';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output=curl_exec($ch);

        curl_close($ch);
        return $output;
    }

    public function authorize(){
        $url = 'https://login.teamviewer.com/oauth2/authorize';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url."?response_type=code&client_id=165486-cMiGTMSnIVMqtvSmIzCk&redirect_uri=http://localhost/crm-selfizee/fr/bornes");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $output = curl_exec($ch);

        curl_close($ch);
        debug($output);die;
        //return $output;
    }

    public function addDevice($teamviewer_id, $teamviewer_pwd, $alias ){
        $url = 'https://webapi.teamviewer.com/api/v1/devices';

        $datas = [];
        $datas ["groupid"] = "g129235225";
        $datas ["remotecontrol_id"] = $teamviewer_id;
        if(!empty($teamviewer_pwd)) $datas ["password"] = $teamviewer_pwd;
        if(!empty($alias)) $datas ["alias"] = $alias;
        /* $datas = array(
             "remotecontrol_id" => $teamviewer_id,
             "password" => $teamviewer_pwd,
             "groupid" => "g129235225",
             "alias" => "Borne-1"
         );*/
        $datas = json_encode($datas);
        $headers = array(
            'Content-Type: application/json',
            //'Authorization: Bearer 3956757-lk3wCI9vcHsHvBKZokub'
            'Authorization: Bearer 3979608-bKvN6MZq2fIc6YqW8DiS'
        );

        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $datas );

        $result = curl_exec($ch);
        if (!$result) {
            //die('Curl failed: ' . curl_error($ch));
            return false;
        }

        curl_close($ch);
        $result = json_decode($result, TRUE);
        //debug($result);die;
        return $result;
        /*if(gettype($result) == "array" && array_key_exists("remotecontrol_id", $result) && array_key_exists("device_id", $result)){
            return $result;
        } else {
            return false;
        }*/
    }

    public function updateDevice($device_id, $teamviewer_pwd, $alias){
        $url = 'https://webapi.teamviewer.com/api/v1/devices/'.$device_id;

        $datas = array();
        $datas["groupid"] = "g129235225";
        if(!empty($teamviewer_pwd)) $datas ["password"] = $teamviewer_pwd;
        if(!empty($alias)) $datas ["alias"] = $alias;

        $headers = array(
            //'Authorization: Bearer 3956757-lk3wCI9vcHsHvBKZokub'
            'Authorization: Bearer 3979608-bKvN6MZq2fIc6YqW8DiS'
        );

        $ch = curl_init();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($datas));

        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result, TRUE);
        //debug($result);die;
        /*if(!empty($result)){
            $result = false;
        } else {
            $result = true;
        }*/
        return $result;
    }

    public function deleteDevice($device_id){
        $url = 'https://webapi.teamviewer.com/api/v1/devices/'.$device_id;
        $headers = array(
            //'Authorization: Bearer 3956757-lk3wCI9vcHsHvBKZokub'
            'Authorization: Bearer 3979608-bKvN6MZq2fIc6YqW8DiS'
        );

        $ch = curl_init();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");

        $result = curl_exec($ch);
        curl_close($ch);
        //debug($result);die;
        if(!empty($result)){
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    public function getDevice($remotecontrol_id){

        $url = 'https://webapi.teamviewer.com/api/v1/devices';
        $headers = array(
            'Content-Type: application/json',
            //'Authorization: Bearer 3956757-lk3wCI9vcHsHvBKZokub'
            'Authorization: Bearer 3979608-bKvN6MZq2fIc6YqW8DiS'
        );

        if(empty($remotecontrol_id)) {
            $url = $url."?groupid=g129235225";
        } else {
            $url = $url."?remotecontrol_id=".$remotecontrol_id;
        }
        //&online_state=Online
        //remotecontrol_id=r1094959510

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($result, TRUE);
        //debug($result);die;
        if(gettype($result) == "array" && array_key_exists("devices", $result)){
            if (empty($result['devices'])){
                $result = null;
            }
        } else {
            $result = null;
        }
        return $result;
    }

}