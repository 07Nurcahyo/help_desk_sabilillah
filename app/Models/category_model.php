<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class category_model extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $primaryKey = 'id_category';
    protected $fillable = ['category_name', 'created_at', 'updated_at'];

    public function tickets(): HasMany
    {
        return $this->hasMany(tickets_model::class, 'id_category', 'id_category');
    }
}
