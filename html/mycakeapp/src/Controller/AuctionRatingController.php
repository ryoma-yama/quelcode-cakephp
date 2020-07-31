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
            // この取引を評価済みであればインデックスへリダイレクトする
            $is_rated = $this->Rates->find('all', [
                'conditions' => ['rater_id' => $this->Auth->user('id'), 'bidinfo_id' => $bidinfo_id]
            ])->first();
            if ($is_rated ?? false) {
                return $this->redirect(['controller' => 'Auction', 'action' => 'index']);
            }
            // アクセス制御
            if ($seller === $this->Auth->user('id')) {
                $this->set(compact('buyer'));
            } else if ($buyer === $this->Auth->user('id')) {
                $this->set(compact('seller'));
            } else {
                return $this->redirect(['controller' => 'Auction', 'action' => 'index']);
            }
            $rate = $this->Rates->newEntity();
            // post時の処理
            if ($this->request->is('post')) {
                $rate = $this->Rates->patchEntity($rate, $this->request->getData());
                if ($this->Rates->save($rate)) {
                    $this->Flash->success(__('保存しました。'));
                    return $this->redirect($this->request->referer());
                } else {
                    $this->Flash->error(__('保存に失敗しました。もう一度入力下さい。'));
                }
            }
            $this->set(compact('bidinfo', 'rate'));
        } catch (Exception $e) {
            return $this->redirect(['controller' => 'Auction', 'action' => 'index']);
        }
    }

    public function userRate($user_id = null)
    {
        try {
            // このページで表示するユーザー名を取得
            $userPagesUser = $this->Users->get($user_id);
            // 全評価を平均して小数点第二位で四捨五入する
            $query = $this->Rates->find();
            $overallRating = $query->select(['AVG' => $query->func()->avg('rate_value')])
                ->contain(['users'])
                ->where(['Users.id' => $user_id])->first();
            $overallRating = round($overallRating['AVG'], 1);
            $this->set(compact('userPagesUser', 'overallRating'));
            // 取引評価の一覧をページネーションで取得
            $mode = $this->request->getQuery('mode');
            $rateQuery = $this->Rates->find()
                ->select(['Rates.rate_value', 'Rates.rate_comment', 'users.username', 'Bidinfo.user_id', 'Biditems.name'])
                ->join(['table' => 'users', 'type' => 'INNER', 'conditions' => 'Rates.rater_id = users.id'])
                ->contain(['Bidinfo', 'Bidinfo.Biditems'])
                ->order(['Rates.created' => 'desc'])
                ->limit(10)
                ->where(['Rates.ratee_id' => $user_id]);
            // 取引評価一覧の表示形式
            if ($mode === 'buyer') {
                $rateQuery = $rateQuery->where(['Bidinfo.user_id' => $user_id]);
            } elseif ($mode === 'seller') {
                $rateQuery = $rateQuery->where(['Bidinfo.user_id' != $user_id]);
            }
            $rates = $this->paginate($rateQuery)->toArray();
            $this->set(compact('rates'));
        } catch (Exception $e) {
            return $this->redirect(['controller' => 'Auction', 'action' => 'index']);
        }
    }
}
