<?php

namespace App\Models;

use App\Mail\WelcomeEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
   public function handyman()
    {
        return $this->hasOne(Handyman::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function isHandyman(): bool
    {
        return $this->role === 'handyman' && $this->handyman()->exists();
    }

    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    /**
     * Send the email verification notification.
     * Override to use our custom welcome email instead of Laravel's default.
     */
    public function sendEmailVerificationNotification(): void
    {
        Mail::to($this)->send(new WelcomeEmail($this));
    }
}