<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Stock;
use Validator;
use View;
use Redirect;

class StockController extends Controller
{
    public function Index()
    {
    	return view('stock.stock');
    }
    public function NewStock(Request $request)
    {   
        //return $request;
    	DB::beginTransaction();
    	try 
        {
            /*$validator = Validator::make($request->all(), [
                'codbarras' => 'required',
                'proveedor' => 'required',
                'precioEntrada' => 'required',
                'fechaEntrada' => 'required',
            ]);
            if ($validator->fails()) {
                //return 'hola';
                return redirect()
                            ->back()
                            ->withErrors($validator)
                            ->withInput();
            } */  
            //return sizeof($request->all());

                for ($i=0; $i < sizeof($request->all()); $i++) {
                    //return 'entr';
                    //$arraySeriales = explode(",", $request->seriales[$i]);
                    for($h = 0;$h < sizeof($request[$i]['seriales']);$h++){   
                    //return $request[0]['seriales'][0];                     
                        $query = new Stock;
                            $query->prods_id = $request[$i]['codbarras']['value'];
                            $query->provs_id = $request[$i]['proveedor']['value'];

                            $query->serial = $request[$i]['seriales'][$h];
                            $query->precio_entrada = $request[$i]['precioEntrada'];
                            
                            $query->fecha_entrada =$request[$i]['state'];
                        
                        $query->save();
                    }
                    //return 'llego2';
                }
            
            DB::commit();
            return response()->json([
                'status' => 'success',
                'title'  => 'Resultado:',
                'msg'    => 'Exito',
                'type'   => 'success'
            ],200);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
        	DB::rollback();
            //return $e;
        	if($e->getCode() == 23502)
            {
                return response()->json([
                    'status' => 'error',
                    'title'  => 'Resultado: ya existe el registro',
                    'msg'    =>  $e->getMessage(),
                    'type'   => 'error' 
                ],400);    
            }
            return response()->json([
                'status' => 'error',
                'msg'    => 'Error ' . $e->getCode() . ': ' . $e->getMessage() . 'Contacte a informática'
            ],404);
        }
    
    }
    /*public function EditStockView($id)
    {
        $stock = Stock::select('stock.id','prods.codbarras','stock.serial as serial','provs.nombre','prods.modelo','prods.id as prodsid', 'stock.fechaEntrada', 'stock.precioEntrada','stock.precioSalida','stock.fechaSalida')
                        ->join('provs','stock.provs_id','=','provs.id')
                        ->join('prods','stock.prods_id','=','prods.id')
                        ->where('stock.id','=', $id)->first();
        return View::make('stock.stock_editar')->with('stock', $stock);
    }*/
    public function EditStock(Request $request)
    {
        $this->validate($request, [
            'codbarras' => 'required',
            'fechaEntrada' => 'required',
            'precioEntrada' => 'required',
            'proveedor' => 'required',
            'id' => 'required'
        ]);

        $post = $request->all();
        if($request->input('fechaSalida') && $request->input('precioSalida')){
            Stock::find($post['id'])->update([
                'fecha_entrada' => $post['fechaEntrada'],
                'precio_entrada' => $post['precioEntrada'],
                'serial' => $post['serial'],
                'provs_id' => $post['proveedor'],
                'fecha_salida' => $post['fechaSalida'],
                'precio_salida' => $post['precioSalida'] 
            ]);
        }else if($request->input('fechaSalida')){
            Stock::find($post['id'])->update([
                'fecha_entrada' => $post['fechaEntrada'],
                'precio_entrada' => $post['precioEntrada'],
                'serial' => $post['serial'],
                'provs_id' => $post['proveedor'],
                'fecha_salida' => $post['fechaSalida'],
                'precio_salida' => null
            ]);
        }else{
            Stock::find($post['id'])->update([
                'fecha_entrada' => $post['fechaEntrada'],
                'precio_entrada' => $post['precioEntrada'],
                'serial' => $post['serial'],
                'provs_id' => $post['proveedor'],
                'precio_salida' => null,
                'fecha_salida' => null
            ]);
        }
        return Redirect::to('/admin/stock')->with('status', 'Se ha editado correctamente el registro.');
    }
    public function EliminarStock(Request $request)
    {
        //return $request['id'];
        $this->validate($request, [
            'id' => 'required|integer',
        ]);

        $queryinfo = Stock::find($request['id']);
            $queryinfo->estado = false;
        $queryinfo->save();
        return response()->json([
                'status' => 'success',
                'title'  => 'Resultado:',
                'msg'    => 'Exito',
                'type'   => 'success'
            ],200);
    }
    public function SalidaStock(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
        ]);

        $queryinfo = Stock::find($request['id']);
            $queryinfo->disponible = false;
            $queryinfo->fecha_salida = $request->fechaSalida;
            if($request->precio_salida){
                $queryinfo->precio_salida = $request->precioSalida;
            }
        $queryinfo->save();
        return response()->json([
                'status' => 'success',
                'title'  => 'Resultado:',
                'msg'    => 'Exito',
                'type'   => 'success'
            ],200);

    }
}
