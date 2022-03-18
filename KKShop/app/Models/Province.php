<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
  	use HasFactory;
	public $timestamps = false;
	protected $fillable = [
		'qh_ten', 'type', 'matp'
	];
	protected $primaryKey = 'maqh'; //không cần cũng được nó tự xđ là id
	protected $table = 'QuanHuyen';
	public function City(){
		return $this->belongsTo(City::class,'matp');
	}
}
