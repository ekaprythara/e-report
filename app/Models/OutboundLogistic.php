<?php

namespace App\Models;

use App\Models\Receiver;
use App\Models\InboundLogistic;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OutboundLogistic extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function inboundLogistic()
    {
        return $this->belongsTo(InboundLogistic::class, 'inboundLogistic_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Receiver::class, 'receiver_id');
    }
}
