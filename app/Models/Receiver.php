<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receiver extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = ['id'];

    public function receiverUnit()
    {
        return $this->belongsTo(ReceiverUnit::class, 'receiverUnit_id');
    }
}
