<?php

namespace Codewiser\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PassiveSoftDeletingScope extends SoftDeletingScope
{
    /**
     * All of the extensions to be added to the builder.
     *
     * @var string[]
     */
    protected $extensions = ['Restore', 'RestoreOrCreate', 'CreateOrRestore', 'WithTrashed', 'WithoutTrashed', 'OnlyTrashed'];

    public function apply(Builder $builder, Model $model)
    {
        // Do not apply
    }

    /**
     * Add the without-trashed extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<*>  $builder
     * @return void
     */
    protected function addWithoutTrashed(Builder $builder)
    {
        $builder->macro('withoutTrashed', function (Builder $builder, \DateTimeInterface $at = null) {
            $model = $builder->getModel();

            $builder
                ->whereNull($model->getQualifiedDeletedAtColumn())
                ->orWhere($model->getQualifiedDeletedAtColumn(), '>', $at ?? new \DateTime());

            return $builder;
        });
    }

    /**
     * Add the only-trashed extension to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<*>  $builder
     * @return void
     */
    protected function addOnlyTrashed(Builder $builder)
    {
        $builder->macro('onlyTrashed', function (Builder $builder, \DateTimeInterface $at = null) {
            $model = $builder->getModel();

            $builder->where(
                $model->getQualifiedDeletedAtColumn(), '<=', $at ?? new \DateTime()
            );

            return $builder;
        });
    }
}