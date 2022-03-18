<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [

    	'slider_ten', 'slider_hinhanh', 'slider_trangthai', 'slider_mota'
    ];
    protected $primaryKey = 'slider_id'; //không cần cũng được nó tự xđ là id
    protected $table = 'Slider';
}
