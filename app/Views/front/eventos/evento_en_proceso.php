<?php
$event = session('event');
?>

<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Evento en proceso<?= $this->endSection() ?>

<?= $this->section('content') ?>


<div class="box-content">
    <div class="title">
        <h2><?= $event['nombre'] ?></h2>
        <span>Evento en proceso</span>
    </div>
    <div class="wrapper">
        <form class="Form max768">
            <div class="input">
                <label for="name">Nombre</label>
                <input type="text" value="<?=$event['nombre']?>" disabled>
            </div>
            <div class="input">
                <label for="description">Descripción</label>
                <input type="text" value="<?=$event['descripcion']?>" disabled>
            </div>
            <div class="group-input">
                <div class="input">
                    <label for="date_start">Fecha de inicio</label>
                    <input type="text" value="<?=$event['fecha_inicio']?>" disabled>
                </div>
                <div class="input">
                    <label for="date_end">Fecha de finalización</label>
                    <input type="text" value="<?=$event['fecha_fin']?>" disabled>
                </div>
            </div>
            <div class="input">
                <label for="place">Lugar</label>
                <input type="text" value="<?=$event['lugar']?>" disabled>
            </div>
            <div class="input">
                <label for="place">Modalidades</label>
                <input type="text" value="<?=$event['lugar']?>" disabled>
            </div>

            <div class="group-buttons">
                <button class="success" type="submit" onclick="onSubmitEvent()">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {


    });
</script>


<?= $this->endSection() ?>