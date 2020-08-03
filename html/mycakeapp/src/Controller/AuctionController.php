<?php

namespace App\Controller;

use App\Controller\AppController;

use Cake\Event\Event; // added.
use Exception; // added.

class AuctionController extends AuctionBaseController
{
    // デフォルトテーブルを使わない
    public $useTable = false;

    // 初期化処理
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
        // 必要なモデルをすべてロード
        $this->loadModel('Users');
        $this->loadModel('Biditems');
        $this->loadModel('Bidrequests');
        $this->loadModel('Bidinfo');
        $this->loadModel('Bidmessages');
        $this->loadModel('Rates');
        // ログインしているユーザー情報をauthuserに設定
        $this->set('authuser', $this->Auth->user());
        // レイアウトをauctionに変更
        $this->viewBuilder()->setLayout('auction');
    }

    // トップページ
    public function index()
    {
        // ページネーションでBiditemsを取得
        $auction = $this->paginate('Biditems', [
            'order' => ['endtime' => 'desc'],
            'limit' => 10
        ]);
        $this->set(compact('auction'));
    }

    // 商品情報の表示
    public function view($id = null)
    {
        // $idのBiditemを取得
        $biditem = $this->Biditems->get($id, [
            'contain' => ['Users', 'Bidinfo', 'Bidinfo.Users']
        ]);
        // オークション終了時の処理
        if ($biditem->endtime < new \DateTime('now') and $biditem->finished == 0) {
            // finishedを1に変更して保存
            $biditem->finished = 1;
            $this->Biditems->save($biditem);
            // Bidinfoを作成する
            $bidinfo = $this->Bidinfo->newEntity();
            // Bidinfoのbiditem_idに$idを設定
            $bidinfo->biditem_id = $id;
            // 最高金額のBidrequestを検索
            $bidrequest = $this->Bidrequests->find('all', [
                'conditions' => ['biditem_id' => $id],
                'contain' => ['Users'],
                'order' => ['price' => 'desc']
            ])->first();
            // Bidrequestが得られた時の処理
            if (!empty($bidrequest)) {
                // Bidinfoの各種プロパティを設定して保存する
                $bidinfo->user_id = $bidrequest->user->id;
                $bidinfo->user = $bidrequest->user;
                $bidinfo->price = $bidrequest->price;
                $bidinfo->receiver_name = '';
                $bidinfo->receiver_address = '';
                $bidinfo->receiver_phone_number = '';
                $this->Bidinfo->save($bidinfo);
            }
            // Biditemのbidinfoに$bidinfoを設定
            $biditem->bidinfo = $bidinfo;
        }
        // Bidrequestsからbiditem_idが$idのものを取得
        $bidrequests = $this->Bidrequests->find('all', [
            'conditions' => ['biditem_id' => $id],
            'contain' => ['Users'],
            'order' => ['price' => 'desc']
        ])->toArray();
        // オークション終了時刻までのカウントダウンタイマー用に終了時刻をセットする
        $serverCurrentTime = new \Datetime('now');
        // オブジェクト類をテンプレート用に設定
        $this->set(compact('biditem', 'bidrequests', 'serverCurrentTime'));
    }

    // 出品する処理
    public function add()
    {
        // Biditemインスタンスを用意
        $biditem = $this->Biditems->newEntity();
        // POST送信時の処理
        if ($this->request->is('post')) {
            // 画像の拡張子をチェックする
            $uploadedFile = $this->request->getData('img_path');
            if (!empty($uploadedFile['name'])) {
                $approvedExtension = ['jpg', 'JPG', 'gif', 'GIF', 'png', 'PNG'];
                $uploadedFileExtension = substr($uploadedFile['name'], -3);
                if ((in_array($uploadedFileExtension, $approvedExtension, 1))) {
                    // $biditemにフォームの送信内容を反映
                    $biditem = $this->Biditems->patchEntity($biditem, $this->request->getData());
                    $biditem['img_path'] = "temporaryValue";
                    // $biditemを保存する
                    if ($this->Biditems->save($biditem)) {
                        // $biditemの保存により生成されたidを, 画像ファイル名に使用して保存
                        $biditem_id = $biditem->id;
                        $destination = '../webroot/img/auction/' . $biditem_id . '.' . $uploadedFileExtension;
                        move_uploaded_file($uploadedFile['tmp_name'], $destination);
                        // DataBaseのimg_pathカラムの値を新しい画像ファイル名に更新
                        $biditem['img_path'] = $biditem_id . '.' . $uploadedFileExtension;
                        $this->Biditems->save($biditem);
                        // 成功時のメッセージ
                        $this->Flash->success(__('保存しました。'));
                        // トップページ（index）に移動
                        return $this->redirect(['action' => 'index']);
                    }
                }
            }
            // 失敗時のメッセージ
            $this->Flash->error(__('保存に失敗しました。もう一度入力下さい。'));
        }
        // 値を保管
        $this->set(compact('biditem'));
    }
    // 入札の処理
    public function bid($biditem_id = null)
    {
        // 入札用のBidrequestインスタンスを用意
        $bidrequest = $this->Bidrequests->newEntity();
        // $bidrequestにbiditem_idとuser_idを設定
        $bidrequest->biditem_id = $biditem_id;
        $bidrequest->user_id = $this->Auth->user('id');
        // POST送信時の処理
        if ($this->request->is('post')) {
            // $bidrequestに送信フォームの内容を反映する
            $bidrequest = $this->Bidrequests->patchEntity($bidrequest, $this->request->getData());
            // Bidrequestを保存
            if ($this->Bidrequests->save($bidrequest)) {
                // 成功時のメッセージ
                $this->Flash->success(__('入札を送信しました。'));
                // トップページにリダイレクト
                return $this->redirect(['action' => 'view', $biditem_id]);
            }
            // 失敗時のメッセージ
            $this->Flash->error(__('入札に失敗しました。もう一度入力下さい。'));
        }
        // $biditem_idの$biditemを取得する
        $biditem = $this->Biditems->get($biditem_id);
        $this->set(compact('bidrequest', 'biditem'));
    }

    // 落札者とのメッセージ
    public function msg($bidinfo_id = null)
    {
        // Bidmessageを新たに用意
        $bidmsg = $this->Bidmessages->newEntity();
        // POST送信時の処理
        if ($this->request->is('post')) {
            // 送信されたフォームで$bidmsgを更新
            $bidmsg = $this->Bidmessages->patchEntity($bidmsg, $this->request->getData());
            // Bidmessageを保存
            if ($this->Bidmessages->save($bidmsg)) {
                $this->Flash->success(__('保存しました。'));
            } else {
                $this->Flash->error(__('保存に失敗しました。もう一度入力下さい。'));
            }
        }
        try { // $bidinfo_idからBidinfoを取得する
            $bidinfo = $this->Bidinfo->get($bidinfo_id, ['contain' => ['Biditems']]);
        } catch (Exception $e) {
            $bidinfo = null;
        }
        // Bidmessageをbidinfo_idとuser_idで検索
        $bidmsgs = $this->Bidmessages->find('all', [
            'conditions' => ['bidinfo_id' => $bidinfo_id],
            'contain' => ['Users'],
            'order' => ['created' => 'desc']
        ]);
        $this->set(compact('bidmsgs', 'bidinfo', 'bidmsg'));
    }

    // 落札情報の表示
    public function home()
    {
        // 自分が落札したBidinfoをページネーションで取得
        $bidinfo = $this->paginate('Bidinfo', [
            'conditions' => ['Bidinfo.user_id' => $this->Auth->user('id')],
            'contain' => ['Users', 'Biditems'],
            'order' => ['created' => 'desc'],
            'limit' => 10
        ])->toArray();
        $this->set(compact('bidinfo'));
    }

    // 出品情報の表示
    public function home2()
    {
        // 自分が出品したBiditemをページネーションで取得
        $biditems = $this->paginate('Biditems', [
            'conditions' => ['Biditems.user_id' => $this->Auth->user('id')],
            'contain' => ['Users', 'Bidinfo'],
            'order' => ['created' => 'desc'],
            'limit' => 10
        ])->toArray();
        $this->set(compact('biditems'));
    }

    // 発送と受取の連絡をする
    public function shipmentAndReceipt($bidinfo_id = null)
    {
        try {
            $bidinfo = $this->Bidinfo->get($bidinfo_id, [
                'contain' => ['Biditems']
            ]);
            $seller = $bidinfo->biditem->user_id;
            $buyer = $bidinfo->user_id;
            // この取引を評価済みかどうか
            $is_rated = $this->Rates->find('all', [
                'conditions' => ['rater_id' => $this->Auth->user('id'), 'bidinfo_id' => $bidinfo_id]
            ])->first();
            if ($is_rated ?? false) {
                $this->set('is_rated', true);
            }
            // アクセス制御
            if ($seller === $this->Auth->user('id')) {
                $this->set('is_seller', true);
            } else if ($buyer === $this->Auth->user('id')) {
                $this->set('is_buyer', true);
            } else {
                return $this->redirect(['action' => 'index']);
            }
            // put時の処理
            if ($this->request->is('put')) {
                $bidinfo = $this->Bidinfo->patchEntity($bidinfo, $this->request->getData());
                // 保存する
                if ($this->Bidinfo->save($bidinfo)) {
                    $this->Flash->success(__('保存しました。'));
                    // 同じページに戻る
                    return $this->redirect($this->request->referer());
                } else {
                    $this->Flash->error(__('保存に失敗しました。もう一度入力下さい。'));
                }
            }
            $this->set(compact('bidinfo', 'is_rated'));
        } catch (Exception $e) {
            return $this->redirect(['action' => 'index']);
        }
    }
}
