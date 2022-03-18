<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [

    	'th_Ten', 'th_MoTa', 'th_TrangThai'
    ];
    protected $primaryKey = 'th_id'; //không cần cũng được nó tự xđ là id
    protected $table = 'ThuongHieu';
}
