<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Rate[]|\Cake\Collection\CollectionInterface $rates
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Rate'), ['action' => 'add']) ?></li>
    </ul>
</nav>
<div class="rates index large-9 medium-8 columns content">
    <h3><?= __('Rates') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rater_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('ratee_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('bidinfo_id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rate_value') ?></th>
                <th scope="col"><?= $this->Paginator->sort('rate_comment') ?></th>
                <th scope="col"><?= $this->Paginator->sort('created') ?></th>
                <th scope="col"><?= $this->Paginator->sort('modified') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rates as $rate): ?>
            <tr>
                <td><?= $this->Number->format($rate->id) ?></td>
                <td><?= $this->Number->format($rate->rater_id) ?></td>
                <td><?= $this->Number->format($rate->ratee_id) ?></td>
                <td><?= $this->Number->format($rate->bidinfo_id) ?></td>
                <td><?= $this->Number->format($rate->rate_value) ?></td>
                <td><?= h($rate->rate_comment) ?></td>
                <td><?= h($rate->created) ?></td>
                <td><?= h($rate->modified) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $rate->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $rate->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $rate->id], ['confirm' => __('Are you sure you want to delete # {0}?', $rate->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]) ?></p>
    </div>
</div>
