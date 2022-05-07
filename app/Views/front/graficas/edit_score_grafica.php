<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Editar gráfica<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="wrapper_boxs">
    <div class="box-content startFlex">
    <div class="title">
            <h2>Datos generales</h2>
            <span>Información principal de la gráfica</span>
        </div>
        <div class="wrapper">
            <form method="post" class="Form max768" id="edit_grafica">
                <div class="input">
                    <label for="name">Nombre</label>
                    <input type="text" disabled value="<?= $grafica['nombre'] ?>">
                </div>
                <div class="group-input">
                    <div class="input">
                        <label for="mod_id">Modalidad</label>
                        <input type="text" disabled value="<?= $grafica['modalidad'] ?>">
                    </div>
                    <div class="input">
                        <label for="nivel_id">Nivel</label>
                        <input type="text" disabled value="<?= $grafica['descrip_niv'] ?> (<?= $grafica['rango'] ?>)">
                    </div>
                </div>
                <div class="input">
                    <label for="number_participants">No. de Participantes</label>
                    <input type="text" disabled value="<?= $grafica['no_participantes'] ?>">
                </div>
                <p id="total"></p>
                <div class="group-buttons">
                    <?php if ($grafica['status'] === 'EN_CURSO') { ?>
                        <button class="cancel" type="button" onclick="cancelGrafica()">Cancelar gráfica</button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>

    <div class="box-content startFlex">
        <div class="title">
            <h2>Matchs</h2>
            <span>Lista de Matchs</span>
        </div>
        <div class="wrapper">
            <div class="wrapper_matchs" id="matchs_template">
                
            </div>
        </div>
    </div>
</div>

<script>

function cancelGrafica() {
        swal({
                title: "¿Estas seguro que cancelar la gráfica?",
                text: "Al cancelar la grafica se regresaran habilitaran los participantes para nuevas gráficas.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    AJAXUpdateCancelGrafica(<?= $grafica['id'] ?>, function(res) {
                        const { status, data } = res;
                        if (status === 'ok') {
                            history.back();
                        }

                        if (status === 'error') {
                            swal("Ocurrió un error!", data, "error");
                        }
                    });
                }
            });
    }

    function playerTemplate(position, id_match) {
        const templateSelect = `
            <div class="score-match">
                <input type="text" value="" id="player-${position}-${id_match}" class="player-name" disabled>
                <input type="number" value="0" id="score-${position}-${id_match}" class="player-score">
            </div>
        `;

        return templateSelect;
    }

    function roundNumber (no_match, total) {
        switch(total) {
            case 4:
                if (no_match === '1' || no_match == '2') return '1';
                if (no_match === '3') return '2';
                break;
            case 8:
                if (no_match === '1' || no_match == '2' || no_match == '3' || no_match == '4') return '1';
                if (no_match === '5' || no_match == '6') return '2';
                if (no_match === '7') return '3';
                break;
            case 16:
                break;
        }
    }

    function saveScores (match_id) {

        const score_left = $(`#score-left-${match_id}`).val();
        const score_right = $(`#score-right-${match_id}`).val();

        const data = {
            match_id: match_id,
            left_player_score: score_left,
            right_player_score: score_right,
        };

        swal({
                title: "¿La información de la puntuación es correcta?",
                text: "No se podra editar la puntuación una vez se suban los cambios.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    AJAXSaveScoresMatch(data, function (res) {
                        const { status, data } = res;
                        if (status === 'ok') {
                            document.location.reload();
                        }

                        if (status === 'error') {
                            swal("Ocurrió un error!", data, "error");
                        }
                    });                
                }
            });

    }

    $(document).ready(function() {
        const no_participantes = <?= $grafica['no_participantes'] ?>;
        
        AJAXGetMatchsGrafica(<?= $grafica['id'] ?>, function(res) {
            const { status, data } = res;
        
            if (status === 'ok') {
                let template = '';
                for (let i = 0; i < data.length; i++) {
                    const e = data[i];
                    let player_left = '', player_right = '';

                    player_left = playerTemplate('left', e.match_id);
                    player_right = playerTemplate('right', e.match_id);

                    const string_match = `
                    <div class="match_round">
                        <h2>Round ${roundNumber(e.no_match, no_participantes)} - ${e.nombre_area}</h2>
                            <div class="matchs">
                                ${player_left}
                                <span>VS</span>
                                ${player_right}
                            </div>
                        <button class="btn_save" onclick="saveScores(${e.match_id})">Guardar</button>
                    </div>
                    
                    `;
                    template += string_match;
                }
                $('#matchs_template').append(template);
            }

            AJAXGetMatchsGrafica(<?= $grafica['id'] ?>, function(res) {
                const { status, data } = res;
                
                if (status === 'ok') {
                    for (let i = 0; i < data.length; i++) {
                        const e = data[i];
                        console.log(e);
                        if (e.right_player)  {
                            var result = $.ajax({
                                url: `${base_url}/eventos/participante/${e.right_player}`,
                                'async': false,
                                type: 'GET'
                            })
                            .done(function(data) {
                                const { data: dataParticipante, status } = data;
                                if (status === 'ok') {
                                    const name = `${dataParticipante.ParticipanteNombre} ${dataParticipante.ParticipanteApellidos}`;
                                    $(`#player-right-${e.match_id}`).val(name);
                                }
                            })

                            if (e.score_right) {
                                const score = parseFloat(e.score_right);
                                $(`#score-right-${e.match_id}`).val(score);
                                $(`#score-right-${e.match_id}`).prop( "disabled", true )
                            }
                        }

                        if (e.left_player)  {
                            var result = $.ajax({
                                url: `${base_url}/eventos/participante/${e.left_player}`,
                                'async': false,
                                type: 'GET'
                            })
                            .done(function(data) {
                                const { data: dataParticipante, status } = data;
                                if (status === 'ok') {
                                    const name = `${dataParticipante.ParticipanteNombre} ${dataParticipante.ParticipanteApellidos}`;
                                    $(`#player-left-${e.match_id}`).val(name);
                                }
                            })

                            if (e.score_left) {
                                const score = parseFloat(e.score_left);
                                $(`#score-left-${e.match_id}`).val(score);
                                $(`#score-left-${e.match_id}`).prop( "disabled", true )
                            }
                        }

                    }
                }
            }, 'matchs_template');

        },);

    });
</script>

<?= $this->endSection() ?>