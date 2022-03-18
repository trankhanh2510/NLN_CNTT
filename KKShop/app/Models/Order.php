<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
	// public $timestamps = false;
	protected $fillable = [
		'shipping_id','dh_tongtien','dh_phi_vc', 'dh_tongdh',
		'dh_trangthai'
	];
	protected $primaryKey = 'dh_id'; //không cần cũng được nó tự xđ là id
	protected $table = 'DatHang';
	public function Shipping(){
		return $this->belongsTo(Shipping::class,'shipping_id');
	}
}
