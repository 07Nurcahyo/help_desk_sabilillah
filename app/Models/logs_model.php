<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class logs_model extends Model
{
    use HasFactory;

    protected $table = 'logs';
    protected $primaryKey = 'id_log';
    protected $fillable = [
        'id_log',
        'id_ticket', //fk
        'id_user', //fk
        'action',
        'details',
        'created_at',
        'updated_at',
    ];

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(tickets_model::class, 'id_ticket', 'id_ticket');
    }
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
