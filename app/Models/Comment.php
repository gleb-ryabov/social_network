<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "comments";

    protected $guarded = [];

    // relationship with the author of the comment
    public function userAuthor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_from');
    }
    // relationship with the recipient of the comment
    public function userRecipient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_to');
    }
}
