<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Late extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'date_time_late',
        'information',
        'bukti',
        'student_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
