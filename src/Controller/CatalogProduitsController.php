<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Utility\Text;
use Cake\Core\Configure;

/**
 * CatalogProduits Controller
 *
 * @property \App\Model\Table\CatalogProduitsTable $CatalogProduits
 *
 * @method \App\Model\Entity\CatalogProduit[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CatalogProduitsController extends AppController {

    public function isAuthorized($user) {
        $typeprofils = $user['typeprofils'];
        if (in_array('admin', $typeprofils)) {
            return true;
        }
        return parent::isAuthorized($user);
    }

    public function majCatsMulti()
    {
        $cps = $this->CatalogProduits->find()->contain(['CatalogSousCategories' => 'CatalogCategories']);
        foreach ($cps as $key => $cp) {
            $data['catalog_produits_has_categories'] = [
                [
                    'catalog_category_id' => $cp->catalog_sous_category->catalog_category->id,
                    'catalog_sous_category_id' => $cp->catalog_sous_category->id,
                ]
            ];
            $cp = $this->CatalogProduits->patchEntity($cp, $data, ['validate' => false]);
            $this->CatalogProduits->save($cp);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() {

        $key = $this->request->getQuery('key');
        $categorie = $this->request->getQuery('catalog_category_id');
        $sous_categorie = $this->request->getQuery('catalog_sous_category_id');
        $nom_commercial = $this->request->getQuery('nom_commercial');
        $pro_part = $this->request->getQuery('pro_part');
        $code = $this->request->getQuery('code');
        $sous_sous_categorie = $this->request->getQuery('sous_sous_category_id');

        $customFinderOptions = [
            'key' => $key,
            'catalog_category_id' => $categorie,
            'catalog_sous_category_id' => $sous_categorie,
            'nom_commercial' => $nom_commercial,
            'pro_part' => $pro_part,
            'code' => $code,
            'catalog_sous_sous_category_id' => $sous_sous_categorie
        ];

        $this->paginate = [
            'contain' => ['CatalogProduitsHasCategories' => ['CatalogCategories', 'CatalogSousCategories', 'CatalogSousSousCategories']],
            'finder' => ['filtre' => $customFinderOptions,]
            
        ];

        $catalogProduits = $this->paginate($this->CatalogProduits);

        $types = Configure::read('types');
        $this->loadModel('CatalogSousSousCategories');
        $catalogSousCategories = $this->CatalogProduits->CatalogProduitsHasCategories->CatalogSousCategories->find('list')->orderAsc('nom');
        $catalogSousSousCategories = $this->CatalogSousSousCategories->find('list', ['groupField' => 'catalog_sous_category_id'])->orderAsc('nom');
        $catalogCategories = $this->CatalogProduits->CatalogProduitsHasCategories->CatalogCategories->find('list')->orderAsc('nom');
        if ($categorie) {
            $catalogSousCategories = $catalogSousCategories->where(['catalog_categories_id' => $categorie]);
        }

        $this->set(compact('sous_sous_categorie', 'catalogSousSousCategories', 'catalogProduits', 'catalogSousCategories', 'catalogCategories', 'categorie', 'sous_categorie', 'key', 'nom_commercial', 'types', 'pro_part', 'code'));
    }

    /**
     * View method
     *
     * @param string|null $id Catalog Produit id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) {
        $catalogProduit = $this->CatalogProduits->findById($id)->find('complete')->first();

        $this->set(compact('catalogProduit'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null) 
    {
        $catalogProduit = $this->CatalogProduits->newEntity();

        if ($id) {
            $catalogProduit = $this->CatalogProduits->findById($id)->find('complete')->first();
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $catalogProduit = $this->CatalogProduits->patchEntity($catalogProduit, $data);
            
            if ($this->CatalogProduits->save($catalogProduit)) {

                if (!empty($data['photos'])) {
                    foreach ($data['photos'] as $doc) {
                        $filename = $doc['nom'];
                        if (copy(PATH_TMP . $filename, PATH_CATALOG_PRODUITS . $filename)) {
                            unlink(PATH_TMP . $filename);
                            $doc = $this->CatalogProduits->CatalogProduitsFiles->newEntity();
                            $doc->nom_fichier = $filename;
                            $doc->chemin = PATH_CATALOG_PRODUITS . $filename;
                            $doc->catalog_produits_id = $catalogProduit->id;
                            $this->CatalogProduits->CatalogProduitsFiles->save($doc);
                        }
                    }
                }
                
                if (!empty($data['documents_a_suppr'])) {
                    foreach ($data['documents_a_suppr'] as $doc) {
                        $filename = $doc['nom'];
                        $doc = $this->CatalogProduits->CatalogProduitsFiles->findByNomFichier($filename)->first();
                        if ($doc) {
                            $this->CatalogProduits->CatalogProduitsFiles->delete($doc);
                        }
                    }
                }
                
                //======= GESTION DOCUMENTS
                if (!empty($data['documents'])){
                    foreach ($data['documents'] as $key => $document){
                        if (!empty($document['file']['name'])) {
                            
                            $doc = $this->CatalogProduits->CatalogProduitsFiles->newEntity();
                            if(isset($document['id']) && !empty($document['id'])){
                                $doc = $this->CatalogProduits->CatalogProduitsFiles->get($document['id']);
                            }
                            
                            $extension = pathinfo($document['file']['name'], PATHINFO_EXTENSION);
                            $filename = Text::uuid() . "." . $extension;
                            if (move_uploaded_file($document['file']['tmp_name'], PATH_MODEL_BORNES . $filename)) {
                                
                                $doc = $this->CatalogProduits->CatalogProduitsFiles->newEntity();
                                $doc->nom_fichier = $filename;
                                $doc->chemin = PATH_CATALOG_PRODUITS . $filename;
                                $doc->catalog_produits_id = $catalogProduit->id;
                                $doc->titre = $document['titre'];
                                $doc->description = $document['description'];
                                $doc->is_document = 1;
                                $this->CatalogProduits->CatalogProduitsFiles->save($doc);
                            }
                        }
                    }
                }
                
                //== Suppression document
                if (isset($data['asuppr'])) {
                    
                    $docAsuppr = array_filter($data['asuppr']);
                    
                    if(count($docAsuppr)) {
                        $this->CatalogProduits->CatalogProduitsFiles->deleteAll(['id IN' => $docAsuppr]);
                    }
                }

                $this->Flash->success(__('The catalog produit has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The catalog produit could not be saved. Please, try again.'));
            debug($catalogProduit->getErrors());
        }
        $this->loadModel('CatalogSousSousCategories');
        $catalogSousCategories = $this->CatalogProduits->CatalogProduitsHasCategories->CatalogSousCategories->find('list', ['groupField' => 'catalog_categories_id'])->orderAsc('nom');
        $catalogSousSousCategories = $this->CatalogSousSousCategories->find('list', ['groupField' => 'catalog_sous_category_id'])->orderAsc('nom');
        $catalogCategories = $this->CatalogProduits->CatalogProduitsHasCategories->CatalogCategories->find('list')->orderAsc('nom');
        $unites = $this->CatalogProduits->CatalogUnites->find('list', ['valueField' => 'nom'])->orderAsc('nom');
        $this->set(compact('catalogSousSousCategories', 'catalogProduit', 'catalogSousCategories', 'catalogCategories', 'unites'));
    }


    public function importCsv() {

        if ($this->request->is('post')) {

            if ($this->request->getData("csv")) {
                $csv = $this->request->getData("csv");
                if (isset($csv['size']) && $csv['size'] && trim($csv['name'])) {

                    $fileCsv = $csv['tmp_name'];
                    $fileName = trim($csv['name']);
                    $extension = explode('.', $fileName);

                    if ($extension[1] == 'csv') {
                        $handle = fopen($fileCsv, "r");
                        $numLigne = 0;
                        while (($rows = fgetcsv($handle)) !== FALSE) {
                            if($numLigne){
                                $rows = utf8_encode(implode(",", $rows));
                                $row = explode(";", $rows);
                                $catalog_sous_categories = $this->CatalogProduits->CatalogProduitsHasCategories->CatalogSousCategories->find('all')->where(['nom LIKE' => "%$row[4]%"])->first();

                                if(! $catalog_sous_categories) {
                                    $catalog_sous_categories = $this->CatalogProduits->CatalogProduitsHasCategories->CatalogSousCategories->newEntity(['nom' => $row[4], 'catalog_categories_id' => 1]);
                                    if($this->CatalogProduits->CatalogProduitsHasCategories->CatalogSousCategories->save($catalog_sous_categories)) {
                                        $this->Flash->success(__('Nouveau sous categorie enregistré : ' . $row[4]));
                                    }
                                }
                                if($catalog_sous_categories->id) {
                                    $data = [
                                        'catalog_sous_categories_id' => $catalog_sous_categories->id,
                                        'nom_commercial' => $row[1],
                                        'nom_interne' => $row[2],
                                        'description_commercial' => $row[3],
                                        'prix_reference_ht' => $row[5],
                                        'reference' => $row[0],
                                        'quantite_usuelle' => 1,
                                        'is_pro' => $row[6] == 'Professionnel'?1:0,
                                        'is_particulier' => $row[6] == 'Professionnel'?0:1,
                                        'code_comptable' => $row[7],
                                    ];
                                    $produit = $this->CatalogProduits->newEntity($data);
                                    if($this->CatalogProduits->save($produit)) {
                                        $this->Flash->success(__('Nouveau produit enregistré : ' . $row[0]));
                                    }
                                }
                            }
                            $numLigne++;
                        }
                    }
                }
            }
        }
        $catalogProduits = $this->CatalogProduits->newEntity();
        $this->set(compact('catalogProduits'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Catalog Produit id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) {
        $this->request->allowMethod(['post', 'delete']);
        $catalogProduit = $this->CatalogProduits->get($id);
        if ($this->CatalogProduits->delete($catalogProduit)) {
            $this->Flash->success(__('The catalog produit has been deleted.'));
        } else {
            $this->Flash->error(__('The catalog produit could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     *
     *  files uploaded 
     */
    public function uploadPhotos() {
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender = false;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $res["success"] = false;
            $res["type_upload"] = $data['type_upload'];

            if (!empty($data)) {
                $file = $data["file"];
                $fileName = $file['name'];
                $infoFile = pathinfo($fileName);
                $fileExtension = $infoFile["extension"];
                $extensionValide = array('doc', 'docx', 'pdf', 'png', 'jpg', 'jpeg', 'PNG', 'JPG', 'JPEG');
                if (in_array($fileExtension, $extensionValide)) {
                    $newName = Text::uuid() . '.' . $fileExtension;
                    $tmpFilePath = $file['tmp_name'];
                    if (move_uploaded_file($tmpFilePath, PATH_TMP . $newName)) {
                        $res["success"] = true;
                        $res["name"] = $newName;
                    }
                } else {
                    $res["error"] = "Fichier invalide format";
                }
            }
            echo json_encode($res);
        }
    }

    /**
     *
     * get files uploaded to edit
     */
    public function getFichiers($id) {
        $this->viewBuilder()->setLayout('ajax');
        $this->autoRender = false;
        $res = [];
        $this->loadModel('CatalogProduitsFiles');
        $fichiers = $this->CatalogProduitsFiles->find('all')->where(['catalog_produits_id' => $id, 'is_document' => 0])->toArray();
        if (!empty($fichiers)) {
            foreach ($fichiers as $fichier) {
                $fic['id'] = $fichier->id;
                $fic['name'] = $fichier->nom_fichier;
                $fic['url'] = $fichier->url;
                $fic['url_viewer'] = $fichier->url_viewer;
                $fic['size'] = filesize(PATH_CATALOG_PRODUITS . $fichier->nom_fichier);
                $infoFile = pathinfo($fichier->nom_fichier);
                $fileExtension = $infoFile["extension"];
                $fic['extension'] = $fileExtension;
                $res [] = $fic;
            }
        }
        echo json_encode($res);
    }

    /**
     * 
     * @param type $id
     * @return type
     */
    public function getProduitById($id) {
        $this->autoRender = false;
        $catalogProduit = $this->CatalogProduits->get($id, [
            'contain' => ['CatalogProduitsHasCategories' => ['CatalogSousCategories', 'CatalogCategories']]
        ]);
        return $this->response->withType('application/json')->withStringBody(json_encode($catalogProduit));
    }

}
