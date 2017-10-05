<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Servicio $servicio
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Servicio'), ['action' => 'edit', $servicio->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Servicio'), ['action' => 'delete', $servicio->id], ['confirm' => __('Are you sure you want to delete # {0}?', $servicio->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Servicios'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Servicio'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="servicios view large-9 medium-8 columns content">
    <h3><?= h($servicio->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Titulo') ?></th>
            <td><?= h($servicio->titulo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Subtitulo') ?></th>
            <td><?= h($servicio->subtitulo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Portada') ?></th>
            <td><?= h($servicio->portada) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($servicio->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Resumen') ?></h4>
        <?= $this->Text->autoParagraph(h($servicio->resumen)); ?>
    </div>
    <div class="row">
        <h4><?= __('Contenido') ?></h4>
        <?= $this->Text->autoParagraph(h($servicio->contenido)); ?>
    </div>
</div>
