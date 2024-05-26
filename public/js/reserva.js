/*************************************************************** */
/*****************DIEGO MAURICIO MANCERA SUAREZ***************** */
/*************************************************************** */

$(function(){
    //MANEJADOR DEL EVENTO CLIC PARA EL BOTON EDITAR DE LOS REGISTROS EN EL LISTADO DE RESERVAS
    $("button[id^='rsc_edt_']").click(function(e){
        //PREVENIR LA ACCION DEL BOTON
        e.preventDefault();

        //OBTENER EL ID DEL BOTON ACTIVADO POR EL USUARIO PARA DETERMINAR EL ID DE REGISTRO QUE VA A SER MODIFICADO
        var id_boton = e.target.id;
        console.log("id_boton = "+id_boton);
        var opcion = $("#"+id_boton).text();
        var cadena = id_boton.split("_");
        var id = cadena[2];
        console.log("id = "+id);


        //AL PULSAR EL BOTON CON EL TEXTO EDITAR EN LA PRIMERA VEZ 
        if(opcion == "Editar"){
            //PETICION DE AJAX PARA OBTENER LOS REGISTROS DE LOS laboratorios E INTEGRALOS EN EL SELECT DEL FORMULARIO DE EDICION
            $.get('/reservasshowlabs/',function(data){
                $("#rsv_des_"+id).removeAttr('disabled');
                $("#rsv_des_"+id).html("");
                $.each(data,function(fetch,laboratorios){
                    console.log(data);
                    if(laboratorios.length > 0){
                        for(i = 0 ; i < laboratorios.length ; i++){
                            $("#rsv_des_"+id).append('<option value="'+laboratorios[i].id+'">'+laboratorios[i].descripcion+'</option>');
                        }
                    }
                });
            });

            //PETICION DE AJAX PARA OBTENER LOS REGISTROS DE LOS usuarios E INTEGRALOS EN EL SELECT DEL FORMULARIO DE EDICION
            $.get('/reservasshowusers/',function(data){
                $("#rsv_nom_"+id).removeAttr('disabled');
                $("#rsv_nom_"+id).html("");
                $.each(data,function(fetch,usuarios){
                    console.log(data);
                    if(usuarios.length > 0){
                        for(i = 0 ; i < usuarios.length ; i++){
                            $("#rsv_nom_"+id).append('<option value="'+usuarios[i].id+'">'+usuarios[i].nombre+'</option>');
                        }
                    }
                });
            })

            //ASIGNAR AL ATRIBUTO action DEL FORMULARIO DE EDICION LA url DE LA RUTA ENVIANDO COMO PARAMETRO EL ID DEL REGISTRO POR EDITAR
            $("#rsv_upt").attr('action','http://mastercentral.test/reservaupdate/'+id);
            
            //HABILITAR LOS CAMPOS BLOQUEADOS EN EL FORMULARIO DE EDICION PARA EL REGISTROS SELECCIONADO POR EL USUARIO PARA QUE LOS PUEDA MODIFICAR
            $("#rsv_obs_"+id).removeAttr('disabled');

            //BLOQUEAR LOS BOTONES DE EDICION Y ELIMINACION DE TODOS LOS REGISTROS
            $("button[id^='rsv_edt_']").attr('disabled','disabled');
            $("button[id^='rsv_elm_']").attr('disabled','disabled');

            //HABILITAR EL BOTON DE EDICION DEL REGISTRO SELECCIONADO POR EL USUARIO Y MODIFICAR SU ESTILO Y SU TEXTO DE EDITAR A GUARADR
            $("#rsv_edt_"+id).removeAttr('disabled');
            $("#"+id_boton).text("Guardar").removeClass("btn-warning").addClass("btn-success");
        }

        //AL PULSAR EL BOTON CON EL TEXTO GUARDAR EN LA SEGUNDA VEZ
        if(opcion == "Guardar"){
            //EJECUTAR EL SUBMIT DEL FORMULARIO DE EDICION
            $("#rsv_upt").submit();
        }
    });

    //MANEJADOR DEL EVENTO CLIC PARA EL BOTON ELIMINAR DE LOS REGISTROS EN EL LISTADO DE RESERVAS
    $("button[id^='rsv_elm_']").click(function(e){
        //PREVENIR LA ACCION DEL BOTON
        e.preventDefault();

        //OBTENER EL ID DEL BOTON ACTIVADO POR EL USUARIO PARA DETERMINAR EL ID DE REGISTRO QUE VA A SER ELIMINADO
        var id_boton = e.target.id;
        var opcion = $("#"+id_boton).text();
        var cadena = id_boton.split("_");
        var id = cadena[2];

        //DESPELGAR VENTANA MODAL DE ADVERTENCIA EN EL FORMULARIO PARA OBTENER LA CONFIRMACION DE ELIMINACION DEL REGISTRO POR PARTE DEL USUARIO 
        $("#mod_warn").prop('style','display: block');
        $("#mod_warn .modal-footer button").on("click",function(e){
            var decision = e.target.id;

            //SI EL USUARIO CONFIRMA LA ELIMINACION DEL REGISTRO
            if(decision == "confirm"){
                //ASIGNAR AL ATRIBUTO action DEL FORMULARIO DE EDICION LA url DE LA RUTA ENVIANDO COMO PARAMETRO EL ID DEL REGISTRO POR ELIMINAR Y AL FINA SE EJECUTA EL SUBMIT DEL FORMULARIO DE EDICION
                $("#rsv_upt").attr('action','http://mastercentral.test/reservadelete/'+id).submit();
            
                //SI EL USUARIO DESISTE SE OCULTA LA VENTANA MODAL DE ADVERTENCIA
            }else{
                $("#mod_warn").prop('style','display: none');
            }
        })
    })
})