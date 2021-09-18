<?php

namespace App\Services;

use App\Exceptions\ProductExceptions\ProductTranslationUpdateFailure;
use Exception;
use App\Exceptions\ProductExceptions\ProductTranslationNotFound;
use App\Models\Product;
use App\Exceptions\ProductExceptions\ProductNotFound;
use App\Models\ProductTranslation;

/**
 * Class APIResponse
 * @package App
 */
class ProductService
{

    /**
     * Product Model Object
     *
     * @var object | null
     */
    private $product;

    /**
     * Constructor
     *
     * @param int $product_id
     * @param bool $translation_required
     * @throws ProductNotFound
     * @throws ProductTranslationNotFound
     */
    public function __construct(int $product_id, bool $translation_required = true)
    {
        $this->product = $this->findProduct(
            $product_id,
            $translation_required
        )->product;
    }

    /**
     * Show the Product
     *
     * @return mixed
     */
    public function showProduct()
    {
        return $this->product;
    }

    /**
     * Get the Product with translation
     *
     * @throws ProductNotFound|ProductTranslationNotFound
     */
    public function findProduct(int $product_id, bool $translation_required): ProductService
    {
        //Find the Product with the translation data
        $this->product = Product::with('translation')
            ->find($product_id);

        //Check if Product exists
        if (!$this->product instanceof Product) {
            throw new ProductNotFound(trans('api/product.resource.not_found'));
        }

        //Check if Product Translation exists
        if (empty($this->product->translation) && $translation_required) {
            throw new ProductTranslationNotFound(trans('api/product.resource.translation_not_found'));
        }

        return $this;
    }

    /**
     * Update Product & Associated translations
     *
     * @param null $price
     * @param array|null $localization
     * @return $this
     * @throws ProductTranslationUpdateFailure
     */
    public function updateProduct($price = null, array $localization = []): ProductService
    {
        //Validation would be useful on the params

        //Update the Price
        if ($price) {
            $this->product->product_price = $price;
            $this->product->save();
        }

        //Update the translation row
        if (!empty($localization)) {
            try {
                //Check if Translation already exists for locale & product_id
                $existingProductTranslation = ProductTranslation::where('product_id', $this->product->product_id)
                    ->where('locale', $localization['locale'])
                    ->first();

                if ($existingProductTranslation) {
                    //Update existing row
                    $existingProductTranslation->update(
                        ProductTranslation::build($this->product, $localization)
                    );
                } else {
                    //Create new Product Translation row
                    ProductTranslation::create(
                        ProductTranslation::build($this->product, $localization)
                    );
                }
            } catch (Exception $exception) {
                throw new ProductTranslationUpdateFailure(trans('api/product.resource.update.failure'));
            }
        }

        return $this;
    }

    /**
     * Delete Product and Associated translations
     *
     * @return $this
     * @throws ProductTranslationUpdateFailure
     */
    public function deleteProduct(): ProductService
    {
        //Get ALL the translations relating to the Product
        $translations = $this->product->allTranslations;

        try {
            //Delete ALL the associated translations
            if (!empty($translations)) {
                foreach ($translations as $translation) {
                    $translation->delete();
                }
            }

            //Delete the Product
            $this->product->delete();
        } catch (Exception $exception) {
            throw new ProductTranslationUpdateFailure(trans('api/product.resource.delete.failure'));
        }

        return $this;
    }
}
