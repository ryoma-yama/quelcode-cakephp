<h2><?= $userPagesUser->username ?></h2>
<table>
    <?= $this->Html->tableHeaders(['総合評価']) ?>
    <?= $this->Html->tableCells([$overallRating]) ?>
</table>
<h3>※取引評価一覧</h3>
<p><?= $this->Html->link(__('すべての評価'), ['action' => 'userRate', $authuser['id']]); ?></p>
<p><?= $this->Html->link(__('落札での評価'), ['action' => 'userRate', $authuser['id'], 'mode' => 'buyer']); ?></p>
<p><?= $this->Html->link(__('出品での評価'), ['action' => 'userRate', $authuser['id'], 'mode' => 'seller']); ?></p>
<table>
    <?= $this->Html->tableHeaders(['評価値', '基準', 'コメント', '評価者', '商品名']) ?>
    <?php foreach ($rates as $rate) : ?>
        <?= $this->Html->tableCells([
            h($rate['rate_value']),
            h(($rate['bidinfo']['user_id'] === $userPagesUser->id) ? '落札者' : '出品者'),
            h($rate['rate_comment']),
            h($rate['users']['username']),
            h($rate['bidinfo']['biditem']['name']),
        ]) ?>
    <?php endforeach; ?>
</table>

<div class="paginator">
    <ul class="pagination">
        <?= $this->Paginator->first('<< ' . __('first')) ?>
        <?= $this->Paginator->prev('< ' . __('previous')) ?>
        <?= $this->Paginator->numbers() ?>
        <?= $this->Paginator->next(__('next') . ' >') ?>
        <?= $this->Paginator->last(__('last') . ' >>') ?>
    </ul>
</div>