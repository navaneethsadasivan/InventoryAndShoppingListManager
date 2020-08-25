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
     * @param int $item
     * @return array
     */
    public static function searchItem($item)
    {
        $inventory = new InventoryItem();
        return $inventory->getSearchData($item);
    }

    /**
     * @param object $item
     * @return string
     */
    public static function addItem($item)
    {
        $inventory = new InventoryItem();
        $newItem = [];
        foreach ($item as $itemData) {
            $newItem[$itemData->name] = $itemData->value;
        }

        return $inventory->addItem($newItem);
    }
}
