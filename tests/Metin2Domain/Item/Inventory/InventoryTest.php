<?php

namespace App\Metin2Domain\Item\Inventory;

use App\Metin2Domain\Item\Inventory\Exception\FreePositionNotFoundException;
use App\Metin2Domain\Item\Inventory\Exception\NoFreeSpaceToCheckoutException;
use App\Metin2Domain\Item\Inventory\Exception\OutOfInventoryBoundaryException;
use App\Metin2Domain\Item\ItemPrototype;
use PHPUnit\Framework\TestCase;

class InventoryTest extends TestCase {

    public function test__construct() {
        $inventory = new Inventory('MALL', 1, 9, 5);
        $this->assertEquals(1, $inventory->getPagesCount());
        $this->assertEquals(9, $inventory->getRowsCount());
        $this->assertEquals(5, $inventory->getColumnsCount());
        return $inventory;
    }

    /** @throws */
    public function testSetAndGetOccupiedPositions() {
        $inventory = new Inventory('MALL', 1, 7, 1);
        $occupiedPositions = [1, 2, 3, 4];
        $inventory->setOccupiedPositions($occupiedPositions);

        $this->assertEquals($occupiedPositions, $inventory->getOccupiedPositions());
    }

    /** @throws */
    public function testSetOccupiedPositionsOverflow(){
        $inventory = new Inventory('MALL', 1, 9, 5);

        $this->expectException(OutOfInventoryBoundaryException::class);
        $inventory->setOccupiedPositions([$inventory->getCapacity() + 1, $inventory->getCapacity() + 2]);
    }

    /** @throws */
    public function testIsPositionOccupied() {
        $inventory = new Inventory('MALL', 2, 4, 7);
        $occupiedPositions = [7, 14, 11];
        $inventory->setOccupiedPositions($occupiedPositions);

        $this->assertTrue($inventory->isPositionOccupied(7));
        $this->assertTrue($inventory->isPositionOccupied(14));
        $this->assertTrue($inventory->isPositionOccupied(11));
        $this->assertNotTrue($inventory->isPositionOccupied(10));
        $this->assertNotTrue($inventory->isPositionOccupied(2));
    }

    public function testGetCapacity() {
        $inventory = new Inventory('MALL', 2, 7, 4);
        $this->assertEquals(2*7*4, $inventory->getCapacity());
    }

    public function testAddKnownFreeSpace() {
        $inventory = new Inventory('MALL', 1, 9, 5);
        $inventory->addKnownFreeSpace(5, 3);
        $inventory->addKnownFreeSpace(7, 3);
        $this->assertTrue($inventory->isThereKnownSpaceForThisSize(3));
        $this->assertNotTrue($inventory->isThereKnownSpaceForThisSize(2));
    }

    /** @throws */
    public function testAddKnownFreeSpaceWithDuplicates() {
        $inventory = new Inventory('MALL', 1, 9, 5);
        $inventory->addKnownFreeSpace(5, 3);
        $inventory->addKnownFreeSpace(5, 3);

        $this->assertTrue($inventory->isThereKnownSpaceForThisSize(3));

        $this->assertEquals(5, $inventory->getAndRemoveFreeSpace(3));

        $this->expectException(NoFreeSpaceToCheckoutException::class);
        $inventory->getAndRemoveFreeSpace(3);
    }


    public function testisThereKnownSpaceForThisSize() {
        $inventory = new Inventory('MALL', 1, 9, 5);
        $this->assertNotTrue($inventory->isThereKnownSpaceForThisSize(3));
    }

    /** @throws */
    public function testGetAndRemoveFreeSpace() {
        $inventory = new Inventory('MALL', 1, 9, 5);

        $inventory->addKnownFreeSpace(2, 3);
        $inventory->addKnownFreeSpace(3, 2);
        $inventory->addKnownFreeSpace(4, 1);
        $inventory->addKnownFreeSpace(15, 1);

        $pos2 = $inventory->getAndRemoveFreeSpace(2);
        $pos3 = $inventory->getAndRemoveFreeSpace(1);
        $pos1 = $inventory->getAndRemoveFreeSpace(3);
        $pos4 = $inventory->getAndRemoveFreeSpace(1);

        $this->assertEquals(3, $pos2);
        $this->assertEquals(4, $pos3);
        $this->assertEquals(2, $pos1);
        $this->assertEquals(15, $pos4);
    }

    /** @throws */
    public function testGetAndRemoveFreeSpaceFailure() {
        $inventory = new Inventory('MALL', 1, 9, 5);

        $inventory->addKnownFreeSpace(2, 3);
        $inventory->addKnownFreeSpace(3, 3);
        $inventory->addKnownFreeSpace(1, 3);

        $pos1 = $inventory->getAndRemoveFreeSpace(3);
        $pos2 = $inventory->getAndRemoveFreeSpace(3);
        $pos3 = $inventory->getAndRemoveFreeSpace(3);

        $this->assertEquals(2, $pos1);
        $this->assertEquals(3, $pos2);
        $this->assertEquals(1, $pos3);

        $this->expectException(NoFreeSpaceToCheckoutException::class);
        $inventory->getAndRemoveFreeSpace(3);

    }

    /** @throws */
    public function testGetPositionForItemWithNoOccupiedPositions(){
        $inventory = new Inventory('MALL', 1,9, 5);
        $prototype = new ItemPrototype(1, 1);
        $occupiedPosition = array();
        $inventory->setOccupiedPositions($occupiedPosition);
        $position = $inventory->getPositionForItem($prototype);
        $this->assertEquals(0, $position);
    }

    /** @throws */
    public function testGetPositionForItemBetweenTwo(){
        $inventory = new Inventory('MALL', 1,9, 5);
        $prototype = new ItemPrototype(1, 2);
        $occupiedPosition = array(
            0 , 1 , 2,  3 ,
            5 , 6 , 7,  8 ,
            10, 11,     13, 14,
            15, 16, 17, 18, 19
        );
        $inventory->setOccupiedPositions($occupiedPosition);
        $position = $inventory->getPositionForItem($prototype);
        $this->assertEquals(4, $position);
    }

    /** @throws */
    public function testGetPositionForItemBetweenThreeTop(){
        $inventory = new Inventory('MALL', 1,9, 5);
        $prototype = new ItemPrototype(1, 3);
        $occupiedPosition = array(
            0 , 1 ,     3 , 4 ,
            5 , 6 ,     8 , 9 ,
            10, 11,     13, 14,
            15, 16, 17, 18, 19
        );
        $inventory->setOccupiedPositions($occupiedPosition);
        $position = $inventory->getPositionForItem($prototype);
        $this->assertEquals(2, $position);
    }

    /** @throws */
    public function testGetPositionForItemBetweenThreeRight(){
        $inventory = new Inventory('MALL', 1,9, 5);
        $prototype = new ItemPrototype(1, 3);
        $occupiedPosition = array(
            0 , 1 , 2,  3 , 4 ,
            5 , 6 , 7,  8 ,
            10,     18, 13,
            15,     17, 18,
            20, 21, 22, 23, 24
        );
        $inventory->setOccupiedPositions($occupiedPosition);
        $position = $inventory->getPositionForItem($prototype);
        $this->assertEquals(9, $position);
    }

    /** @throws */
    public function testGetPositionForItemBetweenThreeBottom(){
        $inventory = new Inventory('MALL', 1,9, 5);
        $prototype = new ItemPrototype(1, 3);
        $occupiedPosition = array(
            0 , 1 , 2,  3 , 4 ,
            5 , 6 , 7,  8 ,
            10,     18, 13,
            15,     17, 18, 19,
            20, 21, 22, 23, 24,
            25, 26,     28, 29,
            30, 31,     33, 34,
            35, 36,     38, 39
        );
        $inventory->setOccupiedPositions($occupiedPosition);
        $position = $inventory->getPositionForItem($prototype);
        $this->assertEquals(27, $position);
    }


    /** @throws */
    public function testGetPositionForItemBetweenFour(){
        $inventory = new Inventory('MALL', 1,9, 5);
        $prototype = new ItemPrototype(1, 2);
        $occupiedPosition = array(
            0 , 1 , 2 , 3 , 4 ,
            5 , 6 , 7 , 8 , 9 ,
            10, 11, 12, 13, 14,
            15, 16, 17, 18, 19,
            20, 21, 22,     24,
            25, 26, 27,     29,
            30, 31, 32, 33, 34
        );
        $inventory->setOccupiedPositions($occupiedPosition);
        $position = $inventory->getPositionForItem($prototype);
        $this->assertEquals(23, $position);
    }

    /** @throws */
    public function testGetPositionForItemBetweenFourAndMultipleHoles(){
        $inventory = new Inventory('MALL', 1,9, 5);
        $prototype = new ItemPrototype(1, 3);
        $occupiedPosition = array(
            0 , 1 , 2 ,     4 ,
            5 ,     7 ,     9 ,
            10, 11,     13, 14,
            15,     17, 18, 19,
            22,     24,
            25,             29,
            30, 31, 32,     34,
            35, 36, 37, 38, 39
        );
        $inventory->setOccupiedPositions($occupiedPosition);
        $position = $inventory->getPositionForItem($prototype);
        $this->assertEquals(16, $position);
    }

    /** @throws */
    public function testGetPositionForItemWithoutSpace(){
        $inventory = new Inventory('MALL', 1,9, 5);
        $prototype = new ItemPrototype(1, 3);
        $occupiedPosition = array(
            0 , 1 , 2 ,     4 ,
            5 ,     7 ,     9 ,
            10, 11,     13, 14,
            15,     17, 18, 19,
            22,     24,
            25, 26,         29,
            30, 31, 32, 33, 34,
            35, 36, 37, 38, 39
        );
        $inventory->setOccupiedPositions($occupiedPosition);
        $this->expectException(FreePositionNotFoundException::class);
        $inventory->getPositionForItem($prototype);
    }

}
