<?php


namespace App\ItemShop\Product\Attachment;


use App\ItemShop\Product\Attachment\Exception\AttachmentNotFoundException;

interface TypedAttachmentRepositoryInterface {

    /**
     * @param int $attachmentId
     * @return AttachmentInterface
     * @throws AttachmentNotFoundException
     */
    public function getById(int $attachmentId): AttachmentInterface;

    public function getType(): string;

}