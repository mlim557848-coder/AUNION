<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterAlumni extends Model
{
    protected $table = 'master_alumni';

    protected $fillable = [
        'student_id',
        'full_name',
        'batch_year',
        'course',
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}