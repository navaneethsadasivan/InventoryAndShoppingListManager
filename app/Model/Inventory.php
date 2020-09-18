<?php
namespace App\Model;

use Exception;
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
     * @var int
     */
    protected $user;

    public function __construct($userId)
    {
        $this->setUser($userId);
    }

    /**
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    public function getUserWithFormat()
    {
        return sprintf("%'02d", $this->user);
    }

    /**
     * @param $userId
     */
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
     * @return Inventory
     */
    public function setInventoryItems(array $inventoryItems)
    {
        $this->inventoryItems = $inventoryItems;
        return $this;
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
     * @return Inventory
     */
    public function setTotalCount(int $totalCount)
    {
        $this->totalCount = $totalCount;
        return $this;
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
     * @param int $itemId
     * @return array
     * @throws Exception
     */
    public function removeStock($itemId)
    {
        $inventoryItem = DB::selectOne('select * from inventory_user where item_id = ' . $itemId . ' and user_id = ' . $this->getUser());
        if ($inventoryItem) {
            if ($inventoryItem->current_stock === 0) {
                throw new Exception('Cannot remove item with stock 0');
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

                $updatedStock = DB::selectOne('select current_stock from inventory_user where item_id = ' . $itemId . ' and user_id = ' . $this->getUser());

                return [
                    'item' => $itemId,
                    'currentStock' => $updatedStock->current_stock
                ];
            }
        }
    }

    /**
     * @param int $itemId
     * @return mixed
     * @throws Exception
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

        return [
            'Item' => $itemId,
            'CurrentStock' => $updatedStock->current_stock
        ];
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

    /**
     * @return array
     */
    public function getExpiredItems()
    {
        $largestUseByTime = DB::selectone('select max(use_by) as longest from inventory_item');
        $rowCount = DB::selectone('select count(*) as rowCount from shopping_list where list_id like "U' . $this->getUserWithFormat() . '%"');
        $largestUseByTime->longest = 2;

        $maxLatestDate = date("Y-m-d H:i:s", strtotime("-" . $largestUseByTime->longest . " weeks"));

        $latestListIds = DB::select(
            'select
                list_id, created_at
            from
                shopping_list
            where list_id like "U' . $this->getUserWithFormat() . '%"
            and created_at >= "' . $maxLatestDate . '%"
            ORDER BY id asc'
        );

        $historyListItems = [];

        foreach ($latestListIds as $index => $listDetails) {
            $items = DB::select('select item_id from shopping_list_items where shopping_list_id = "' . $listDetails->list_id . '"');
            $historyListItems[$listDetails->list_id] = [
                'items' => $items,
                'listCreatedAt' => $listDetails->created_at
            ];
        }

        $expiringItems = [];
        foreach ($historyListItems as $listId => $listItems) {
            if (!empty($expiringItems)) {
                foreach ($expiringItems as $itemId => $latestEntry) {
                    foreach ($listItems['items'] as $index => $itemObject) {
                        if ($itemId === $itemObject->item_id) {
                            $expiringItems[$itemObject->item_id] = $listItems['listCreatedAt'];
                        } else if (!in_array($itemObject->item_id, array_keys($expiringItems))) {
                            $expiringItems[$itemObject->item_id] = $listItems['listCreatedAt'];
                        }
                    }
                }
            } else {
                foreach ($listItems['items'] as $index => $itemObject) {
                    if (!in_array($itemObject->item_id, array_keys($expiringItems))) {
                        $expiringItems[$itemObject->item_id] = $listItems['listCreatedAt'];
                    }
                }
            }
        }

        foreach ($expiringItems as $id => $lastBought) {
            $item = DB::selectone('select * from inventory_item where id = ' . $id);

            $expiringDate = date("Y-m-d H:i:s", strtotime('+' . $item->use_by . ' weeks', strtotime($lastBought)));

            if ($expiringDate > date("Y-m-d H:i:s")) {
                unset($expiringItems[$id]);
            } else {
                $expiringItems[$id] = [
                    'itemDetails' => $item,
                    'lastBought' => date("d/m/y", strtotime($expiringItems[$id]))
                ];
            }
        }

        return $expiringItems;
    }
}
