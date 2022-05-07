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

                    <?php if ($grafica['editable'] === '1') { ?>
                        <button class="success" type="button" onclick="saveGrafica()">Terminar edición</button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>

    <div class="box-content startFlex">
        <div class="title">
            <h2>Matchs</h2>
            <span>Edita los matchs correspondientes a la gráfica</span>
        </div>
        <div class="wrapper">
            <div class="wrapper_matchs" id="matchs_template">

            </div>
        </div>
    </div>
</div>

<script>
    function roundNumber(no_match, total) {
        switch (total) {
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

    function updateMatch(match_id) {
        const player_left = $(`#select-left-${match_id}`).val();
        const player_right = $(`#select-right-${match_id}`).val();
        
        const _data = {
            match_id: match_id,
            left_player_id: player_left,
            right_player_id: player_right,
        };

        swal({
                title: "¿La información del match es correcta?",
                text: "",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    AJAXUpdateMatch(_data, function(res){
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

    function saveGrafica() {
        swal({
                title: "¿La información de la grafica es correcta?",
                text: "Una vez termine la edición de los matchs, no se podrán editar.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    AJAXUpdateSaveGrafica(<?= $grafica['id'] ?>, function(res) {
                        const { status, data } = res;
                        if (status === 'ok') {
                            document.location.reload()
                        }

                        if (status === 'error') {
                            swal("Ocurrió un error!", data, "error");
                        }
                    });
                }
            });
    }

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

    function getAllAreasEnabled(area_id) {
        /*  AJAXGetAllAreasEnabled(function (res) {
             
             const { data, status } = res;
             
             if (status === 'ok') {
                 const selected = `
                     <select id="player_${position}_${match_id}" class="selected-area">
                         <option value="${id_registro}">${nombre} ${apellidos} (seleccionado)</option>
                         <option value="empty">** ELIMINAR PARTICIPANTE **</option>
                     </select>
                 `;
             }
         }); */
    }

    function playerTemplate(position, id_match) {
        const templateSelect = `
            <div class="select-data">
                <select class="data-participantes" id="select-${position}-${id_match}">
                </select>
            </div>
        `;

        return templateSelect;
    }

    function playerSelected(id_registro, position, id_match) {
        $(`#select-${position}-${id_match}`).val(id_registro ? id_registro : 'empty');
        $(`#select-${position}-${id_match}`).trigger('change.select2');
    }

    $(document).ready(function() {
        const no_participantes = <?= $grafica['no_participantes'] ?>;
        const modalidad_id = <?= $grafica['modalidad_id'] ?>;
        const editable_grafica = <?= $grafica['editable'] ?>;
        
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
                        ${editable_grafica ? `<button class="btn_save" onclick="updateMatch(${e.match_id})">Guardar</button>` : ''}
                    </div>
                    
                    `;
                    template += string_match;
                }
                $('#matchs_template').append(template);

                for (let i = 0; i < data.length; i++) {
                    const e = data[i];
                    playerSelected(e.left_player, 'left', e.match_id);
                    playerSelected(e.right_player, 'right', e.match_id);
                }
            }
        }, 'matchs_template');

        AJAXGetAllParticipantesEvent(function(res) {
            const { status, data } = res;
            const allParticipantesData = [{ id: 'empty', text: 'Sin jugador' }];
            
            for (let i = 0; i < data.length; i++) {
                const participante = data[i];
                
                if (participante.ModalidadID !== modalidad_id.toString()) continue;
                const findNivel =  allParticipantesData.find((e) => e.text === participante.NombreNivel);
                if (!findNivel) {
                    allParticipantesData.push({ text: participante.NombreNivel, children: [] });
                }
                const arr = allParticipantesData.find(e => e.text === participante.NombreNivel);
                const status = participante.StatusParticipante === "ASIGNADO" ? "(En match)" : "(Sin match)"
                arr.children.push({ 
                    id: participante.RegistroID, 
                    text: `${participante.NombreParticipante} ${participante.ApellidosParticipante} ${status}` 
                });
            }

            $(".data-participantes").select2({
                data: allParticipantesData
            })

           if (!editable_grafica)  $(".data-participantes").prop("disabled", true);

            $(".data-participantes").select2({ dropdownCssClass: "font-size-84rem" });

            AJAXGetMatchsGrafica(<?= $grafica['id'] ?>, function(res) {
                const { status, data } = res;
                
                if (status === 'ok') {
                    for (let i = 0; i < data.length; i++) {
                        const e = data[i];
                        playerSelected(e.left_player, 'left', e.match_id);
                        playerSelected(e.right_player, 'right', e.match_id);
                    }
                }
            }, 'matchs_template');
            
        })


    });
</script>

<?= $this->endSection() ?>