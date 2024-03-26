<?php
namespace Ayham\Like\Trait;

use App\Models\User;
use Ayham\Like\Model\Like;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Likeable
{
    public function likes(): MorphMany
    {
        return $this->morphMany(Like::class, 'likeable');
    }

    // togglelike to add the user like or remove it

    public function toggleLike(User $user)
    {
        if ($this->isLikedByUser($user)) {
            $this->removeLike($user);
            $message = 'like removed successfully';
        } else {
            $this->addLike($user);
            $message = 'like added successfully';

        }

        return response()->json(['message' => $message]);
    }

    // check if the user liked the item of model or not

    public function isLikedByUser(User $user): bool
    {
        return $this->likes()->where('user_id', $user->id)
                    ->where('likeable_id',$this->id)
                    ->where('likeable_type',get_class($this))
                    ->exists();
    }

    // Add a like for the model.

    private function addLike(User $user)
    {
        $existingLike = $this->likes()->where([
            'user_id'      => $user->id,
            'likeable_id'   => $this->id,
            'likeable_type' => get_class($this),
        ])->first();

        if (!$existingLike) {
            $user->likes()->create([
                'likeable_id' => $this->id,
                'likeable_type' => get_class($this),
            ]);
        }

    }

    // remove like for the item of model

    private function removeLike(User $user)
    {
        $this->likes()->where([
            'user_id' => $user->id,
            'likeable_id' => $this->id,
            'likeable_type' => get_class($this),
        ])->delete();
    }

    // the number of likes for the item of model
    public function likesCount(): int
    {
        return $this->likes->count();
    }
}
