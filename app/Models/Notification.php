<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {
    protected $table = 'notifications_custom';

    protected $fillable = [
        'user_id', 'type', 'canal', 'message', 'statut',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}