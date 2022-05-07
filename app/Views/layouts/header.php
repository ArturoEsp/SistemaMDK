<?php
$session = session();
$URI = service('request')->uri->getPath();
?>

<header class="header">
    <div class="logo">
        <img src="<?= base_url() ?>/assets/images/logo.png" alt="logotipo">
    </div>
    <div class="menu_container">
        <ul class="items">
            <?php
            if (!$session->get('menu')) {
                echo '<li class="button login"><a href="/login" rel="noopener noreferrer">Login</a></li>';
            } else {
                echo "<li class='" . ($URI === '/' ? 'current' : null) . "'><a href='/' rel='noopener noreferrer' data-hover='Inicio'>Inicio</a></li>";
                if ($session->get('menu')['usuarios'])
                    echo "<li class='" . ($URI === 'users' ? 'current' : null) . "'><a href='/users' rel='noopener noreferrer' data-hover='Usuarios'>Usuarios</a></li>";
                if ($session->get('menu')['escuelas'])
                    echo "<li  class='" . ($URI === 'escuelas' ? 'current' : null) . "'><a href='/escuelas' rel='noopener noreferrer' data-hover='Escuelas'>Escuelas</a></li>";
                if ($session->get('menu')['areas'])
                    echo "<li  class='" . ($URI === 'areas' ? 'current' : null) . "'><a href='/areas' rel='noopener noreferrer' data-hover='Areas'>Areas</a></li>";
                if ($session->get('menu')['participantes'])
                    echo "<li class='" . ($URI === 'participantes' ? 'current' : null) . "'><a href='/participantes' rel='noopener noreferrer' data-hover='Participantes'>Participantes</a></li>";
                if ($session->get('menu')['eventos'])
                     echo "<li class='" . ($URI === 'eventos' ? 'current' : null) . "'><a href='/eventos' rel='noopener noreferrer' data-hover='Eventos'>Eventos</a></li>";
                if ($session->get('menu')['pase_lista'])
                    echo '<li><a href="" rel="noopener noreferrer" data-hover="Asistencia">Asistencia</a></li>';

                echo '<li class="button logout"><a href="/logout" rel="noopener noreferrer">Salir</a></li>';
            }

            ?>
        </ul>
    </div>
</header>