<?php

namespace App\Models;

use App\Models\Concerns\BelongsToClient;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use BelongsToClient;

    protected $guarded = [];

    public function getAmountForHumansAttribute()
    {
        return number_format($this->amount / 100, 2);
    }
}
