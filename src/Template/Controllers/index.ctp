<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Controller[]|\Cake\Collection\CollectionInterface $controllers
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('New Controller'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Controller Roles'), ['controller' => 'ControllerRoles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Controller Role'), ['controller' => 'ControllerRoles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="controllers index large-9 medium-8 columns content">
    <h3><?= __('Controllers') ?></h3>
    <table cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th scope="col"><?= $this->Paginator->sort('id') ?></th>
                <th scope="col"><?= $this->Paginator->sort('descripcion') ?></th>
                <th scope="col"><?= $this->Paginator->sort('controller_name') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($controllers as $controller): ?>
            <tr>
                <td><?= $this->Number->format($controller->id) ?></td>
                <td><?= h($controller->descripcion) ?></td>
                <td><?= h($controller->controller_name) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['action' => 'view', $controller->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['action' => 'edit', $controller->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $controller->id], ['confirm' => __('Are you sure you want to delete # {0}?', $controller->id)]) ?>
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
