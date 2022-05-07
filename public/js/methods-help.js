function AJAXFindUsersByParams (keyWords = null, type_user = null, callBack) {
    
    let paramsSearch = '';
    if (keyWords) paramsSearch += `keyWords=${keyWords}&`;
    if (type_user) paramsSearch += `type_user=${type_user}&`;

    $.ajax({
        method : 'GET',
        url: `${base_url}/users/search-users?${paramsSearch}`,
        dataType: "JSON",
        cache: true,
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXDeleteUserById (id = null, callBack) {
    $.ajax({
        method: 'DELETE',
        url: `${base_url}/users/user?id=${id}`,
        dataType: "JSON",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXGetUserById (id = null, callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/users/user/${id}`,
        dataType: "JSON",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXUpdateUserById (id = null, data = {}, callBack) {
    $.ajax({
        method: 'POST',
        data: data,
        url: `${base_url}/users/user/${id}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

// Escuelas
function AJAXSaveSchool (data = {}, callBack) {
    $.ajax({
        method: 'POST',
        data: data,
        url: `${base_url}/escuelas/save`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXGetListTeacher (callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/escuelas/teachers`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXStoreSchool (data = {}, callBack) {
    $.ajax({
        method: 'POST',
        data: data,
        url: `${base_url}/escuelas/save`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXGetSchools (callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/escuelas/all`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXDeleteSchool (id = 0, callBack) {
    $.ajax({
        method: 'DELETE',
        url: `${base_url}/escuelas/${id}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

// Participantes

function AJAXGetCategoriesByFilter (weight = 0, genre = 0, callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/participantes/categories/${weight ? weight : 0}/${genre}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXGetLevelsByAge (age = 0, callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/participantes/levels/${age}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXSaveStudent (data = {}, callBack) {
    $.ajax({
        method: 'POST',
        url: `${base_url}/participantes/save`,
        dataType: "json",
        contentType: false,
        processData: false,
        data: data,
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXStudentsBySchool (id, callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/participantes/escuela/${id}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXStudentById (id, callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/participantes/${id}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXUpdateStudent (id, data, callBack) {
    $.ajax({
        method: 'POST',
        data: data,
        contentType: false,
        processData: false,
        url: `${base_url}/participantes/update/${id}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

// Areas

function AJAXSaveArea (data, callBack) {
    $.ajax({
        method: 'POST',
        url: `${base_url}/areas/save`,
        dataType: "json",
        data: data,
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXUpdateArea (id, data, callBack) {

    $.ajax({
        method: 'POST',
        url: `${base_url}/areas/update/${id}`,
        dataType: "json",
        data: data,
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXDeleteArea (id, callBack) {

    $.ajax({
        method: 'DELETE',
        url: `${base_url}/areas/delete/${id}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXGetAllAreas (callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/areas/all`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXGetAllAreasEnabled (callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/areas/enabled`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

// Eventos
function AJAXSaveEvent (data, callBack) {
    $.ajax({
        method: 'POST',
        data: data,
        url: `${base_url}/eventos/save`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXUpdateEvent (data, callBack) {
    $.ajax({
        method: 'POST',
        data: data,
        url: `${base_url}/eventos/update`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXGetAvailablesStudents (id_escuela, id_mod, callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/eventos/escuela/${id_escuela}/mod/${id_mod}/participantes-disponibles`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXRegisterStudentsEvent (data, callBack) {
    $.ajax({
        method: 'POST',
        data: data,
        url: `${base_url}/eventos/register`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXGetStudentsInEventBySchoolMod (school_id, mod_id, callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/eventos/escuela/${school_id}/participantes/mod/${mod_id}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXDeleteParticipanteEvent (registro_id, callBack) {
    $.ajax({
        method: 'DELETE',
        url: `${base_url}/eventos/participante/${registro_id}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXGetGraficasByEventId (event_id, callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/eventos/${event_id}/graficas`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXCancelEvent (event_id, callBack) {
    $.ajax({
        method: 'POST',
        url: `${base_url}/eventos/cancel/${event_id}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXGetAllParticipantesEvent (callBack, divLoading)  {
    $.ajax({
        method: 'GET',
        url: `${base_url}/eventos/participantes/all`,
        dataType: "json",
        beforeSend: function () { 
            $(`#${divLoading}`).addClass('loading')
        },
        success: function(res) {
           callBack(res);
           $(`#${divLoading}`).removeClass('loading')
        }
    });
}

function AJAXGetParticipanteInfoById (id_registro, callBack, divLoading)  {
    $.ajax({
        method: 'GET',
        url: `${base_url}/eventos/participante/${id_registro}`,
        dataType: "json",
        beforeSend: function () { 
            $(`#${divLoading}`).addClass('loading')
        },
        success: function(res) {
           callBack(res);
           $(`#${divLoading}`).removeClass('loading')
        }
    });
}

function AJAXGetParticipantesForGrafica(grafica_id, callBack) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/eventos/participantes/grafica/${grafica_id}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}


// Graficas

function AJAXParticipantesParamsGrafica(data, callBack) {
    $.ajax({
        method: 'POST',
        data: data,
        url: `${base_url}/graficas/participantes/params`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXCreateGrafica(data, callBack) {
    $.ajax({
        method: 'POST',
        data: data,
        url: `${base_url}/graficas/store`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXGetMatchsGrafica(id, callBack, divLoading) {
    $.ajax({
        method: 'GET',
        url: `${base_url}/graficas/info/${id}`,
        dataType: "json",
        beforeSend: function () { 
            $(`#${divLoading}`).addClass('loading')
        },
        success: function(res) {
           callBack(res);
           $(`#${divLoading}`).removeClass('loading')
        }
    });
}


function AJAXUpdateCancelGrafica(grafica_id, callBack) {
    $.ajax({
        method: 'POST',
        url: `${base_url}/graficas/cancel/${grafica_id}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXUpdateSaveGrafica(grafica_id, callBack) {
    $.ajax({
        method: 'POST',
        url: `${base_url}/graficas/save/${grafica_id}`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

// Matchs
function AJAXUpdateMatch(data, callBack) {
    $.ajax({
        method: 'POST',
        data: data,
        url: `${base_url}/matchs/update`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}

function AJAXSaveScoresMatch(data, callBack) {
    $.ajax({
        method: 'POST',
        data: data,
        url: `${base_url}/matchs/scores`,
        dataType: "json",
        success: function(res) {
            callBack(res);
        }
    });
}


