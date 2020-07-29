<?php

namespace App\Controller;

use App\Controller\AppController;

/**
 * Rates Controller
 *
 * @property \App\Model\Table\RatesTable $Rates
 *
 * @method \App\Model\Entity\Rate[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RatesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Raters', 'Ratees', 'Bidinfos'],
        ];
        $rates = $this->paginate($this->Rates);

        $this->set(compact('rates'));
    }

    /**
     * View method
     *
     * @param string|null $id Rate id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $rate = $this->Rates->get($id, [
            'contain' => ['Raters', 'Ratees', 'Bidinfos'],
        ]);

        $this->set('rate', $rate);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $rate = $this->Rates->newEntity();
        if ($this->request->is('post')) {
            $rate = $this->Rates->patchEntity($rate, $this->request->getData());
            if ($this->Rates->save($rate)) {
                $this->Flash->success(__('The rate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rate could not be saved. Please, try again.'));
        }
        $raters = $this->Rates->Raters->find('list', ['limit' => 200]);
        $ratees = $this->Rates->Ratees->find('list', ['limit' => 200]);
        $bidinfos = $this->Rates->Bidinfos->find('list', ['limit' => 200]);
        $this->set(compact('rate', 'raters', 'ratees', 'bidinfos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Rate id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $rate = $this->Rates->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $rate = $this->Rates->patchEntity($rate, $this->request->getData());
            if ($this->Rates->save($rate)) {
                $this->Flash->success(__('The rate has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The rate could not be saved. Please, try again.'));
        }
        $raters = $this->Rates->Raters->find('list', ['limit' => 200]);
        $ratees = $this->Rates->Ratees->find('list', ['limit' => 200]);
        $bidinfos = $this->Rates->Bidinfos->find('list', ['limit' => 200]);
        $this->set(compact('rate', 'raters', 'ratees', 'bidinfos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Rate id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $rate = $this->Rates->get($id);
        if ($this->Rates->delete($rate)) {
            $this->Flash->success(__('The rate has been deleted.'));
        } else {
            $this->Flash->error(__('The rate could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
