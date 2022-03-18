<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
	use HasFactory;
	public $timestamps = false;
	protected $fillable = [
		'xptt_ten', 'type', 'maqh'
	];
	protected $primaryKey = 'xaid'; //không cần cũng được nó tự xđ là id
	protected $table = 'XaPhuongThiTran';
	public function Province(){
		return $this->belongsTo(Province::class,'maqh');
	}
}