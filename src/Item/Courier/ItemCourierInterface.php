<?php


namespace App\Item\Courier;



use App\Item\Courier\Exception\NoEnoughSpaceException;
use App\Item\Request\SendItemRequest;

interface ItemCourierInterface {

    /**
     * @param SendItemRequest $request
     * @throws NoEnoughSpaceException
     */
    public function sendOneItem(SendItemRequest $request): void;

    /**
     * @param int $receiverId
     * @param SendItemRequest[] $requests
     * @throws NoEnoughSpaceException
     */
    public function sendMultipleItems(int $receiverId, array $requests): void;

}