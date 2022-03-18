<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [

    	'kh_id',
    	'shipping_ten',
        'matp',
        'maqh',
        'xaid',
        'phi',
    	'shipping_diachi',
    	'shipping_sdt',
    	'shipping_note',
    	'shipping_trangthai'
    ];
    protected $primaryKey = 'shipping_id'; //không cần cũng được nó tự xđ là id
    protected $table = 'Shipping';
    public function KhachHang(){
        return $this->belongsTo(KhachHang::class,'kh_id');
    }
    public function Order(){
        return $this->hasMany(Order::class);
    }
}