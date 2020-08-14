<?php

namespace App\Model;
use Illuminate\Support\Facades\DB;
use Phpml\Association\Apriori;

/**
 * Class ShoppingList
 * @package App\Model
 */
class ShoppingList
{
    /**
     * @var InventoryItem[]
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
     * @return InventoryItem[]
     */
    public function getInventoryItems()
    {
        return $this->inventoryItems;
    }

    /**
     * @param InventoryItem $inventoryItems
     */
    public function setInventoryItems($inventoryItems)
    {
        $this->inventoryItems[] = $inventoryItems->asArray();
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
     * @param InventoryItem[] $inventoryItems
     */
    public function setTotalItemCount($inventoryItems)
    {
        $totalItemCount = 0;

        foreach ($inventoryItems as $inventoryItem) {
            $totalItemCount += $inventoryItem->getQuantity();
        }

        $this->totalItemCount = $totalItemCount;
    }

    public function generateList()
    {
        //add logic
        $ml = new AprioriTrain();
        return $ml->generateList($this->getExpiredItems());

//        $item1 = new InventoryItem(2);
//        $this->setInventoryItems($item1);
//
//        $item2 = new InventoryItem(3);
//        $this->setInventoryItems($item2);
//
//        $this->setTotalItemCount([$item1, $item2]);
//
//        $total = $item1->getPrice() + $item2->getPrice();
//        $this->setTotalPrice($total);
    }

    public function showList()
    {
        //        return [
//            'Items' => $this->getInventoryItems(),
//            'Total Price' => $this->getTotalPrice(),
//            'Item count' => $this->getTotalItemCount()
//        ];
        return $this->generateList();
    }

    public function generateListId()
    {
        $day = substr(date('D'), -3, 1);
        $dmy = date('dmy');

        $db = DB::selectOne('select list_id from shopping_list ORDER BY id DESC');

        if ($db === null) {
            $listNo = '001';
        } else {
            $listNo = (int)substr($db->list_id, -3);
            $listNo += 1;
            $listNo = sprintf("%'03d", $listNo);
        }

        return 'U02' . $day . $dmy . $listNo;
    }

    public function saveHistory($previousLists)
    {
        foreach ($previousLists as $index => $prevShoppingList) {
            $totalPrice = 0.00;
            $listId = $this->generateListId();

            foreach ($prevShoppingList as $item) {
                $itemPrice = DB::selectOne('select price from inventory_item where id = ' . $item);
                $totalPrice += $itemPrice->price;
            }

            DB::table('shopping_list')->insert(
                [
                    'list_id' => $listId,
                    'user_id' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'total_items' => count($prevShoppingList),
                    'total_price' => $totalPrice
                ]
            );

            foreach ($prevShoppingList as $item) {
                DB::table('shopping_list_items')->insert(
                    [
                        'shopping_list_id' => $listId,
                        'item_id' => $item,
                        'quantity' => 1
                    ]
                );
            }
        }
    }

    public function getExpiredItems()
    {
        $largestUseByTime = DB::selectone('select max(use_by) as longest from inventory_item');
        $rowCount = DB::selectone('select count(*) as rowCount from shopping_list where list_id like "U02%"');
        $latestListIds = DB::select(
            'select
                list_id
            from
                shopping_list
            where list_id like "U02%"
            ORDER BY id asc
            limit ' . $largestUseByTime->longest .
            ' OFFSET ' . ($rowCount->rowCount - $largestUseByTime->longest)
        );

        $historyListItems = [];

        foreach ($latestListIds as $index => $listId) {
            $items = DB::select('select item_id from shopping_list_items where shopping_list_id = "' . $listId->list_id . '"');
            $historyListItems[$listId->list_id] = $items;
        }

        $expiringItems = [];
        foreach ($historyListItems as $listId => $listItems) {
            if (!empty($expiringItems)) {
                foreach ($expiringItems as $itemId => $latestEntry) {
                    $flag = 0;
                    foreach ($listItems as $index => $itemObject) {
                        if ($itemId === $itemObject->item_id) {
                            $flag = 1;
                        }
                    }

                    if ($flag === 1) {
                        $expiringItems[$itemId] = 1;
                    } else {
                        $expiringItems[$itemId] += 1;
                    }
                }
            }

            foreach ($listItems as $index => $itemObject) {
                if (!in_array($itemObject->item_id, array_keys($expiringItems))) {
                    $expiringItems[$itemObject->item_id] = 1;
                }
            }
        }

        return $expiringItems;
    }
}
