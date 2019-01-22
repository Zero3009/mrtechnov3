<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'stock';
	protected $primaryKey = 'id';
    //Definimos los campos que se pueden llenar con asignación masiva
    protected $fillable = ['prods_id', 'provs_id','serial','precio_entrada','precio_salida','fecha_entrada','fecha_salida','disponible','estado'];
    public $timestamps = false;

    public function setSerialAttribute($value)
	{
	    $this->attributes['serial'] = strtoupper($value);
	}
}
