<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $controllerRole->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $controllerRole->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Controller Roles'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Controllers'), ['controller' => 'Controllers', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Controller'), ['controller' => 'Controllers', 'action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Roles'), ['controller' => 'Roles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Role'), ['controller' => 'Roles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="controllerRoles form large-9 medium-8 columns content">
    <?= $this->Form->create($controllerRole) ?>
    <fieldset>
        <legend><?= __('Edit Controller Role') ?></legend>
        <?php
            echo $this->Form->control('permiso');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
