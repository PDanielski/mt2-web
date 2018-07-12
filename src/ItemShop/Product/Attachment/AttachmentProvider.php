<?php


namespace App\ItemShop\Product\Attachment;

use App\ItemShop\Product\Attachment\Exception\AttachmentNotFoundException;
use App\ItemShop\Product\Product;
use Doctrine\DBAL\Connection;

class AttachmentProvider implements AttachmentsProviderInterface {

    protected const ATTACHMENTS_TABLE = 'ItemShop.attachments';

    protected const ATTACHMENTS_TYPES_TABLE = 'ItemShop.attachments_types';

    protected const PRODUCTS_ATTACHMENTS_TABLE = 'ItemShop.products_attachments';

    protected $conn;

    protected $factory;

    public function __construct(Connection $connection, TypedAttachmentFactoryInterface $factory) {
        $this->conn = $connection;
        $this->factory = $factory;
    }

    public function getByProduct(Product $product): array {
        $queryBuilder = $this->conn->createQueryBuilder();
        $attachments = $queryBuilder
            ->select('a.attachment_id, at.attachment_type_id', 'at.name as attachment_type_name')
            ->from(self::PRODUCTS_ATTACHMENTS_TABLE, 'pa')
            ->join('pa', self::ATTACHMENTS_TABLE, 'a', 'pa.attachment_id = a.attachment_id')
            ->join('pa', self::ATTACHMENTS_TYPES_TABLE, 'at', 'a.attachment_type_id = at.attachment_type_id')
            ->execute()
            ->fetchAll();

        if(!$attachments)
            return [];

        try {
            $createdAttachments = [];
            foreach($attachments as $attachment) {
                $createdAttachments[] = $this->factory->create($attachment['attachment_id'], $attachment['attachment_type_name']);
            }
            return $createdAttachments;
        } catch (AttachmentNotFoundException $ex) {
            throw new \RuntimeException("Some attachment has a record in the base table, but not in its own derived table");
        }
    }

}