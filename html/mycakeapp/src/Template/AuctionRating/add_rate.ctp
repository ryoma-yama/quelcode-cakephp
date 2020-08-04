<h2>取引を評価する</h2>
<?= $this->Form->create($rate); ?>
<fieldset>
    <legend>※今回の取引を評価する</legend>
    <?= $this->Form->hidden('rater_id', ['value' => $authuser['id']]) ?>
    <?= $this->Form->hidden('ratee_id', ['value' => ($buyer ?? $seller)])  ?>
    <?= $this->Form->hidden('bidinfo_id', ['value' => $bidinfo->id])  ?>
    <?= $this->Form->input('rate_value', [
        'type' => 'select', 'label' => '五段階評価', 'options' => [
            '5' => '5:非常に良い', '4' => '4:良い', '3' => '3:普通', '2' => '2:悪い', '1' => '1:非常に悪い'
        ]
    ]); ?>
    <?= $this->Form->control('rate_comment', ['label' => 'コメント', 'required']) ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>