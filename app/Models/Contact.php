<?php

namespace App\Models;

use App\Enums\ContactTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['person_id', 'type', 'contact'];

    protected $casts = [
        'person_id' => 'integer',
        'type' => ContactTypeEnum::class,
        'contact' => 'string',
    ];

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
