<?php

namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event;
use Exception;

class AuctionRatingController extends AuctionBaseController
{

    public $useTable = false;

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        $this->loadModel('Users');
        $this->loadModel('Biditems');
        $this->loadModel('Bidinfo');
        $this->loadModel('Rates');
        $this->set('authuser', $this->Auth->user());
        $this->viewBuilder()->setLayout('auction');
    }

    public function addRate($bidinfo_id = null)
    {
        try {
            $bidinfo = $this->Bidinfo->get($bidinfo_id, [
                'contain' => ['Biditems']
            ]);
            $seller = $bidinfo->biditem->user_id;
            $buyer = $bidinfo->user_id;
            if ($seller === $this->Auth->user('id')) {
                $this->set('is_seller', true);
            } else if ($buyer === $this->Auth->user('id')) {
                $this->set('is_buyer', true);
            } else {
                return $this->redirect(['controller' => 'Auction', 'action' => 'index']);
            }
        } catch (Exception $e) {
            return $this->redirect(['controller' => 'Auction', 'action' => 'index']);
        }
    }
}
