<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumptionPlan extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function client_plan()
    {
        return $this->belongsTo(ClientPlan::class, 'client_plan', 'short_name');
    }

    public function client_user()
    {
        return $this->belongsTo(ClientUser::class, 'client_user', 'full_name');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client', 'full_name');
    }
}
