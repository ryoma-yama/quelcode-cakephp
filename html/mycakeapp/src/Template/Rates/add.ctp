<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rate $rate
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Rates'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="rates form large-9 medium-8 columns content">
    <?= $this->Form->create($rate) ?>
    <fieldset>
        <legend><?= __('Add Rate') ?></legend>
        <?php
            echo $this->Form->control('rater_id');
            echo $this->Form->control('ratee_id');
            echo $this->Form->control('bidinfo_id');
            echo $this->Form->control('rate_value');
            echo $this->Form->control('rate_comment');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
