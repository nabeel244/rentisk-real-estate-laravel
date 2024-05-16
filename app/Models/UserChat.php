<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChat extends Model
{

    protected $fillable = [
        'from_user', 'to_user', 'message', 'file_path', 'send_to','tenant_id', 'landlord_id', 'file_name'
    ];
    use HasFactory;
    protected $guarded = [];
}
