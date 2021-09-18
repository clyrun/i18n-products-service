<?php

namespace App\Exceptions\ProductExceptions;

use App\Exceptions\ProductException;

class ProductTranslationUpdateFailure extends ProductException
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
    }
}
