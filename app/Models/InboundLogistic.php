<?php

namespace App\Models;

use App\Models\Logistic;
use App\Models\Supplier;
use App\Models\LogisticProcurement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InboundLogistic extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function logistic()
    {
        return $this->belongsTo(Logistic::class, 'logistic_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function logisticProcurement()
    {
        return $this->belongsTo(LogisticProcurement::class, 'logisticProcurement_id');
    }
}
