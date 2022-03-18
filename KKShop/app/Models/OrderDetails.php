<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
        use HasFactory;
	public $timestamps = false;
	protected $fillable = [
		'dh_id',
		'sp_id',
		'sp_ten',
		'sp_gia',
		'ctdh_soluong',
		'ctdh_dongia',
	];
	protected $primaryKey = 'ctdh_id'; //không cần cũng được nó tự xđ là id
	protected $table = 'ChiTietDatHang';
	public function Order(){
		return $this->belongsTo(Order::class,'dh_id');
	}
	public function Product(){
		return $this->belongsTo(Product::class,'sp_id');
	}
}
