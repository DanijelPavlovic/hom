<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Expense extends Model
{
    use HasFactory;
    protected $table = "expenses";

    protected $fillable = [
        'description',
        'amount',
        'category_id',
        'user_id'
    ];

    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }
}
