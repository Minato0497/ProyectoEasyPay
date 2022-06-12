<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationType extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'operation_types';
    protected $primaryKey = 'codOperationType';
    protected $guarded = ['codOperationType'];
}
