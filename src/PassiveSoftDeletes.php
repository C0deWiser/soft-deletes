<?php

namespace Codewiser\SoftDeletes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * Disabled by default SoftDeletes trait.
 *
 * @property null|Carbon $deleted_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static> onlyTrashed(\DateTimeInterface $at = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static> withoutTrashed(\DateTimeInterface $at = null)
 *
 * @mixin Model
 */
trait PassiveSoftDeletes
{
    use SoftDeletes;

    public static function bootSoftDeletes(): void
    {
        static::addGlobalScope(new PassiveSoftDeletingScope);
    }

    /**
     * Determine if the model instance has been soft-deleted.
     *
     * @return bool
     */
    public function trashed(): bool
    {
        $deleted_at = $this->{$this->getDeletedAtColumn()};

        return ! is_null($deleted_at) && $deleted_at <= new \DateTime();
    }

    /**
     * Determine if the model instance has not been soft-deleted.
     *
     * @return bool
     */
    public function alive(): bool
    {
        $deleted_at = $this->{$this->getDeletedAtColumn()};

        return is_null($deleted_at) || $deleted_at > new \DateTime();
    }
}
