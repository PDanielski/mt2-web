<?php


namespace App\ItemShop\Product\Attachment;

use App\ItemShop\Product\Product;

interface AttachmentsProviderInterface {

    /**
     * @param Product $product
     * @return AttachmentInterface[]
     */
    public function getByProduct(Product $product): array;

}