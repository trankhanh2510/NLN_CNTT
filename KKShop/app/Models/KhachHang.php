<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhachHang extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [

    	'kh_Ten','kh_email', 'kh_password','kh_sdt'
    ];
    protected $primaryKey = 'kh_id'; //không cần cũng được nó tự xđ là id
    protected $table = 'KhachHang';
}