<?php


namespace App\Controller\Api;


use App\Http\JsonErrorResponse;
use App\Item\Courier\MallCourier;
use App\Metin2Domain\Item\Command\SendItemCommand;
use App\Metin2Domain\Item\Courier\Exception\NoEnoughSpaceException;
use App\Metin2Domain\Item\Courier\ItemCourierInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ItemController {

    protected $logger;

    public function __construct(LoggerInterface $logger) {
        $this->logger = $logger;
    }

    /**
     * @Route("/accounts/{accountId}/inventory/mall", name="apiSendItemToMallAction", methods={"POST"})
     * @param Request $request
     * @param MallCourier $courier
     * @param int $accountId
     * @return JsonResponse|JsonErrorResponse
    */
    public function sendToMallAction(Request $request, MallCourier $courier, int $accountId) {
        if($request->query->has('many')) {
            return $this->sendManyItems($request, $courier, $accountId);
        } else {
            return $this->sendItem($request, $courier, $accountId);
        }
    }

    protected function sendItem(Request $request, ItemCourierInterface $courier, int $ownerId){
        $data = json_decode($request->getContent(), true);

        if(!isset($data['item']['vnum']) || !isset($data['item']['count']))
            return new JsonErrorResponse(400, "Wrong format");

        $data['item']['ownerId'] = $ownerId;
        $command = $this->createSendItemCommand($data['item']);

        try {
            $courier->sendOneItem($command);
            return new JsonResponse();
        } catch (NoEnoughSpaceException $ex) {
            return new JsonErrorResponse(413, "There is no space", 413);
        }
    }

    protected function sendManyItems(Request $request, ItemCourierInterface $courier, int $ownerId) {
        $data = json_decode($request->getContent(), true);

        if(!isset($data['item-list']) || !is_array($data['item-list']))
            return new JsonErrorResponse(400, "Wrong format");

        $commands = array();
        foreach($data['item-list'] as $itemData) {
            if(!isset($itemData['vnum']) || !isset($itemData['count']))
                return new JsonErrorResponse(400, "Wrong format");

            $itemData['ownerId'] = $ownerId;
            $commands[] = $this->createSendItemCommand($itemData);
        }

        try {
            $courier->sendMultipleItems($data['ownerId'], $commands);
            return new JsonResponse();
        } catch (NoEnoughSpaceException $enoughSpaceException) {
            return new JsonErrorResponse(413, "There is no space", 413);
        }
    }

    protected function createSendItemCommand(array $data): SendItemCommand {
        $command = new SendItemCommand(
            $data['ownerId'],
            $data['vnum'],
            $data['count'],
            $data['socket0']??0,
            $data['socket1']??0,
            $data['socket2']??0,
            $data['socket3']??0,
            $data['socket4']??0,
            $data['socket5']??0,
            $data['attrType0']??0,
            $data['attrType1']??0,
            $data['attrType2']??0,
            $data['attrType3']??0,
            $data['attrType4']??0,
            $data['attrType5']??0,
            $data['attrType6']??0,
            $data['attrValue0']??0,
            $data['attrValue1']??0,
            $data['attrValue2']??0,
            $data['attrValue3']??0,
            $data['attrValue4']??0,
            $data['attrValue5']??0,
            $data['attrValue6']??0
        );
        return $command;
    }

}