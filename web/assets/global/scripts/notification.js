var mensajes = {
    login: {
        server: [
            'Ha ocurrido un problema en el servidor'
        ],
        access: [
            'Credenciales invalidas'
        ]
    },
    config: {
        ini: [
            'La aplicación ya ha sido previamente iniciada',
            'La aplicación no ha podido iniciarse correctamente',
            'Aplicación iniciada correctamente'
        ],
        edit: [
            'La configuracion no ha podido ser editada',
            'Configuracion editada correctamente'
        ]
    },
    user: {
        add: [
            'Usuario añadido correctamente',
            'El usuario no ha podido ser añadido'
        ],
        edit: [
            'Usuario editado correctamente',
            'El usuario no ha podido ser editado'
        ],
        delete: [
            'Usuario eliminado correctamente',
            'El usuario no ha podido ser eliminado'
        ],
        password:{
            length: "La contraseña debe tener al menos 6 caracteres",
            wrong: 'La contraseña introducida es incorrecta',
            invalid: 'La contraseña no ha podido ser cambiada',
            valid: 'La contraseña ha sido modificada'
        }
    },
    department: {
        add: [
            'Departamento añadido correctamente',
            'El departamento no ha podido ser añadido'
        ],
        edit: [
            'Departamento editado correctamente',
            'El departamento no ha podido ser editado'
        ],
        delete: [
            'Departamento eliminado correctamente',
            'El departamento no ha podido ser eliminado'
        ]
    },
    matter: {
        add: [
            'Materia añadida correctamente',
            'La materia no ha podido ser añadida'
        ],
        edit: [
            'Materia editada correctamente',
            'La materia no ha podido ser editada'
        ],
        delete: [
            'Materia eliminada correctamente',
            'La materia no ha podido ser eliminada'
        ],
        select:[
            'Materia seleccionada correctamente',
            'No se ha podido seleccionar la materia'
        ],
        deselect:[
            'Materia deseleccionada',
            'No se ha podido deseleccionar la materia'
        ],
        priority:[
            'Prioridad cambiada correctamente',
            'No se ha podido cambiar la prioridad correctamente'
        ]
    },
    exencion: {
        select:[
            'Exencion seleccionada correctamente',
            'No se ha podido seleccionar la exencion'
        ],
        deselect:[
            'Exencion deseleccionada',
            'No se ha podido deseleccionar la exencion'
        ]
    }
};


function notificacion(mensaje) {
    var notification;
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-full-width",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    switch (mensaje) {
        case 'login_server': {
            notification = toastr["error"](mensajes['login']['server'][0], "Error");
            break;
        }
        case 'login_credentials': {
            notification = toastr["warning"](mensajes['login']['access'][0], "Error");
            break;
        }
        case 'config_notedited': {
            notification = toastr["error"](mensajes['config']['edit'][0], "Configuración");
            break;
        }
        case 'config_edited': {
            notification = toastr["success"](mensajes['config']['edit'][1], "Configuración");
            break;
        }
        case 'config_inited': {
            notification = toastr["warning"](mensajes['config']['ini'][0], "Configuración");
            break;
        }
        case 'config_notini': {
            notification = toastr["error"](mensajes['config']['ini'][1], "Configuración");
            break;
        }
        case 'config_ini': {
            notification = toastr["success"](mensajes['config']['ini'][2], "Configuración");
            break;
        }
        case 'user_notadded': {
            notification = toastr["error"](mensajes['user']['add'][1], "Usuario");
            break;
        }
        case 'user_added': {
            notification = toastr["success"](mensajes['user']['add'][0], "Usuario");
            break;
        }
        case 'user_notedited': {
            notification = toastr["error"](mensajes['user']['edit'][1], "Usuario");
            break;
        }
        case 'user_edited': {
            notification = toastr["success"](mensajes['user']['edit'][0], "Usuario");
            break;
        }
        case 'user_notdeleted': {
            notification = toastr["error"](mensajes['user']['delete'][1], "Usuario");
            break;
        }
        case 'user_deleted': {
            notification = toastr["success"](mensajes['user']['delete'][0], "Usuario");
            break;
        }
        case 'user_pass_length':{
            notification = toastr["error"](mensajes['user']['password']['length'], "Usuario");
            break;
        }
        case 'user_pass_notchange':{
            notification = toastr["error"](mensajes['user']['password']['invalid'], "Usuario");
            break;
        }
        case 'user_pass_change':{
            notification = toastr["error"](mensajes['user']['password']['valid'], "Usuario");
            break;
        }
        case 'user_pass_wrong':{
            notification = toastr["error"](mensajes['user']['password']['wrong'], "Usuario");
            break;
        }
        case 'department_notadded': {
            notification = toastr["error"](mensajes['department']['add'][1], "Departamento");
            break;
        }
        case 'department_added': {
            notification = toastr["success"](mensajes['department']['add'][0], "Departamento");
            break;
        }
        case 'department_notedited': {
            notification = toastr["error"](mensajes['department']['edit'][1], "Departamento");
            break;
        }
        case 'department_edited': {
            notification = toastr["success"](mensajes['department']['edit'][0], "Departamento");
            break;
        }
        case 'department_notdeleted': {
            notification = toastr["error"](mensajes['department']['delete'][1], "Departamento");
            break;
        }
        case 'department_deleted': {
            notification = toastr["success"](mensajes['department']['delete'][0], "Departamento");
            break;
        }
        case 'matter_notadded': {
            notification = toastr["error"](mensajes['matter']['add'][1], "Materia");
            break;
        }
        case 'matter_added': {
            notification = toastr["success"](mensajes['matter']['add'][0], "Materia");
            break;
        }
        case 'matter_notedited': {
            notification = toastr["error"](mensajes['matter']['edit'][1], "Materia");
            break;
        }
        case 'matter_edited': {
            notification = toastr["success"](mensajes['matter']['edit'][0], "Materia");
            break;
        }
        case 'matter_notdeleted': {
            notification = toastr["error"](mensajes['matter']['delete'][1], "Materia");
            break;
        }
        case 'matter_deleted': {
            notification = toastr["success"](mensajes['matter']['delete'][0], "Materia");
            break;
        }
        case 'matter_notdeselect': {
            notification = toastr["error"](mensajes['matter']['deselect'][1], "Materia");
            break;
        }
        case 'matter_deselect': {
            notification = toastr["success"](mensajes['matter']['deselect'][0], "Materia");
            break;
        }
        case 'matter_notselect': {
            notification = toastr["error"](mensajes['matter']['select'][1], "Materia");
            break;
        }
        case 'matter_select': {
            notification = toastr["success"](mensajes['matter']['select'][0], "Materia");
            break;
        }
        case 'matter_notprioritychange': {
            notification = toastr["error"](mensajes['matter']['priority'][1], "Materia");
            break;
        }
        case 'matter_prioritychange': {
            notification = toastr["success"](mensajes['matter']['priority'][0], "Materia");
            break;
        }
        case 'exencion_notdeselect': {
            notification = toastr["error"](mensajes['exencion']['deselect'][1], "Exencion");
            break;
        }
        case 'exencion_deselect': {
            notification = toastr["success"](mensajes['exencion']['deselect'][0], "Exencion");
            break;
        }
        case 'exencion_notselect': {
            notification = toastr["error"](mensajes['exencion']['select'][1], "Exencion");
            break;
        }
        case 'exencion_select': {
            notification = toastr["success"](mensajes['exencion']['select'][0], "Exencion");
            break;
        }
    }
}
