<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Lista de Participantes<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="wrapper_boxs">


    <div class="view_grafica">
        <div class="title">
            <h2><?= $grafica['nombre'] ?></h2>
        </div>
        <div class="demo"></div>
    </div>
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
            const { status, data } = res;

            if (status === 'ok') {
                let dataSingleElimination = { 
                    teams: [], 
                    results : [] 
                };

                for (let i = 0; i < data.length; i++) {
                    const e = data[i];
                    const match = [];
                    const no_match = parseInt(e.no_match);
                    const no_participantes = parseInt(e.no_participantes);

                    let playerLeft = null, playerRight = null;

                    if (no_participantes === 4) {
                        if (no_match > 2) break;
                    }

                    if (no_participantes === 8) {
                        if (no_match > 4) break;
                    }

                    if (e.left_player)  {
                        var result = $.ajax({
                            url: `${base_url}/eventos/participante/${e.left_player}`,
                            'async': false,
                            type: 'GET'
                        })
                        .done(function(data) {
                            const { data: dataParticipante, status } = data;
                            if (status === 'ok')
                                playerLeft = `${dataParticipante.ParticipanteNombre} ${dataParticipante.ParticipanteApellidos}`;
                        })
                    }

                    if (e.right_player)  {
                        var result = $.ajax({
                            url: `${base_url}/eventos/participante/${e.right_player}`,
                            'async': false,
                            type: 'GET'
                        })
                        .done(function(data) {
                            const { data: dataParticipante, status } = data;
                            if (status === 'ok')
                                playerRight = `${dataParticipante.ParticipanteNombre} ${dataParticipante.ParticipanteApellidos}`;
                        })
                    }

                    match.push(playerLeft)
                    match.push(playerRight)

                    dataSingleElimination.teams.push(match);

                }

                for (let i = 0; i < data.length; i++) {
                    const e = data[i];
                    const no_match = parseInt(e.no_match);
                    const no_participantes = parseInt(e.no_participantes);

                    const positionArray = getPositionArray(no_participantes, e.no_match);
                    const score_left = e.score_left ? parseFloat(e.score_left) : null; 
                    const score_right = e.score_right ? parseFloat(e.score_right) : null; 
                        
                    const scores = [score_left, score_right];


                    if(typeof dataSingleElimination.results[positionArray] === 'undefined') {
                        console.log('no existe');
                        dataSingleElimination.results.push([])
                        dataSingleElimination.results[positionArray].push(scores)
                    }
                    else {
                        dataSingleElimination.results[positionArray].push(scores)
                    }
                    
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