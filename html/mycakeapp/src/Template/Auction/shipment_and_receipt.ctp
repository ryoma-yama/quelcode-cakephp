<h2>発送および受取の連絡をする</h2>
<?php if (($is_seller ?? false) === true) : ?>
<?php endif; ?>
<?php if (($is_buyer ?? false) === true) : ?>
    <?php if (!empty($bidinfo->receiver_name)) : ?>
        <p>出品者に発送先の情報を連絡しました</p>
    <?php endif; ?>
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