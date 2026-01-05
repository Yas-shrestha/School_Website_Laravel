<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory;
    protected $fillable = ['img', 'name', 'post', 'field', 'experience', 'description'];
    public function notice(): HasMany
    {
        return $this->HasMany(Notice::class);
    }
}
