<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingFee extends Model
{
    use HasFactory;
	public $timestamps = false;
	protected $fillable = [
		'xaid', 'fee'
	];
	protected $primaryKey = 'sf_id'; //không cần cũng được nó tự xđ là id
	protected $table = 'ShippingFee';
	// public function City(){
	// 	return $this->belongsTo('App\Models\City','matp');
	// }
	// public function Province(){
	// 	return $this->belongsTo('App\Models\Province','maqh');
	// }
	public function Wards(){
		return $this->belongsTo(Wards::class,'xaid');
	}
}