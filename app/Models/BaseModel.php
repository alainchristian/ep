<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    /**
     * The name of the "created at" column.
     *
     * @var string
     */
    const CREATED_AT = 'CreatedAt';

    /**
     * The name of the "updated at" column.
     *
     * @var string
     */
    const UPDATED_AT = 'UpdatedAt';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The storage format of the model's date columns.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Set default values when creating a new model instance
        static::creating(function ($model) {
            if (!isset($model->IsActive)) {
                $model->IsActive = true;
            }
        });
    }

    /**
     * Scope a query to only include active records.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('IsActive', 1);
    }

    /**
     * Scope a query to only include inactive records.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('IsActive', 0);
    }

    /**
     * Soft delete by setting IsActive to false.
     *
     * @return bool
     */
    public function softDelete()
    {
        return $this->update(['IsActive' => false]);
    }

    /**
     * Restore a soft deleted record.
     *
     * @return bool
     */
    public function restore()
    {
        return $this->update(['IsActive' => true]);
    }
}
