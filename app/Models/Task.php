<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $guarded = [];

    // validation model rules
    public static $createRules = [
        'name' => ['required', 'string', 'max:255'],
    ];

    public function timeTrackers()
    {
        return $this->hasMany(TimeTracker::class);
    }

}
