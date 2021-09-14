<?php

namespace App\Models;

use App\Models\Scopes\WhereUserIsActive;
use App\Traits\ModelObservant;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GetTableNameStatically;

/**
 * @mixin IdeHelperMember
 */
class Member extends Model
{
    use HasFactory;
    use ModelObservant;
    use GetTableNameStatically;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'info',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('d-m-Y h:i A');
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted(): void
    {
        parent::booted();
        static::addGlobalScope(new WhereUserIsActive());
    }

    /**
     * Get the user's first name.
     *
     * @param string|null $value
     * @return string
     */
    public function getFirstNameAttribute(?string $value): ?string
    {
        return ucfirst($value);
    }

    /**
     * Get the user's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
