<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [

    	'Ten', 'MoTa','TrangThai'
    ];
    protected $primaryKey = 'l_id'; 
    protected $table = 'LoaiSanPham';
    public function Product(){
    	return $this->hasMany(Product::class);
    }
}