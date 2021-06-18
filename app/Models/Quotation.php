<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable=[
        'age_list',
        'currency_id' ,
        'start_date',
        'end_date',
        'total'
    ];
}
