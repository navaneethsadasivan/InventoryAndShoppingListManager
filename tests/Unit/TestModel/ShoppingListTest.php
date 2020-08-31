<?php
namespace Tests\Unit\TestModel;

use App\Model\InventoryItem;
use App\Model\ShoppingList;
use Tests\TestCase;

class ShoppingListTest extends TestCase
{
    /**
     * @var array
     */
    protected $successData = [
        'user' => 1,
        'inventoryItem' => [
            'item1' => [
                'Name' => 'Vanilla Cheesecake',
                'Price' => 1.35,
                'Description' => 'This is a cheesecake',
                'Type' => 'Bakery',
                'Usage' => 2
            ],
            'item1Quantity' => 2,
            'item2' => [
                'Name' => 'Fettuccine',
                'Price' => 0.85,
                'Description' => 'This is pasta',
                'Type' => 'Pasta',
                'Usage' => 5
            ],
            'item2Quantity' => 3
        ],
        'totalCount' => 5,
        'totalPrice' => 5.25
    ];

    public function testShoppingListConstruct()
    {
        $shoppingList = new ShoppingList($this->successData['user']);
        $this->assertTrue($shoppingList->getUserIdWithoutFormat() === $this->successData['user']);
        $this->assertFalse($shoppingList->getUserIdWithoutFormat() === 'Not a user');
        $this->assertTrue($shoppingList->getUserId() === sprintf("%'02d", $this->successData['user']));
        $this->assertFalse($shoppingList->getUserId() === $this->successData['user']);
    }

    public function testShoppingListInventoryItemGetterAndSetter()
    {
        $inventoryItem1 = new InventoryItem();
        $inventoryItem1->setPrice($this->successData['inventoryItem']['item1']['Price']);
        $inventoryItem1->setName($this->successData['inventoryItem']['item1']['Name']);
        $inventoryItem1->setType($this->successData['inventoryItem']['item1']['Type']);
        $inventoryItem1->setUsage($this->successData['inventoryItem']['item1']['Usage']);
        $inventoryItem1->setDescription($this->successData['inventoryItem']['item1']['Description']);

        $inventoryItem2 = new InventoryItem();
        $inventoryItem2->setPrice($this->successData['inventoryItem']['item2']['Price']);
        $inventoryItem2->setName($this->successData['inventoryItem']['item2']['Name']);
        $inventoryItem2->setType($this->successData['inventoryItem']['item2']['Type']);
        $inventoryItem2->setUsage($this->successData['inventoryItem']['item2']['Usage']);
        $inventoryItem2->setDescription($this->successData['inventoryItem']['item2']['Description']);

        $shoppingList = new ShoppingList($this->successData['user']);
        $shoppingList->setInventoryItems([
            'item1' => $inventoryItem1,
            'item2' => $inventoryItem2
        ]);
        $this->assertTrue(gettype($shoppingList->getInventoryItems()) === 'array');
    }

    public function testShoppingListTotalCountGetterAndSetter()
    {
        $inventoryItem1 = new InventoryItem();
        $inventoryItem1->setPrice($this->successData['inventoryItem']['item1']['Price']);
        $inventoryItem1->setName($this->successData['inventoryItem']['item1']['Name']);
        $inventoryItem1->setType($this->successData['inventoryItem']['item1']['Type']);
        $inventoryItem1->setUsage($this->successData['inventoryItem']['item1']['Usage']);
        $inventoryItem1->setDescription($this->successData['inventoryItem']['item1']['Description']);

        $inventoryItem2 = new InventoryItem();
        $inventoryItem2->setPrice($this->successData['inventoryItem']['item2']['Price']);
        $inventoryItem2->setName($this->successData['inventoryItem']['item2']['Name']);
        $inventoryItem2->setType($this->successData['inventoryItem']['item2']['Type']);
        $inventoryItem2->setUsage($this->successData['inventoryItem']['item2']['Usage']);
        $inventoryItem2->setDescription($this->successData['inventoryItem']['item2']['Description']);

        $shoppingList = new ShoppingList($this->successData['user']);
        $shoppingList->setTotalItemCount([
            $this->successData['inventoryItem']['item1Quantity'],
            $this->successData['inventoryItem']['item2Quantity']
        ]);
        $this->assertTrue($shoppingList->getTotalItemCount() === $this->successData['totalCount']);
        $this->assertFalse($shoppingList->getTotalItemCount() === 0);
    }

    public function testShoppingListTotalPriceGetterAndSetter()
    {
        $shoppingList = new ShoppingList($this->successData['user']);
        $shoppingList->setTotalPrice($this->successData['totalPrice']);
        $this->assertTrue($shoppingList->getTotalPrice() === $this->successData['totalPrice']);
        $this->assertFalse($shoppingList->getTotalPrice() === 0);
    }
}
