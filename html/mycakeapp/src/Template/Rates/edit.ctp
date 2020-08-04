<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rate $rate
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $rate->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $rate->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Rates'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="rates form large-9 medium-8 columns content">
    <?= $this->Form->create($rate) ?>
    <fieldset>
        <legend><?= __('Edit Rate') ?></legend>
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
