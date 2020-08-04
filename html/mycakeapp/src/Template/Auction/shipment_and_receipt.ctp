<h2>発送および受取の連絡をする</h2>
<?php if (($is_seller ?? false) === true) : ?>
    <?php if ($is_rated) : ?>
        <p>落札者評価は完了しています</p>
        <p><?= $this->Html->link(__('トップページへ戻る'), ['action' => 'index']); ?></p>
    <?php elseif ($bidinfo->is_received) : ?>
        <p><?= $this->Html->link(__('落札者評価を行ってください'), ['controller' => 'AuctionRating', 'action' => 'addRate', $bidinfo->id]); ?></p>
    <?php elseif ($bidinfo->is_shipped) : ?>
        <p>配送中です</p>
    <?php elseif (!empty($bidinfo->receiver_name)) : ?>
        <?= $this->Form->create($bidinfo) ?>
        <?= $this->Form->hidden('receiver_name', ['value' => $bidinfo->receiver_name]); ?>
        <?= $this->Form->hidden('receiver_address', ['value' => $bidinfo->receiver_address]); ?>
        <?= $this->Form->hidden('receiver_phone_number', ['value' => $bidinfo->receiver_phone_number]); ?>
        <?= $this->Form->hidden('is_shipped', ['value' => true]); ?>
        <?= $this->Form->button(__('発送しました')) ?>
        <?= $this->Form->end() ?>
        <table>
            <caption>受取人情報</caption>
            <?= $this->Html->tableHeaders(['名前', '住所', '電話番号']) ?>
            <?= $this->Html->tableCells([
                h($bidinfo->receiver_name),
                h($bidinfo->receiver_address),
                h($bidinfo->receiver_phone_number)
            ]) ?>
        </table>
    <?php else : ?>
        <p>発送先情報が来ていません</p>
    <?php endif; ?>
<?php endif; ?>
<?php if (($is_buyer ?? false) === true) : ?>
    <?php if ($is_rated) : ?>
        <p>出品者評価は完了しています</p>
        <p><?= $this->Html->link(__('トップページへ戻る'), ['action' => 'index']); ?></p>
    <?php elseif ($bidinfo->is_received) : ?>
        <p><?= $this->Html->link(__('出品者評価を行ってください'), ['controller' => 'AuctionRating', 'action' => 'addRate', $bidinfo->id]); ?></p>
    <?php elseif ($bidinfo->is_shipped) : ?>
        <p>出品者が商品を発送しました</p>
        <?= $this->Form->create($bidinfo) ?>
        <?= $this->Form->hidden('receiver_name', ['value' => $bidinfo->receiver_name]); ?>
        <?= $this->Form->hidden('receiver_address', ['value' => $bidinfo->receiver_address]); ?>
        <?= $this->Form->hidden('receiver_phone_number', ['value' => $bidinfo->receiver_phone_number]); ?>
        <?= $this->Form->hidden('is_received', ['value' => true]); ?>
        <?= $this->Form->button(__('受け取りました')) ?>
        <?= $this->Form->end() ?>
    <?php elseif (!empty($bidinfo->receiver_name)) : ?>
        <p>出品者に発送先の情報を連絡しました</p>
    <?php else : ?>
        <?= $this->Form->create($bidinfo) ?>
        <fieldset>
            <legend>※発送先の情報を入力：</legend>
            <?php
            echo $this->Form->control('receiver_name', ['label' => '名前']);
            echo $this->Form->control('receiver_address', ['label' => '住所']);
            echo $this->Form->control('receiver_phone_number', ['label' => '電話番号']);
            ?>
        </fieldset>
        <?= $this->Form->button(__('Submit')) ?>
        <?= $this->Form->end() ?>
    <?php endif; ?>
<?php endif; ?>