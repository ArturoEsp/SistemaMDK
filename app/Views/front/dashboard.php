<?php
$session = session();
?>

<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Bienvenido | Sistema MDK<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="dashboard-div">


    <?php if ($session->get('menu')['usuarios']) : ?>
        <div class="box-content startFlex">
            <div class="title">
                <h2>Usuarios</h2>
                <span>Gestiona la lista de usuarios</span>
            </div>
            <div class="wrapper">
                <div class="icon">
                    <a href="/users">
                        <i class="fa-solid fa-user-group"></i>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($session->get('menu')['areas']) : ?>
        <div class="box-content startFlex">
            <div class="title">
                <h2>Gráficas</h2>
                <span>Visualiza las gráficas</span>
            </div>
            <div class="wrapper">
                <div class="icon">
                    <a href=""><i class="fa-solid fa-chart-line"></i></a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($session->get('menu')['areas']) : ?>
        <div class="box-content startFlex">
            <div class="title">
                <h2>Areas</h2>
                <span>Gestiona la lista de areas</span>
            </div>
            <div class="wrapper">
                <div class="icon">
                    <a href="/areas"><i class="fa-solid fa-clone"></i></a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($session->get('menu')['eventos']) : ?>
        <div class="box-content startFlex">
            <div class="title">
                <h2>Eventos</h2>
                <span>Visualiza los eventos en el sistema</span>
            </div>
            <div class="wrapper">
                <div class="icon">
                    <a href=""><i class="fa-solid fa-calendar-day"></i></a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($session->get('menu')['participantes']) : ?>
        <div class="box-content startFlex">
            <div class="title">
                <h2>Participantes</h2>
                <span>Lista de participantes</span>
            </div>
            <div class="wrapper">
                <div class="icon">
                    <a href="/participantes"><i class="fa-solid fa-medal"></i></a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($session->get('menu')['escuelas']) : ?>
        <div class="box-content startFlex">
            <div class="title">
                <h2>Escuelas</h2>
                <span>Gestiona la lista las escuelas</span>
            </div>
            <div class="wrapper">
                <div class="icon">
                    <a href="/escuelas"><i class="fa-solid fa-house-chimney-window"></i></a>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!--   
    <div class="box-content startFlex">
        <div class="title">
            <h2>Asistencia</h2>
            <span>Registra la asistencia de los participantes</span>
        </div>
        <div class="wrapper">
            <div class="icon">
                <a href=""><i class="fa-solid fa-check-to-slot"></i></a>
            </div>
        </div>
    </div>
 -->

    <div class="box-content startFlex">
        <div class="title">
            <h2>Salir</h2>
            <span>Salir de tu cuenta</span>
        </div>
        <div class="wrapper">
            <div class="icon">
                <a href="/logout"><i class="fa-solid fa-right-from-bracket"></i></a>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection() ?>