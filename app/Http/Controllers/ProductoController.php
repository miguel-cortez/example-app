<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
// AGREGE DESDE AQUÍ
// Para usar con Cloudinary
use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Str;
//use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary; // SOLUCION PENDIENTE
//use CloudinaryLabs\Cloudinary\Facades\Cloudinary;
//use Cloudinary\Laravel\MediaUploader\MediaUploader;
//use CloudinaryLabs\CloudinaryLaravel\MediaUploader\MediaUploader;

// HASTA AQUÍ
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

    /*
    // Función original - Para subir archivos en directorio local.
    public function upload(Request $request){
        try{
            $ruta = "images/productos";
            $info = array();
            foreach ($request["image"] as $img){
                $filename = Carbon::now()->timestamp . '_' . rand(1000, 9999) . '.' . $img->extension();
                $img->move(public_path($ruta), $filename);
                $producto = Producto::find($request["producto_id"]);
                $producto->imagen = $filename;
                $producto->save();
                $info[] = $filename;
            }
            return response()->json(["data"=> $info, "message"=>"La imagen se ha guardado"],200);
        }catch(\Exception $e){
            return response()->json(["data"=> null, "message"=>$e->getMessage()],422);
        } 
    }
    */
    public function upload(Request $request){
        // Función modificada para que trabaje con Cloudinary
        // $img->getClientOriginalName() OBTENER EL NOMBRE ORIGINAL
        // $img->getClientMimeType() OBTENER EL TIPO MIME
        // $img->getSize() OBTENER EL TAMAÑO EN BYTES
        // $img->getClientOriginalExtension() OBTENER LA EXTESIÓN ORIGINAL
        // $img->getRealPath() OBTIENE LA RUTA REAL. Ejemplo: C:\\wamp64\\tmp\\phpAC4A.tmp
        try{
            $info = array();
            //foreach ($request["image"] as $img){
            if($request->hasFile("image")){
                foreach ($request["image"] as $img){
                    $filename = Carbon::now()->timestamp . '_' . rand(1000, 9999) . '.' . $img->extension();
                    if (config('filesystems.default') === 'cloudinary') {
                        Storage::disk('cloudinary')->putFileAs('images/productos/', $img, $filename);
                        /*
                        $uploadedFile = Cloudinary::upload($img->getRealPath(), [
                            'folder' => 'images/productos'
                        ]);
                        */
                        /*
                        $uploaded = MediaUploader::fromFile($img)
                            ->toFolder('images/productos')
                            ->withPublicId('nombre-personalizado')
                            ->upload();
                        $info[] = $uploaded;
                        */
                        /*
                        $uploadedFile->getPublicId();
                        'url_imagen' => $uploadedFile->getSecurePath(), // URL directa de Cloudinary
                        */
                    } else {
                        $img->move(public_path("images/productos"), $filename);
                    }
                    $producto = Producto::find($request["producto_id"]);
                    $producto->imagen = $filename;
                    $producto->save();
                    $info[] = $filename;
                }
                return response()->json(["data"=> $info, "message"=>"La imagen se ha guardado"],200);
            }else{
                return response()->json(["data"=> "No se han recibido archivos", "message"=>"Datos incompletos"],500);
            }
        }catch(\Exception $e){
            return response()->json(["data"=> null, "message"=>$e->getMessage()],422);
        } 
    }
    public function remove(Request $request){
        try{
            $producto = Producto::find($request["id"]);
            if($producto){
                $filename = $producto->imagen;
                $producto->imagen = null;
                $producto->save();
                if (config('filesystems.default') === 'cloudinary') {
                    $filePath = 'images/productos/' . $filename;
                    Storage::disk('cloudinary')->delete($filePath);
                    return response()->json(["data"=> $filePath, "message"=>"Imagen eliminada"],200);
                } else {
                    $filePath = public_path('images/productos/'.$filename);
                    if (File::exists($filePath)) {
                        File::delete($filePath);
                        return response()->json(["data"=> $filePath, "message"=>"Imagen eliminada"],200);
                    } else {
                        return response()->json(["data"=> $filePath, "message"=>"Imagen no encontrada"],404);
                    }
                }
            }else{
                return response()->json(["data"=> "Producto no encontrado", "message"=>"Imagen no eliminada"],404);
            }
        }catch(\Exception $e){
            return response()->json(["data"=> null, "message"=>$e->getMessage()],422);
        }
    }
}