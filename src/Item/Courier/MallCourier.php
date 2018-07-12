<?php


namespace App\Item\Courier;


use App\Item\Courier\Exception\NoEnoughSpaceException;
use App\Item\Event\ItemSentEvent;
use App\Item\Repository\Exception\ItemPrototypeNotFoundException;
use App\Item\Repository\ItemPrototypeRepositoryInterface;
use App\Item\Request\SendItemRequest;
use App\Metin2Domain\Item\Inventory\Exception\FreePositionNotFoundException;
use App\Metin2Domain\Item\Inventory\Exception\OutOfInventoryBoundaryException;
use App\Metin2Domain\Item\Inventory\InventoryFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Doctrine\DBAL\Connection;

class MallCourier implements ItemCourierInterface {

    protected $conn;

    protected $eventDispatcher;

    protected $prototypeRepository;

    protected $itemTableName;

    protected $prototypeTableName;

    protected $inventory;

    public function __construct(
        Connection $conn,
        EventDispatcherInterface $eventDispatcher,
        ItemPrototypeRepositoryInterface $prototypeRepository,
        string $prototypeTableName,
        string $itemTableName
    ) {
        $this->conn = $conn;
        $this->eventDispatcher = $eventDispatcher;
        $this->prototypeRepository = $prototypeRepository;
        $this->itemTableName = $itemTableName;
        $this->prototypeTableName = $prototypeTableName;
        $this->inventory = InventoryFactory::createMallInventory();
    }

    /** @inheritdoc */
    public function sendOneItem(SendItemRequest $request): void {
        try {
            $prototype = $this->prototypeRepository->getByVnum($request->getItemInfo()->getVnum());
        } catch (ItemPrototypeNotFoundException $itemPrototypeNotFoundException) {
            throw new \RuntimeException(
                "Prototype for item with vnum {$request->getItemInfo()->getVnum()} not found",
                0,
                $itemPrototypeNotFoundException
            );
        }

        try {
            $this->fillInventory($request->getReceiverId());
            $position = $this->inventory->getPositionForItem($prototype);
            $this->doInsert($request, $position);
            $this->eventDispatcher->dispatch('app.item.item_sent', new ItemSentEvent($request, $this->inventory));
        } catch (FreePositionNotFoundException $freePositionNotFoundException) {
            throw new NoEnoughSpaceException([$request]);
        }

        $this->resetInventory();
    }

    /** @inheritdoc */
    public function sendMultipleItems(int $receiverId, array $requests): void {
        $this->fillInventory($receiverId);

        try {
            $positionMap = array();
            $pastPos = 0;
            foreach($requests as $request) {
                try {
                    $prototype = $this->prototypeRepository->getByVnum($request->getVnum());
                } catch (ItemPrototypeNotFoundException $itemPrototypeNotFoundException) {
                    throw new \RuntimeException(
                        "Prototype for item with vnum {$request->getVnum()} not found",
                        0,
                        $itemPrototypeNotFoundException
                    );
                }

                $position = $this->inventory->getPositionForItem($prototype, $pastPos);

                if($position > $pastPos)
                    $pastPos = $position;

                $positionMap[] = $position;

                try {
                    $this->inventory->markAsOccupied($position, $prototype->getItemSize());
                } catch (OutOfInventoryBoundaryException $outOfInventoryBoundaryException) {
                    throw new \RuntimeException("The items in the inventory overflow the inventory");
                }

            }

            $i = 0;
            foreach($requests as $request) {
                $this->doInsert($request, $positionMap[$i++]);
                $this->eventDispatcher->dispatch('app.item.item_sent', new ItemSentEvent($request, $this->inventory));
            }

        } catch (FreePositionNotFoundException $freePositionNotFoundException) {
            throw new NoEnoughSpaceException($requests);
        } finally {
            $this->resetInventory();
        }
    }

    protected function fillInventory(int $ownerId): void {
        $queryBuilder = $this->conn->createQueryBuilder();
        $queryBuilder
            ->select("a.pos,b.size")
            ->from($this->itemTableName, 'a')
            ->where("a.owner_id = :ownerId")
            ->andWhere("window = 'MALL'")
            ->leftJoin("a", $this->prototypeTableName, 'b', 'a.vnum = b.vnum')
            ->setParameter('ownerId', $ownerId);

        $sqlResult = $queryBuilder->execute()->fetchAll();

        try {
            foreach ($sqlResult as $row) {
                $this->inventory->markAsOccupied($row["pos"], $row["size"]);
            }
        } catch (OutOfInventoryBoundaryException $boundaryException) {
            throw new \RuntimeException("The items in the inventory overflow the inventory");
        }

    }

    protected function resetInventory(): void {
        $this->inventory->reset();
    }

    protected function doInsert(SendItemRequest $request, $position) {
        $queryBuilder = $this->conn->createQueryBuilder();
        $queryBuilder
            ->insert($this->itemTableName)
            ->values([
                'owner_id' => ':ownerId',
                'window' => '"MALL"',
                'pos' => ':position',
                'count' => ':count',
                'vnum' => ':vnum',
                'socket0' => ':socket0',
                'socket1' => ':socket1',
                'socket2' => ':socket2',
                'socket3' => ':socket3',
                'socket4' => ':socket4',
                'socket5' => ':socket5',
                'attrvalue0' => ':attrvalue0',
                'attrvalue1' => ':attrvalue1',
                'attrvalue2' => ':attrvalue2',
                'attrvalue3' => ':attrvalue3',
                'attrvalue4' => ':attrvalue4',
                'attrvalue5' => ':attrvalue5',
                'attrvalue6' => ':attrvalue6',
                'attrtype0' => ':attrtype0',
                'attrtype1' => ':attrtype1',
                'attrtype2' => ':attrtype2',
                'attrtype3' => ':attrtype3',
                'attrtype4' => ':attrtype4',
                'attrtype5' => ':attrtype5',
                'attrtype6' => ':attrtype6'
            ])
            ->setParameters([
                'ownerId' => $request->getReceiverId(),
                'position' => $position,
                'count' => $request->getItemInfo()->getCount(),
                'vnum' => $request->getItemInfo()->getVnum(),
                'socket0' => $request->getItemInfo()->getSocket0(),
                'socket1' => $request->getItemInfo()->getSocket1(),
                'socket2' => $request->getItemInfo()->getSocket2(),
                'socket3' => $request->getItemInfo()->getSocket3(),
                'socket4' => $request->getItemInfo()->getSocket4(),
                'socket5' => $request->getItemInfo()->getSocket5(),
                'attrvalue0' => $request->getItemInfo()->getAttrValue0(),
                'attrvalue1' => $request->getItemInfo()->getAttrValue1(),
                'attrvalue2' => $request->getItemInfo()->getAttrValue2(),
                'attrvalue3' => $request->getItemInfo()->getAttrValue3(),
                'attrvalue4' => $request->getItemInfo()->getAttrValue4(),
                'attrvalue5' => $request->getItemInfo()->getAttrValue5(),
                'attrvalue6' => $request->getItemInfo()->getAttrValue6(),
                'attrtype0' => $request->getItemInfo()->getAttrType0(),
                'attrtype1' => $request->getItemInfo()->getAttrType1(),
                'attrtype2' => $request->getItemInfo()->getAttrType2(),
                'attrtype3' => $request->getItemInfo()->getAttrType3(),
                'attrtype4' => $request->getItemInfo()->getAttrType4(),
                'attrtype5' => $request->getItemInfo()->getAttrType5(),
                'attrtype6' => $request->getItemInfo()->getAttrType6()
            ])
            ->execute();
    }

}