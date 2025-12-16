<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\category_model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class tickets_model extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $primaryKey = 'id_ticket';
    protected $fillable = [
        'id_ticket',
        'id_user', //fk
        'title',
        'description',
        'id_category', //fk
        'attachment',
        'status',
        'admin_note',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(logs_model::class, 'id_ticket', 'id_ticket');
    }

    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(category_model::class, 'id_category', 'id_category');
    }
}
