<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Comment.
 *
 * @property int $id
 * @property int $tiket_id
 * @property int $user_id
 * @property string $comment
 * @property null|Carbon $created_at
 * @property null|Carbon $updated_at
 * @property null|string $deleted_at
 * @property User $user
 * @property Ticket $ticket
 */
class Comment extends Model
{
    use SoftDeletes;
    protected $table = 'comments';

    protected $casts = [
        'tiket_id' => 'int',
        'user_id' => 'int',
    ];

    protected $fillable = [
        'tiket_id',
        'user_id',
        'comment',
        'attachments',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'tiket_id');
    }
}
