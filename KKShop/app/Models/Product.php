<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{    
	use HasFactory;
    public $timestamps = false;
    protected $fillable = [

    	'sp_Ten', 'l_id','th_id', 'sp_MoTa', 'sp_noidung', 'sp_gia', 'sp_hinhanh', 'sp_trangthai'
    ];
    protected $primaryKey = 'sp_id'; //không cần cũng được nó tự xđ là id
    protected $table = 'SanPham';
    public function Category(){
		return $this->belongsTo(Category::class,'l_id');
	}
	public function Brand(){
		return $this->belongsTo(Brand::class,'th_id');
	}
    public function Gallery(){
        return $this->hasMany(Gallery::class);
    }
    
}