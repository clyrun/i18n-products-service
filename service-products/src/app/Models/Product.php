<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    /**
     * Set the Primary Key
     *
     * @var string
     */
    protected $primaryKey = 'product_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'product_price',
    ];

    /**
     * Disable Timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Relationship to return the correct Locale for the request
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function translation(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        $productTranslationTable = ProductTranslation::make()->getTable();

        return $this->hasOne(ProductTranslation::class, 'product_id', 'product_id')
            ->where("$productTranslationTable.locale", '=', app()->getLocale());
    }

    /**
     * Relationship to return ALL Locales linked to the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function allTranslations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductTranslation::class, 'product_id', 'product_id');
    }
}
