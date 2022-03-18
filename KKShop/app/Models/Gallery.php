<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [

    	'asp_ten', 'asp_hinhanh', 'sp_id'
    ];
    protected $primaryKey = 'asp_id'; //không cần cũng được nó tự xđ là id
    protected $table = 'AnhSanPham';

    public function SamPham(){
    	return $this->belongsTo(Product::class,'sp_id');
    }
}
