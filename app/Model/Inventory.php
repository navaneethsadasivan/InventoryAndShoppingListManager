<?php
namespace App\Model;

use http\Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class Inventory
 * @package App\Model
 */
class Inventory
{
    /**
     * @var InventoryItem[]
     */
    protected $inventoryItems;

    /**
     * @var int
     */
    protected $totalCount;

    /**
     * This is a list of all the different sections for the inventory. E.g: Kitchen, Bathroom, Pantry, etc
     *
     * @var array
     */
    protected $sections;

    /**
     * @var int
     */
    protected $user;

    public function __construct($userId)
    {
        $this->setUser($userId);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($userId)
    {
        $this->user = $userId;
    }

    /**
     * @return InventoryItem[]
     */
    public function getInventoryItems()
    {
        return $this->inventoryItems;
    }

    /**
     * @param InventoryItem[] $inventoryItems
     */
    public function setInventoryItems(array $inventoryItems)
    {
        $this->inventoryItems = $inventoryItems;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->totalCount;
    }

    /**
     * @param int $totalCount
     */
    public function setTotalCount(int $totalCount)
    {
        $this->totalCount = $totalCount;
    }

    /**
     * @return array
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @param array $sections
     */
    public function setSections(array $sections)
    {
        $this->sections = $sections;
    }

    /**
     * @return array
     */
    public function getUserInventory()
    {
        $itemDetails = [];
        $userInventory = DB::select('
            select item_id, current_stock from inventory_user where user_id =
        ' . $this->getUser() . ' and current_stock > 0');

        if ($userInventory) {
            foreach ($userInventory as $index => $itemInformation) {
                $item = DB::selectOne(
                    'select * from inventory_item where id = ' . $itemInformation->item_id
                );
                $itemDetails[] = [
                    'itemDetails' => $item,
                    'currentStock' => $itemInformation->current_stock
                ];
            }
        }

        return $itemDetails;
    }

    /**
     * @param int $item
     */
    public function save($item)
    {
        $inventoryItem = DB::selectOne('
            select * from inventory_user where item_id =
        ' . $item);

        if ($inventoryItem !== null) {
            DB::table('inventory_user')
                ->where(
                    [
                        'user_id' => $this->getUser(),
                        'item_id' => $item
                    ]
                )
                ->update(
                [
                    'current_stock' => $inventoryItem->current_stock + 1
                ]
            );
        } else {
            DB::table('inventory_user')
                ->insert(
                    [
                        'user_id' => $this->getUser(),
                        'item_id' => $item,
                        'current_stock' => 1
                    ]
            );
        }
    }

    /**
     * @param int $itemId
     * @throws \Exception
     */
    public function removeStock($itemId)
    {
        $inventoryItem = DB::selectOne('select * from inventory_user where item_id = ' . $itemId . ' and user_id = ' . $this->getUser());
        if ($inventoryItem) {
            if ($inventoryItem->current_stock === 0) {
                throw new \Exception('Cannot remove item with stock 0');
            } else {
                DB::table('inventory_user')
                    ->where(
                        [
                            'user_id' => $this->getUser(),
                            'item_id' => $itemId
                        ]
                    )->update(
                        [
                            'current_stock' => $inventoryItem->current_stock - 1
                        ]
                );
            }
        }
    }

    /**
     * @param int $itemId
     * @return mixed
     * @throws \Exception
     */
    public function addStock($itemId)
    {
        $inventoryItem = DB::selectOne('select * from inventory_user where item_id = ' . $itemId . ' and user_id = ' . $this->getUser());
        if ($inventoryItem) {
            DB::table('inventory_user')
                ->where(
                    [
                        'user_id' => $this->getUser(),
                        'item_id' => $itemId
                    ]
                )->update(
                    [
                        'current_stock' => $inventoryItem->current_stock + 1
                    ]
                );
        } else {
            DB::table('inventory_user')
                ->insert(
                    [
                        'user_id' => $this->getUser(),
                        'item_id' => $itemId,
                        'current_stock' => 1
                    ]
                );
        }

        $updatedStock = DB::selectOne('select current_stock from inventory_user where item_id = ' . $itemId . ' and user_id = ' . $this->getUser());

        return $updatedStock->current_stock;
    }

    /**
     * @return array
     */
    public function getPreviousBoughtItems()
    {
        $previousItems = [];
        $items = DB::select(
            'select item_id from inventory_user where user_id = ' . $this->getUser() . ' and current_stock = 0'
        );

        if ($items) {
            foreach ($items as $index => $itemId) {
                $previousItems[] = DB::select(
                    'select * from inventory_item where id = ' . $itemId->item_id
                );
            }
        }

        return $previousItems;
    }
}
