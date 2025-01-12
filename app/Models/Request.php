<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $fillable = ['requested_by', 'requested_to', 'status'];

    public function friend()
    {
        return $this->belongsTo(User::class, 'requested_by' ,'id');
    }

    public function requested()
    {
        return $this->belongsTo(User::class, 'requested_to' ,'id');
    }
}
