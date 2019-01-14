<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Productos;
use DB;
use Redirect;
use View;
use Validator;

class ProductosController extends Controller
{
    public function Index() 
    {
    	return view('productos.productos');
    }
    public function NuevoProductoView()
    {
    	return view('productos.productos_nuevo');
    }
    public function EditarProductoView($id)
    {
        $producto = Productos::select('*')->where('id','=', $id)->first();
        return View::make('productos.productos_editar')->with('producto', $producto); 
    }
    public function NuevoProducto(Request $request)
    {
        //return $request->tipo['label'];
    	DB::beginTransaction();
    	try 
        {
            $validator = Validator::make($request->all(), [
                'tipo' => 'required',
                'modelo' => 'required',
                'marca' => 'required',
                'codbarras' => 'required'
            ]);
            if ($validator->fails()) {
                return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
            }
            $query = new Productos;
                $query->tipo = $request->tipo['label'];
                $query->modelo = $request->modelo;
                $query->marca = $request->marca['label'];
                $query->codbarras = $request->codbarras;
            $query->save();
            DB::commit();
            return 'work';
        }
        catch(Exception $e)
        {
        	DB::rollback();
        	return redirect()
                ->back()
                ->withErrors('Se ha producido un errro: ( ' . $e->getCode() . ' ): ' . $e->getMessage().' - Copie este texto y envielo a informática');
        }
    }
    public function EditarProducto(Request $request)
    {
        $this->validate($request, [
            'tipo' => 'required',
            'modelo' => 'required',
            'marca' => 'required',
            'codbarras' => 'required'
        ]);

        $post = $request->all();
        Productos::find($post['id'])->update([
            'tipo' => $post['tipo'],
            'modelo' => $post['modelo'],
            'marca' => $post['marca'],
            'codbarras' => $post['codbarras']
        ]);
        return 'work';
    }
    public function EliminarProducto(Request $request)
    {
        //return $request;
        $this->validate($request, [
            'id' => 'required|integer',
        ]);

        $queryinfo = Productos::find($request['id']);
            $queryinfo->estado = false;
        $queryinfo->save();
        //return 'work';
    }
}
