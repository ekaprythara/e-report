<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logistic extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function logisticType()
    {
        return $this->belongsTo(LogisticType::class, 'logisticType_id');
    }

    public function standardUnit()
    {
        return $this->belongsTo(StandardUnit::class, 'standardUnit_id');
    }
}
