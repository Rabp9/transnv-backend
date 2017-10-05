<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Noticia $noticia
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Noticia'), ['action' => 'edit', $noticia->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Noticia'), ['action' => 'delete', $noticia->id], ['confirm' => __('Are you sure you want to delete # {0}?', $noticia->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Noticias'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Noticia'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="noticias view large-9 medium-8 columns content">
    <h3><?= h($noticia->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Titulo') ?></th>
            <td><?= h($noticia->titulo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Portada') ?></th>
            <td><?= h($noticia->portada) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($noticia->id) ?></td>
        </tr>
    </table>
    <div class="row">
        <h4><?= __('Resumen') ?></h4>
        <?= $this->Text->autoParagraph(h($noticia->resumen)); ?>
    </div>
    <div class="row">
        <h4><?= __('Contenido') ?></h4>
        <?= $this->Text->autoParagraph(h($noticia->contenido)); ?>
    </div>
</div>
