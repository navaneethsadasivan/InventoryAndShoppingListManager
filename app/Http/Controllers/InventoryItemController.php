<?php
namespace App\Http\Controllers;

use App\Model\InventoryItem;
use Exception;

/**
 * Class InventoryItemController
 * @package App\Http\Controllers
 */
class InventoryItemController extends Controller
{
    /**
     * @return array
     */
    public static function show()
    {
        $item = new InventoryItem();
        return $item->getData();
    }

    /**
     * @param object $params
     * @param int $user
     * @return array
     */
    public static function searchItem($params, $user)
    {
        $inventory = new InventoryItem();
        return $inventory->getSearchData($params, $user);
    }

    /**
     * @param object $item
     * @return string
     * @throws Exception
     */
    public static function addItem($item)
    {
        $inventory = new InventoryItem();
        $inventory->setName(
            $item->name
        )->setPrice(
            $item->price
        )->setUsage(
            $item->useBy
        )->setType(
            $item->type
        );

        return $inventory->addItem();
    }

    /**
     * @param Object $item
     * @return mixed
     * @throws Exception
     */
    public static function updateItem($item)
    {
        $inventory = new InventoryItem();
        $inventory->setName(
            $item->name
        )->setId(
            $item->id
        )->setType(
            $item->type
        )->setUsage(
            $item->useBy
        )->setPrice(
            $item->price
        );

        return $inventory->updateItem();
    }
}
