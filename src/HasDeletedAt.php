<?php

namespace Codewiser\SoftDeletes;

/**
 * Helper interface for custom builder.
 *
 * @method $this withTrashed(bool $withTrashed = true)
 * @method $this onlyTrashed(\DateTimeInterface $at = null)
 * @method $this withoutTrashed(\DateTimeInterface $at = null)
 * @method $this restoreOrCreate(array $attributes = [], array $values = [])
 * @method $this createOrRestore(array $attributes = [], array $values = [])
 */
interface HasDeletedAt
{

}
