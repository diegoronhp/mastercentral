<?php

namespace App\Http\Controllers;

use App\Laboratorio;
use App\Reserva;
use App\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/*************************************************************** */
/*****************DIEGO MAURICIO MANCERA SUAREZ***************** */
/*************************************************************** */

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //A TRAVES DE ESTAS DOS VARIABLES SE HACE LA CONSULTA EN LA BASE DE DATOS PARA OBTENER TODOS LOS REGISTROS DE LAS TABLAS laboratorio Y usuario
        $laboratorios = Laboratorio::get();
        $usuarios = Usuario::get();

        //A TRAVES DE ESTA VARIABLE SE HACE UNA CONSULTA COMPUESTA A LAS TABLAS reserva, laboratorio Y usuario DE LA BASE DE DATOS PARA OBTENER CADA REGISTRO DE RESERVAS CON EL NOMBRE DEL LABORATORIO Y DEL USUARIO 
        $reservas = DB::table('reserva')->join('laboratorio','reserva.id_laboratorio','=','laboratorio.id')
                     ->join('usuario','reserva.id_usuario','=','usuario.id')->select('reserva.*','usuario.nombre','laboratorio.descripcion')->get();
    
        //AL RETORNAR A LA VISTA PRINCIPAL INCLUYO LAS VARIABLES EN UN ARRAY ASOCIATIVO PARA MOSTRAR SUS REGISTROS EN EL FORMULARIO
        return view('reserva.reserva')->with(['laboratorios'=>$laboratorios, 'usuarios'=>$usuarios, 'reservas'=>$reservas]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //A TRAVES DE ESTE METODO SE REALIZA LA VALIDACION DE LOS CAMPOS DEL FORMULARIO
        request()->validate([
            'fecha_hora_inicio' => 'required',
            'fecha_hora_fin' => 'required'
        ]);


        //ALMACENO EN ESTAS VARIABLES LOS DATOS OBTENIDOS DESDE EL FORMULARIO DE CREACION DE RESERVA
        $id_laboratorio = $request->get('sel_lab');
        $id_usuario = $request->get('sel_usu');
        $observaciones = $request->get('obs_rsv');
        $fecha_hora_inicio = obtener_fecha_hora_con_formato($request->get('fecha_hora_inicio'));
        $fecha_hora_fin = obtener_fecha_hora_con_formato($request->get('fecha_hora_fin'));        

        //A TRAVES DE ESTE METODO SE EJECUTA LA INSERCION DEL NUEVO REGISTRO EN LA TABLA reservas DE LA BASE DE DATOS
        Reserva::create([
            'fecha_hora_inicio' => $fecha_hora_inicio,
            'fecha_hora_fin' => $fecha_hora_fin,
            'observaciones' => $observaciones,
            'id_usuario' => $id_usuario,
            'id_laboratorio' => $id_laboratorio,
        ]);

        //AL RETORNAR A LA VISTA PRINCIPAL ESTABLEZCO UN ESTADO TEMPORAL PARA DESPLEGAR UN MENSAJE AL USUARIO CON LA CONFIRMACION DE LA TRANSACCION
        return redirect()->to('reservas')->with('status','La reserva ha sido creada');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showlabs()
    {
        //A TRAVES DE ESTA VARIABLE SE HACE LA CONSULTA DE LA TABLA laboratorio EN LA BASE DE DATOS PARA OBTENER TODOS SUS REGISTROS Y OBTENERLOS EN EL FORMULARIO DE EDICION MEDIANTE UNA PETICION AJAX
        $laboratorios = Laboratorio::get();
        return with(["laboratorios" => $laboratorios]);
    }

    public function showusers()
    {
        //A TRAVES DE ESTA VARIABLE SE HACE LA CONSULTA DE LA TABLA usuario EN LA BASE DE DATOS PARA OBTENER TODOS SUS REGISTROS Y OBTENERLOS EN EL FORMULARIO DE EDICION MEDIANTE UNA PETICION AJAX
        $usuarios = Usuario::get();
        return with(["usuarios" => $usuarios]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //ALMACENO EN ESTAS VARIABLES LOS DATOS OBTENIDOS DESDE EL FORMULARIO DE EDICION DE RESERVA
        $id_laboratorio = $request->get('rsv_des_'.$id);
        $id_usuario = $request->get('rsv_nom_'.$id);
        $fecha_hora_inicio = $request->get('rsv_fec_ini_'.$id);
        $fecha_hora_fin = $request->get('rsv_fec_fin_'.$id);
        $observaciones = $request->get('rsv_obs_'.$id);

        //A TRAVES DE ESTE METODO SE EJECUTA LA EDICION DEL REGISTRO EXISTENTE EN LA TABLA reservas DE LA BASE DE DATOS
        Reserva::where('id',$id)->update([
            'id_laboratorio' => $id_laboratorio,
            'id_usuario' => $id_usuario,
            'fecha_hora_inicio' => $fecha_hora_inicio,
            'fecha_hora_fin' => $fecha_hora_fin,
            'observaciones' => $observaciones,
        ]);

        //AL RETORNAR A LA VISTA PRINCIPAL ESTABLEZCO UN ESTADO TEMPORAL PARA DESPLEGAR UN MENSAJE AL USUARIO CON LA CONFIRMACION DE LA TRANSACCION
        return redirect()->to('reservas')->with('status','La reserva ha sido actualizada');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //A TRAVES DE ESTE METODO SE EJECUTA LA ELIMINACION DEL REGISTRO EXISTENTE EN LA TABLA reservas DE LA BASE DE DATOS
        Reserva::where('id',$id)->delete();

        //AL RETORNAR A LA VISTA PRINCIPAL ESTABLEZCO UN ESTADO TEMPORAL PARA DESPLEGAR UN MENSAJE AL USUARIO CON LA CONFIRMACION DE LA TRANSACCION
        return redirect()->to('reservas')->with('status','La reserva ha sido eliminada');
    }
}
