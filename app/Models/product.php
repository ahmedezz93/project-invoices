<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable=['name','description','section_name'];
    public function section(){

       return $this->belongsto(section::class,'section_name');
    }
}
