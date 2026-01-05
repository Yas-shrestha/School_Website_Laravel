<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['img', 'title', 'description', 'courselength', 'description2', 'capacity'];
    public function admission(): HasMany
    {
        return $this->hasMany(Admission::class, 'course_id');
    }
    public function students()
    {
        return $this->belongsToMany(Student::class, 'admissions')
            ->withPivot(['email', 'phone', 'img'])
            ->withTimestamps();
    }
}
