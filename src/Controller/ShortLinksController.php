<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ShortLinks Controller
 *
 * @property \App\Model\Table\ShortLinksTable $ShortLinks
 *
 * @method \App\Model\Entity\ShortLink[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShortLinksController extends AppController
{

    public function initialize(array $config = [])
    {

        parent::initialize($config);
        $this->Auth->allow(['view']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Devis']
        ];
        $shortLinks = $this->paginate($this->ShortLinks);

        $this->set(compact('shortLinks'));
    }

    /**
     * View method
     *
     * @param string|null $id Short Link id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($shortLink = null)
    {
        $link = $this->ShortLinks->findByShortLink('link/' . $shortLink)->first();
        if($link) {
            return $this->redirect('/' . $link->link);
        }
        throw new NotFoundException();
    }

    /**
     * Delete method
     *
     * @param string|null $id Short Link id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shortLink = $this->ShortLinks->get($id);
        if ($this->ShortLinks->delete($shortLink)) {
            $this->Flash->success(__('The short link has been deleted.'));
        } else {
            $this->Flash->error(__('The short link could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
