<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    protected $table = "users";

    protected $fillable = [
        'email',
        'password',
        'amount',
        'api_token',
    ];

    protected $hidden = [
        'password',
        'api_token',
    ];

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    public function deduceAmount($amount)
    {
        $this->amount = $this->amount - $amount;
        $this->save();
    }

    public function addAmount($amount)
    {
        $this->amount = $this->amount + $amount;
        $this->save();
    }

    public function hasEnoughAmount($amount)
    {
        return (int) $this->amount >= (int) $amount;
    }
}
