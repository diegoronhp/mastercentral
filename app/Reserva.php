<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


/*************************************************************** */
/*****************DIEGO MAURICIO MANCERA SUAREZ***************** */
/*************************************************************** */

class Reserva extends Model
{
        //POR MEDIO DE LA DECLARACION DE ESTA VARIABLE EN LA CLASE DEL MODELO ESTABLEZCO CONEXION CON LA TABLA reserva DE LA BASE DE DATOS
        protected $table = 'reserva';

        //POR MEDIO DE LA DECLARACION DE ESTA VARIABLE EN LA CLASE DEL MODELO DEFINO LOS CAMPOS DE LA TABLA reserva QUE SE DEFINEN PARA EL REGISTRO EN LA BASE DE DATOS
        protected $fillable = [
            'fecha_hora_inicio','fecha_hora_fin','observaciones','id_usuario','id_laboratorio'
        ];
}
