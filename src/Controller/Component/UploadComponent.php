<?php
namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\I18n\Date;
use Cake\Utility\Text;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class UploadComponent extends Component
{
    public $controller;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->controller = $this->getController();
    }

    public function dropzone($path)
    {
        ini_set('upload_max_filesize', '100M');
        ini_set('post_max_size', '100M');
        $result["status"] = 'error';

        if ($this->controller->request->is(['patch', 'post', 'put'])) {
            $data = $this->controller->request->getData();

            if (!empty($data)) {

                $file = $data["file"];
                $fileName = $file['name'];
                $infoFile = pathinfo($fileName);
                $fileExtension = strtolower($infoFile["extension"]);
                $extensionValide = ['doc', 'docx', 'pdf', 'png', 'jpg', 'jpeg', 'png', 'jpg', 'jpeg'];

                if (in_array($fileExtension, $extensionValide)) {
                    $newName = Text::uuid() . '.' . $fileExtension;
                    $path_tmp = $path;
                    (new Folder())->create(WWW_ROOT.DS.$path_tmp, '0777');
                    $destinationFileName = $path_tmp . $newName;
                    $tmpFilePath = $file['tmp_name'];
                    
                    if (move_uploaded_file($tmpFilePath, $destinationFileName)) {
                        $result["status"] = 'success';
                        $result["name"] = $newName;
                        $result["dir_path"] = $path;
                    }
                } 
                else {
                    $result["error"] = "Fichier au format invalide";
                }
            }

        }

        return $result;
    }

    /**
     * options:
     * path, ext
     */
    public function moveFiles($field, array $options = [])
    {

        $ext = pathinfo($field['name'], PATHINFO_EXTENSION);
        if (!empty($field['name'])) {
            if (!isset($options['ext'])) {
                $extensionValide = ['doc', 'docx', 'pdf', 'png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG'];
            } else {
                $extensionValide = $options['ext'];
            }

            if (!in_array($ext, $extensionValide)) {
                $this->controller->Flash->set('Veuillez choisir un fichier au format : '.join(', ', $extensionValide), ['element' => 'alert', 'key' => 'default', 'params' => ['class' => 'alert alert-danger']]);
                $this->controller->response =  $this->controller->redirect($this->controller->referer());
                $this->controller->response->send();
                exit();
            }
        }

        if (!isset($options['path'])) {
            $this->response =  $this->redirect($this->controller->referer());
            $this->Flash->error('Dossier destination indéfini');
            $this->response->send();
            exit();
        } else {
            $file = '';
            if (!empty($field['name'])) {
                $fileName = $field['name'];
                $infoFile = pathinfo($fileName);
                $fileExtension = $infoFile["extension"];
                $file = Text::uuid() . '.' . $fileExtension;

                $dest = WWW_ROOT.'uploads'.DS.$options['path'];
                (new Folder())->create($dest, '0777');
                move_uploaded_file($field['tmp_name'],$dest.DS.$file);
            }
            return $file;
        }
    }
}
?>