<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = ['module_id', 'title', 'content', 'video_url', 'order', 'type', 'media_url'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
