<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class AmountConfirm extends Model
{
       public function confirmedBy()
       {
           return $this->belongsTo(Staff::class);
       }
}
