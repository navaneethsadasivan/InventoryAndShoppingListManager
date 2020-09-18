<?php

namespace App\Model;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * Class ShoppingList
 * @package App\Model
 */
class ShoppingList
{
    /**
     * @var Inventory[]
     */
    protected $inventoryItems;

    /**
     * @var float
     */
    protected $totalPrice;

    /**
     * @var int
     */
    protected $totalItemCount;

    /**
     * @var int
     */
    protected $user;

    public function __construct($userId)
    {
        $this->setUserId($userId);
    }

    /**
     * @return Inventory[]
     */
    public function getInventoryItems()
    {
        return $this->inventoryItems;
    }

    /**
     * @param InventoryItem[] $inventoryItems
     */
    public function setInventoryItems($inventoryItems)
    {
        foreach ($inventoryItems as $index => $inventoryItem) {
            $this->inventoryItems[] = $inventoryItem;
        }
    }

    /**
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * @param float $totalPrice
     */
    public function setTotalPrice(float $totalPrice)
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return int
     */
    public function getTotalItemCount()
    {
        return $this->totalItemCount;
    }

    /**
     * @param $inventoryItemsQuantity
     */
    public function setTotalItemCount($inventoryItemsQuantity)
    {
        $totalItemCount = 0;

        foreach ($inventoryItemsQuantity as $inventoryItemQuantity) {
            $totalItemCount += $inventoryItemQuantity;
        }

        $this->totalItemCount = $totalItemCount;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return sprintf("%'02d", $this->user);
    }

    /**
     * @return int
     */
    public function getUserIdWithoutFormat()
    {
        return $this->user;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->user = $userId;
    }

    /**
     * @return array
     */
    public function showList()
    {
        $ml = new ML($this->getUserId());
        return $ml->generateList();
    }

    /**
     * @return string
     */
    public function generateListId()
    {
        $day = substr(date('D'), -3, 1);
        $dmy = date('dmy');

        if ($this->getUserIdWithoutFormat() === 5) {
            $db = DB::selectOne('select list_id from shopping_list where list_id like "Test%" ORDER BY id DESC');
            $listNo = (int)substr($db->list_id, -1);
            $listNo += 1;
            $listNo = sprintf("%'02d", $listNo);

            return 'Test' . $listNo;
        }

        $db = DB::selectOne('select list_id from shopping_list where list_id like "' . $this->getUserId() . '%" ORDER BY id DESC');

        if ($db === null) {
            $listNo = '001';
        } else {
            $listNo = (int)substr($db->list_id, -3);
            $listNo += 1;
            $listNo = sprintf("%'03d", $listNo);
        }

        return 'U' . $this->getUserId() . $day . $dmy . $listNo;
    }

    /**
     * @param Object $shoppingList
     * @return string[]
     * @throws Exception
     */
    public function saveHistory($shoppingList)
    {
        $userInventory = new Inventory($this->getUserIdWithoutFormat());
        $totalPrice = 0;
        $totalItems = 0;
        $listId = $this->generateListId();

        foreach ($shoppingList as $item => $quantity) {
            $totalItems += $quantity;
            $itemPrice = DB::selectOne('select price from inventory_item where id = ' . $item);
            $totalPrice += $itemPrice->price * $quantity;
        }

        DB::table('shopping_list')->insert(
            [
                'list_id' => $listId,
                'user_id' => $this->getUserIdWithoutFormat(),
                'created_at' => date('Y-m-d H:i:s'),
                'total_items' => $totalItems,
                'total_price' => $totalPrice
            ]
        );

        foreach ($shoppingList as $item => $quantity) {
            DB::table('shopping_list_items')->insert(
                [
                    'shopping_list_id' => $listId,
                    'item_id' => $item,
                    'quantity' => $quantity
                ]
            );

            $userInventory->addStock($item, $quantity);
        }
        return [
            'message' => 'List saved successfully'
        ];
    }

    /**
     * @return array
     */
    public function getHistory()
    {
        $returnData = [];
        $historyLists = DB::select(
            'select * from shopping_list where user_id = ' . $this->getUserIdWithoutFormat() . ' ORDER BY id DESC'
        );

        foreach ($historyLists as $index => $historyList) {
            $historyItemName = [];

            $items = DB::select(
                'select * from shopping_list_items where shopping_list_id = "' . $historyList->list_id . '"'
            );

            foreach ($items as $listItemsIndex => $listItem) {
                $itemDetails = DB::selectOne(
                    'select name from inventory_item where id = ' . $listItem->item_id
                );
                $historyItemName[$itemDetails->name] = $listItem->quantity;
            }

            $returnData[] = [
                'listId' => $historyList->list_id,
                'totalPrice' => $historyList->total_price,
                'totalItems' => $historyList->total_items,
                'createdAt' => $historyList->created_at,
                'items' => $historyItemName
            ];
        }

        return $returnData;
    }
}
