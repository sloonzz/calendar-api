<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CalendarEvent extends Model
{
    use SoftDeletes;
    protected $table = 'calendar_events';
    protected $fillable = ['name', 'date'];
    protected $hidden = ['deleted_at'];
}
