<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Lista de Participantes<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="wrapper_boxs">


    <div class="demo"></div>

    <!-- <div class="box-content">
        <div class="title">
            <h2>Evento</h2>
            <span>Selecciona el evento para administrar sus graficas</span>
        </div>
        <div class="wrapper">
          
        </div>
    </div>

    <div class="box-content startFlex">
        <div class="title">
            <h2>Gráficas</h2>
            <span>Lista de participantes de mis escuelas</span>
        </div>
        <div class="wrapper">
        </div>
    </div> -->
</div>

<script>

    function getPositionArray (total, no_match) {
        switch(total) {
            case 4:
                if (no_match === '1' || no_match == '2') return 0;
                if (no_match === '3') return 1;
                break;
            case 8:
                if (no_match === '1' || no_match == '2' || no_match == '3' || no_match == '4') return 0;
                if (no_match === '5' || no_match == '6') return 1;
                if (no_match === '7') return 2;
                break;
            case 16:
                break;
        }
    }

    $(document).ready(function() {
        AJAXGetMatchsGrafica(<?= $grafica['id'] ?>, function(res) {
            console.log(res);

            const { status, data } = res;

            if (status === 'ok') {
                let dataSingleElimination = { 
                    teams: [], 
                    results : [
                            /* [[1,2], [3, null]],       
                            [[4,6], [2,1]]   */      
                        ] };

                for (let i = 0; i < data.length - 1; i++) {
                    const e = data[i];
                    const match = [];
                    const no_match = parseInt(e.no_match);
                    const no_participantes = parseInt(e.no_participantes);

                    let playerLeft = null, playerRight = null;
                    if (e.left_player_nombre) playerLeft = `${e.left_player_nombre} ${e.left_player_apellidos}`;
                    if (e.right_player_nombre) playerRight = `${e.right_player_nombre} ${e.right_player_apellidos}`;

                    match.push(playerLeft)
                    match.push(playerRight)

                    const positionArray = getPositionArray(no_participantes, e.no_match);
                    const score_left = e.left_player_score ? parseFloat(e.left_player_score) : null; 
                    const score_right = e.right_player_score ? parseFloat(e.right_player_score) : null; 

                    const scores = [score_left, score_right];
                    dataSingleElimination.results.push([]);
                    dataSingleElimination.results[positionArray].push(scores); 

                    dataSingleElimination.teams.push(match);
                }

               console.log(dataSingleElimination.results);
                $('.demo').bracket({
                    skipConsolationRound: true,
                    init: dataSingleElimination,
                    teamWidth: 240,
                });
            }
        })
    });
</script>

<?= $this->endSection() ?>