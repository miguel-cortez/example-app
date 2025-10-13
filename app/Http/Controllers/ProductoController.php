<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
            
            $productos = Producto::all();
            return response()->json($productos);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }
    public function obtenerFichasTecnicas(){
        try{
            $productos = DB::table('productos')
            ->whereNotNull('ficha_tecnica')
            ->get();
            return response()->json($productos);
        }catch(\Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Producto $producto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Producto $producto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        //
    }
public function upload(Request $request){
    try{
        $ruta = "images/productos";
        $info = array();
        foreach ($request["image"] as $img){
            $filename = Carbon::now()->timestamp . '_' . rand(1000, 9999) . '.' . $img->extension();
            $img->move(public_path($ruta), $filename);
            $doc = new Documento();
            $doc->archivo = $filename;
            $doc->ruta = $ruta;
            $doc->estado = "C"; // C: Cargado, R: Rechazado, A: Aceptado.
            $doc->estudiante_id = $request["estudiante_id"];
            $doc->tipo_id = null;
            $doc->save();
            $info[] = $doc;
        }
        return response()->json(["data"=> $info, "message"=>"Documentos subidos"],200);
    }catch(\Exception $e){
        return response()->json(["data"=> null, "message"=>$e->getMessage()],422);
    } 
}
}
