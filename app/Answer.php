<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 */
class Answer extends Model
{
    /**
     * Column constants.
     */
    public const COLUMN_ID = 'id';
    public const COLUMN_ANSWER = 'answer';
    public const COLUMN_QUESTION_ID = 'question_id';

    /**
     * @var array
     */
    protected $fillable = [
        self::COLUMN_ANSWER,
        self::COLUMN_QUESTION_ID,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
