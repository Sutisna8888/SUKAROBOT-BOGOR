<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingBooking extends Model
{
    protected $fillable = [
        'student_id',
        'program_id',
        'schedule_status',
        'training_days',
        'daily_price',
        'total_amount',
        'approved_by',
        'approved_at',
        'locked_at',
        'locked_by_transaction_id',
        'admin_notes',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'locked_at' => 'datetime',
        'daily_price' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function dates()
    {
        return $this->hasMany(TrainingBookingDate::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
