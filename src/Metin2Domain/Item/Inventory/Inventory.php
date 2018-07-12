<?php


namespace App\Metin2Domain\Item\Inventory;


use App\Metin2Domain\Item\Inventory\Exception\FreePositionNotFoundException;
use App\Metin2Domain\Item\Inventory\Exception\NoFreeSpaceToCheckoutException;
use App\Metin2Domain\Item\Inventory\Exception\OutOfInventoryBoundaryException;
use App\Metin2Domain\Item\ItemPrototype;

class Inventory {

    protected $name;

    protected $pages;

    protected $rows;

    protected $columns;

    protected $occupiedPositions = array();

    protected $occupiedPositionsFlipped = array();

    protected $knownFreeSpaces = array();

    public function __construct(string $name, int $pages, int $rows, int $columns) {
        $this->name = $name;
        $this->pages = $pages;
        $this->rows = $rows;
        $this->columns = $columns;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getRowsCount(): int {
        return $this->rows;
    }

    public function getColumnsCount(): int {
        return $this->columns;
    }

    public function getPagesCount(): int {
        return $this->pages;
    }

    public function getCapacity(): int {
        return $this->rows * $this->columns * $this->pages;
    }

    public function getOccupiedPositions(): array {
        return $this->occupiedPositions;
    }

    public function isPositionOccupied(int $position): bool {
        return isset($this->occupiedPositionsFlipped[$position]);
    }

    /**
     * @param int[] $positions
     * @throws OutOfInventoryBoundaryException
     */
    public function setOccupiedPositions(array $positions): void {
        if(count($positions) > 0){
            $maxPosition = max(...$positions);
            if($maxPosition >= $this->getCapacity())
                throw new OutOfInventoryBoundaryException($maxPosition, $this->getCapacity());

        }
        $this->occupiedPositions = $positions;
        $this->occupiedPositionsFlipped = array_flip($positions);
    }

    /**
     * @param int $initialPos
     * @param int $itemSize
     * @throws OutOfInventoryBoundaryException
     */
    public function markAsOccupied(int $initialPos, int $itemSize): void {
        for($i = 0; $i < $itemSize; $i++) {
            $newPos = $initialPos + $i*$this->getColumnsCount();

            if($newPos >= $this->getCapacity())
                throw new OutOfInventoryBoundaryException($newPos, $this->getCapacity());

            if(!isset($this->occupiedPositionsFlipped[$newPos])){
                $this->occupiedPositions[] = $newPos;
                $this->occupiedPositionsFlipped[$newPos] = true;
            }

        }
    }


    /**
     * @param ItemPrototype $prototype
     * @param int $startPosition
     * @return int
     * @throws FreePositionNotFoundException
     */
    public function getPositionForItem(ItemPrototype $prototype, int $startPosition = 0): int {
        $itemSize = $prototype->getItemSize();
        $occupiedPositions = $this->getOccupiedPositions();

        if($this->isThereKnownSpaceForThisSize($itemSize)){
            try {
                return $this->getAndRemoveFreeSpace($itemSize);
            } catch (NoFreeSpaceToCheckoutException $noFreeSpaceToCheckoutException) {
                throw new \RuntimeException("No known free space ready");
            }

        }
        if($this->getCapacity() < 1)
            throw new \LogicException("Attempt to find a free position with an Inventory with no capacity");

        if(count($occupiedPositions) == 0)
            return 0;

        $rows = $this->getRowsCount();
        $columns = $this->getColumnsCount();
        $pages = $this->getPagesCount();

        $perPagePositionCount = $rows * $columns;

        $startRow = (int)($startPosition / $columns);
        $startColumn = (int)($startPosition % $columns);
        $startPage = (int)(($startPosition+1) / $perPagePositionCount);


        for($p = $startPage; $p < $pages; $p++){
            for($i = $startRow; $i < ($rows*($p+1));$i++) {
                for ($j = $startColumn; $j < $columns; $j++) {
                    $initialPos = $j + $columns * $i;
                    $maxIndex = $perPagePositionCount * ($p+1);

                    $newPos = function($k) use ($initialPos, $columns) {
                        return $initialPos + $columns * $k;
                    };

                    $k = 0;
                    while ($k < $itemSize && $newPos($k) < $maxIndex && !$this->isPositionOccupied($newPos($k)))
                        $k++;

                    if ($k == $itemSize)
                        return $initialPos;


                    if($k > 0){
                        $this->addKnownFreeSpace($initialPos, $k);
                    }
                }
            }
        }

        throw new FreePositionNotFoundException($this, $prototype);
    }
    public function addKnownFreeSpace(int $position, int $itemSize): void{
        if(isset($this->knownFreeSpaces[$itemSize]) && in_array($position, $this->knownFreeSpaces[$itemSize]))
            return;

        $this->knownFreeSpaces[$itemSize][] = $position;
    }

    public function isThereKnownSpaceForThisSize(int $itemSize): bool {
        return isset($this->knownFreeSpaces[$itemSize]) && is_array($this->knownFreeSpaces[$itemSize])
            && count($this->knownFreeSpaces[$itemSize]) > 0;
    }

    /**
     * @param int $itemSize
     * @return int
     * @throws NoFreeSpaceToCheckoutException
     */
    public function getAndRemoveFreeSpace(int $itemSize): int {
        if($this->isThereKnownSpaceForThisSize($itemSize)){
            return array_shift($this->knownFreeSpaces[$itemSize]);
        }

        throw new NoFreeSpaceToCheckoutException($itemSize);
    }

    public function reset(): void {
        $this->occupiedPositions = array();
        $this->occupiedPositionsFlipped = array();
        $this->knownFreeSpaces = array();
    }

}