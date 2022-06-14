<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'movements';
    protected $primaryKey = 'codMovement';
    protected $guarded = ['codMovement'];

    public function has_operation_type()
    {
        return $this->belongsTo(OperationType::class, 'codOperationType', 'codOperationType');
    }

    public function has_emisor()
    {
        return $this->belongsTo(User::class,  'codEmisor', 'id');
    }

    public function has_receptor()
    {
        return $this->belongsTo(User::class, 'codReceptor', 'id');
    }

}
