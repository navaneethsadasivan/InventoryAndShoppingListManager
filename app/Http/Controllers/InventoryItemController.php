<?php
namespace App\Http\Controllers;

use App\Model\InventoryItem;

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
     * @return array
     */
    public static function searchItem($params, $userDetails)
    {
        $user = $userDetails['id'];
        $inventory = new InventoryItem();
        return $inventory->getSearchData($params, $user);
    }

    /**
     * @param object $item
     * @return string
     */
    public static function addItem($item)
    {
        $inventory = new InventoryItem();
        $newItem = [
            'name' => $item->name,
            'price' => $item->price,
            'useBy' => $item->useBy
        ];

        return $inventory->addItem($newItem);
    }

    /**
     * @param Object $item
     * @return mixed
     */
    public static function updateItem($item)
    {
        $inventory = new InventoryItem();
        $updatedItem = [
            'id' => $item->id,
            'name' => $item->name,
            'price' => $item->price,
            'useBy' => $item->useBy
        ];

        return $inventory->updateItem($updatedItem);
    }
}
