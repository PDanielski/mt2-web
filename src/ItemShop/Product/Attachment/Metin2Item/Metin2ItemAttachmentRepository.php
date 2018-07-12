<?php


namespace App\ItemShop\Product\Attachment\Metin2Item;


use App\ItemShop\Product\Attachment\AttachmentInterface;
use App\ItemShop\Product\Attachment\TypedAttachmentRepositoryInterface;
use App\Metin2Domain\Item\ItemInfo;
use Doctrine\DBAL\Connection;

class Metin2ItemAttachmentRepository implements TypedAttachmentRepositoryInterface {

    protected const ATTACHMENTS_METIN2_ITEM_TABLE = 'ItemShop.attachments_metin2item';

    protected const SELECTS = [
        'vnum',
        'count',
        'socket0',
        'socket1',
        'socket2',
        'socket3',
        'socket4',
        'socket5',
        'attrType0',
        'attrType1',
        'attrType2',
        'attrType3',
        'attrType4',
        'attrType5',
        'attrType6',
        'attrValue0',
        'attrValue1',
        'attrValue2',
        'attrValue3',
        'attrValue4',
        'attrValue5',
        'attrValue6'
    ];

    protected $conn;

    protected $factory;

    public function __construct(Connection $connection, Metin2ItemAttachmentFactory $itemAttachmentFactory) {
        $this->conn = $connection;
        $this->factory = $itemAttachmentFactory;
    }

    public function getById(int $attachmentId): AttachmentInterface {
        $queryBuilder = $this->conn->createQueryBuilder();
        $attachmentData = $queryBuilder
            ->select(...self::SELECTS)
            ->from(self::ATTACHMENTS_METIN2_ITEM_TABLE)
            ->where('attachment_id = :attachmentId')
            ->setParameter('attachmentId', $attachmentId)
            ->execute()
            ->fetch();

        $itemInfo = new ItemInfo(
            $attachmentData['vnum'],
            $attachmentData['count'],
            $attachmentData['socket0'],
            $attachmentData['socket1'],
            $attachmentData['socket2'],
            $attachmentData['socket3'],
            $attachmentData['socket4'],
            $attachmentData['socket5'],
            $attachmentData['attrType0'],
            $attachmentData['attrType1'],
            $attachmentData['attrType2'],
            $attachmentData['attrType3'],
            $attachmentData['attrType4'],
            $attachmentData['attrType5'],
            $attachmentData['attrType6'],
            $attachmentData['attrValue0'],
            $attachmentData['attrValue1'],
            $attachmentData['attrValue2'],
            $attachmentData['attrValue3'],
            $attachmentData['attrValue4'],
            $attachmentData['attrValue5'],
            $attachmentData['attrValue6']
        );

        return $this->factory->create($itemInfo);
    }

    public function getType(): string {
        return "metin2_item";
    }

}