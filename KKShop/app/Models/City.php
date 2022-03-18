<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
  	use HasFactory;
	public $timestamps = false;
	protected $fillable = [
		'tp_ten', 'type'
	];
	protected $primaryKey = 'matp'; //không cần cũng được nó tự xđ là id
	protected $table = 'TinhThanhPho';
}