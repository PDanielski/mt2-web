<?php


namespace App\ItemShop\Product\Attachment;


use App\ItemShop\Product\Attachment\Exception\AttachmentNotFoundException;

interface TypedAttachmentFactoryInterface {

    /**
     * @param int $attachmentId
     * @param string $attachmentType
     * @return AttachmentInterface
     * @throws AttachmentNotFoundException
     */
    public function create(int $attachmentId, string $attachmentType): AttachmentInterface;

}