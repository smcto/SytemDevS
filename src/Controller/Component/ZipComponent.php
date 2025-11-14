<?php
namespace App\Controller\Component;
use Cake\Controller\Component;
use Cake\Datasource\ModelAwareTrait;
use Cake\Filesystem\Folder;
use ZipArchive;
use App\Model\Entity\Devi;
use Cake\Core\Configure;
use Cake\Routing\Router;
use Cake\Filesystem\File;

/**
 * Avant de lancer $this->Zip->uploadTmpFile($entity);
 * faire à chaque fois un clean des dossiers TMP $this->Zip->cleanZipFolder();
 */
class ZipComponent extends Component
{
    use ModelAwareTrait;

    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->controller = $this->getController();
    }

    /**
     * [download description]
     * @param  [type] $type [description]
     * @return [type]       [description]
     */
    public function compressAndDownload(?string $filename)
    {
        $zipArchive = new ZipArchive();
        $folder = new Folder();

        $pathToZipFolder = ZIP_TMP_COMPRESSED; // chemin vers les fichiers crées 
        $folder->create($pathToZipFolder, 0777);
        $tmpZipFileCreated = $pathToZipFolder.'/'.time().'.zip';

        $isZipCreated = false;

        $targetFolder = new Folder(ZIP_TMP_FILES);
        $files = $targetFolder->read()[1];
        if ($zipArchive->open($tmpZipFileCreated, \ZIPARCHIVE::CREATE)) {
            foreach ($files as $key => $file) {
                $zipArchive->addfile($targetFolder->path.'/'.$file, $file);
                $isZipCreated = true;
            }
        }
        $zipArchive->close();

        if ($isZipCreated && file_exists($tmpZipFileCreated)) {
            // si tout est bien crée on procède au télechargement
            // $this->response = $this->response->withFile($tmpZipFileCreated);
            $this->response = $this->response->withFile($tmpZipFileCreated)->withDownload($filename)->withType('application/zip')->withHeader('Content-type', 'application/header');
            return $this->response->send();
        } 

        return false;
    }

    /**
     * Prend entité Devis ou Facture
     * @param  [type] $devisEntity [description]
     * @return [type]              [description]
     */
    public function uploadTmpFile($entity)
    {
        $url = Router::url(['controller' => $entity->source(), 'action' => 'pdfversion', $entity->id], true);
        $file_name = ZIP_TMP_FILES . DS . $entity->indent.'.pdf';
        $file = new File($file_name, true, 0777);
        return $file->write(file_get_contents($url));
    }

    public function cleanFolder($path)
    {
        $folder = new Folder($path);
        $files = $folder->read()[1];
        foreach ($files as $file) {
            $targetTmpFile = $folder->path.'/'.$file;
            if (file_exists($targetTmpFile)) {
                @unlink($targetTmpFile);
            }
        }
    }
    public function cleanZipFolder()
    {
        $this->cleanFolder(ZIP_TMP_FILES);
        $this->cleanFolder(ZIP_TMP_COMPRESSED);
    }
}
?>