<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingBookingDate extends Model
{
    protected $fillable = [
        'training_booking_id',
        'training_date',
        'trainer_id',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'training_date' => 'date',
    ];

    public function booking()
    {
        return $this->belongsTo(TrainingBooking::class, 'training_booking_id');
    }

    public function trainer()
    {
        return $this->belongsTo(Instructor::class, 'trainer_id');
    }
}
