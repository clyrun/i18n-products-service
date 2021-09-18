<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductTranslation extends Model
{
    use SoftDeletes;

    /**
     * Set the Primary Key
     *
     * @var string
     */
    protected $primaryKey = 'translation_id';

    /**
     * DB table name
     *
     * @var string
     */
    protected $table = 'product_translations';

    /**
     * Disable Timestamps
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'translation_id',
        'locale',
        'product_id',
        'product_name',
        'product_desc',
        'product_category',
    ];

    public static function build(Product $product, array $localization)
    {
        return [
            'locale' => $localization['locale'],
            'product_id' => $product->product_id,
            'product_name' => $localization['product_name'],
            'product_desc' => $localization['product_desc'],
            'product_category' => $localization['product_category']
        ];
    }
}
