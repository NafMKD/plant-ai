<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chat extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'message',
        'response',
        'image',
        'response_metadata',
        'disease',
        'probability'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'response_metadata' => 'array'
    ];

    /**
     * Get the User that owns this Chat
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get string form of created_at column
     * format `16 Jan 5:35:23 pm`
     * @return string
     */
    public function getFormattedTimeCreatedAttribute(): string
    {
        return \Carbon\Carbon::parse($this->created_at)->setTimezone('Africa/Addis_Ababa')->format('d M h:m:s a');
    }

    /**
     * Get string form of created_at column
     * format `16 Jan 5:35:23 pm`
     * @return string
     */
    public function getFormattedTimeUpdatedAttribute(): string
    {
        return \Carbon\Carbon::parse($this->updated_at)->setTimezone('Africa/Addis_Ababa')->format('d M h:m:s a');
    }

    /**
     * Get formatted name of the disease
     *
     * @return ?string
     */
    public function getDiseaseNameAttribute(): ?string
    {
        if (empty($this->disease)) return null;
        $explode = explode('__', $this->disease);
        $disease = str_replace('_', ' ', $explode[1]);

        return $disease.' of '.$explode[0];
    }

    /**
     * Get formatted percent form of probability
     *
     * @return float|null
     */
    public function getProbabilityPercentAttribute(): ?float
    {
        if (empty($this->probability)) return null;

        $probability = round(($this->probability * 100), 2);

        return $probability;
    }
}
