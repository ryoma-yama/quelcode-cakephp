<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rate $rate
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Rate'), ['action' => 'edit', $rate->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Rate'), ['action' => 'delete', $rate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rate->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Rates'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Rate'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="rates view large-9 medium-8 columns content">
    <h3><?= h($rate->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Rate Comment') ?></th>
            <td><?= h($rate->rate_comment) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($rate->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rater Id') ?></th>
            <td><?= $this->Number->format($rate->rater_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ratee Id') ?></th>
            <td><?= $this->Number->format($rate->ratee_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Bidinfo Id') ?></th>
            <td><?= $this->Number->format($rate->bidinfo_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Rate Value') ?></th>
            <td><?= $this->Number->format($rate->rate_value) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($rate->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($rate->modified) ?></td>
        </tr>
    </table>
</div>
