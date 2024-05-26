<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/*************************************************************** */
/*****************DIEGO MAURICIO MANCERA SUAREZ***************** */
/*************************************************************** */

class Usuario extends Model
{
    //POR MEDIO DE LA DECLARACION DE ESTA VARIABLE EN LA CLASE DEL MODELO ESTABLEZCO CONEXION CON LA TABLA usuario DE LA BASE DE DATOS
    protected $table = 'usuario';
}
