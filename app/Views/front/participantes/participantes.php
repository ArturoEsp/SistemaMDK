<?= $this->extend('layouts/body') ?>

<?= $this->section('title-page') ?>Lista de Participantes<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="wrapper_boxs">
    <div class="box-content startFlex">
        <div class="title">
            <h2>Agregar participante</h2>
            <span>Ingresa un alumno a tu escuela</span>
        </div>
        <div class="wrapper">
            <form class="Form max768" id="create_student">

                <div class="group-input">
                    <div class="input">
                        <label for="">Nombre</label>
                        <input type="text" name="name" id="name" placeholder="Nombre del participante">
                    </div>
                    <div class="input">
                        <label for="">Apellidos</label>
                        <input type="text" name="lastname" id="lastname" placeholder="Apellidos">
                    </div>
                    <div class="input">
                        <label for="age">Edad</label>
                        <input type="number" name="age" id="age">
                    </div>
                </div>
                <div class="group-input">
                    <div class="input">
                        <label for="sexo">Sexo</label>
                        <select name="sexo" id="sexo">
                            <option value="1">Mujer</option>
                            <option value="0">Hombre</option>
                        </select>
                    </div>
                    <div class="input">
                        <label for="height">Altura (centímetros)</label>
                        <input type="number" name="height" id="height">
                    </div>
                    <div class="input">
                        <label for="weight">Peso (Kilogramos)</label>
                        <input type="number" name="weight" id="weight">
                    </div>
                </div>

                <div class="group-input">
                    <div class="input">
                        <label for="">Categoría</label>
                        <select name="categories" id="categories">
                            <option disabled selected>** SELECCIONA **</option>

                        </select>
                    </div>
                    <div class="input">
                        <label for="type_student">Tipo de alumno</label>
                        <select name="type_student" id="type_student">
                            <option disabled selected>** SELECCIONA **</option>
                            <?php foreach ($tipos_alumno as $tipo) : ?>
                                <option value="<?= $tipo['id_ta'] ?>"><?= $tipo['ta_descrip'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="input">
                        <label for="level">Nivel</label>
                        <select name="level" id="level">
                            <option disabled selected>** SELECCIONA **</option>
                        </select>
                    </div>
                </div>

                <div class="input">
                    <label for="school_id">Escuela asignada</label>
                    <select name="school_id" id="school_id">
                        <option disabled selected>** SELECCIONA ESCUELA **</option>
                        <?php foreach ($schools as $value) : ?>
                            <option value="<?= $value['id_escuela'] ?>"><?= $value['nombre'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="input">
                    <label for="photo">Fotografiá</label>
                    <input type="file" name="photo" id="photo">
                </div>

                <div class="group-buttons">
                    <button class="success" type="submit" id="edit-save">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="box-content startFlex">
        <div class="title">
            <h2>Participantes de</h2>
            <span>Lista de participantes registrados</span>
        </div>
        <div class="wrapper">
            <div class="filter-search">
                <div class="search-input">
                    <input type="text" id="search" placeholder="Buscar...">
                    <button><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>

                <div class="dropdown-list">
                <select name="filter_school" id="filter_school">
                        <?php foreach ($schools as $value) : ?>
                            <option selected value="<?= $value['id_escuela'] ?>"><?= $value['nombre'] ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>
            <div class="wrapper_students" id="students">

            </div>
        </div>
    </div>
</div>

<script>
    function listStudents(id = null) {

        AJAXStudentsBySchool(id, function(res) {

            const data = res.data;
            console.log(data)
            $('#students').empty();
            for (let i = 0; i < data.length; i++) {
                const e = data[i];
                $('#students').append(`
            <div class="item">
                    <div class="photo">
                        <img src="uploads/${e.fotografia ? e.fotografia : 'custom.png'}" alt="">
                    </div>
                    <div class="information">
                        <div class="row green">
                            <span>${e.nombres} ${e.apellidos}</span>
                            <span>ID ${e.id_alumno}</span>
                        </div>
                        <div class="row ">
                            <span>${e.edad} años</span>
                            <span>Control # 1</span>
                        </div>
                        <div class="row green">
                            <span>${e.sexo === '1' ? 'Mujer' : 'Hombre'}</span>
                            <span>${e.altura} cm., ${e.peso} kg.</span>
                        </div>
                        <div class="row ">
                            <span>Alissa</span>
                            <span>Control # 1</span>
                        </div>
                    </div>
                </div>
            `);

            }
        })
    }
    $(document).ready(function() {

        listStudents($('#filter_school').val());

        $('#weight').keyup(function(e) {
            listCategories(this.value, null)
        });

        $('#sexo').change(function(e) {
            e.preventDefault();
            listCategories(null, this.value)
        });

        $('#age').keyup(function(e) {
            const age = this.value ? this.value : null;
            listLevels(age)
        });

        $('#filter_school').change(function(e) {
            e.preventDefault();
            listStudents(this.value);
        });


        $("#create_student").validate({
            rules: {
                name: "required",
                lastname: "required",
                age: "required",
                weight: "required",
                height: "required",
                type_student: "required",
                school_id: 'required'
            },
            messages: {
                name: {
                    required: "Ingresa el nombre del alumno",
                },
                lastname: {
                    required: "Ingresa el apellido del alumno",
                },
                age: {
                    required: "Ingresa la edad",
                },
                weight: {
                    required: "Ingresa el peso",
                },
                height: {
                    required: "Ingresa la altura",
                },
                type_student: {
                    required: "Selecciona el tipo de alumno",
                },
                school_id: {
                    required: "Selecciona la escuela asignada",
                },

            },
            submitHandler: function(form) {
                onSubmitForm();
                form.reset();
            }
        });

    });

    function listCategories(weight = null, genre = null) {
        const _genre = genre ? genre : $('#sexo').val();
        const _weight = weight ? weight : $('#weight').val();

        AJAXGetCategoriesByFilter(_weight, _genre, function(res) {
            const data = res?.data;

            $('#categories').empty();
            for (let i = 0; i < data.length; i++) {
                const e = data[i];
                $('#categories').append("<option value=" + e.id_categoria + ">" + `${e.nom_cat} (${e.rango})` + "</option>");
            }
        });
    }

    function listLevels(age = 0) {
        AJAXGetLevelsByAge(age, function(res) {
            const data = res?.data;

            $('#level').empty();
            for (let i = 0; i < data.length; i++) {
                const e = data[i];
                $('#level').append("<option value=" + e.id_nivel + ">" + `${e.descrip_niv} (${e.rango})` + "</option>");
            }
        });
    }

    function onSubmitForm() {
        const photo = $('#photo').prop('files')[0];

        let formData = new FormData();
        formData.append('name', $('#name').val());
        formData.append('lastname', $('#lastname').val());
        formData.append('age', $('#age').val());
        formData.append('sexo', $('#sexo').val());
        formData.append('height', $('#height').val());
        formData.append('weight', $('#weight').val());
        formData.append('type_category', $('#categories').val());
        formData.append('type_student', $('#type_student').val());
        formData.append('type_nivel', $('#level').val());
        formData.append('school_id', $('#school_id').val());

        formData.append('photo', photo);

        AJAXSaveStudent(formData, function(res) {
            const { status } = res;
            if (status === 'ok')
                listStudents($('#filter_school').val());
        })

    }
</script>

<?= $this->endSection() ?>