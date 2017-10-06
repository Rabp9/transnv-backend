<?php
/**
 * @var \App\View\AppView $this
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Controllers'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Controller Roles'), ['controller' => 'ControllerRoles', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Controller Role'), ['controller' => 'ControllerRoles', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="controllers form large-9 medium-8 columns content">
    <?= $this->Form->create($controller) ?>
    <fieldset>
        <legend><?= __('Add Controller') ?></legend>
        <?php
            echo $this->Form->control('descripcion');
            echo $this->Form->control('controller_name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
