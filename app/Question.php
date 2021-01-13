<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 */
class Question extends Model
{
    /**
     * Column constants.
     */
    public const COLUMN_ID = 'id';
    public const COLUMN_QUESTION = 'question';
    public const COLUMN_STATUS = 'status';

    /**
     * @var array
     */
    protected $fillable = [
        self::COLUMN_QUESTION,
        self::COLUMN_STATUS,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function answer()
    {
        return $this->hasOne(Answer::class);
    }
}
