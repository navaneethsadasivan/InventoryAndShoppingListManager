<?php
namespace Tests\Unit\TestModel;

use App\Model\Inventory;
use App\Model\InventoryItem;
use Tests\TestCase;

class InventoryTest extends TestCase
{
    /**
     * @var array
     */
    protected $successData = [
        'user' => 1,
        'inventoryItem' => [
            'item1' => [
                'Name' => 'Vanilla Cheesecake',
                'Quantity' => 2,
                'Price' => 1.35,
                'Description' => 'This is a cheesecake',
                'Type' => 'Bakery',
                'Usage' => 2
            ],
            'item2' => [
                'Name' => 'Fettuccine',
                'Quantity' => 3,
                'Price' => 0.85,
                'Description' => 'This is pasta',
                'Type' => 'Pasta',
                'Usage' => 5
            ]
        ],
        'totalCount' => 5,
        'totalPrice' => 5.25
    ];

    public function testInventoryConstruct()
    {
        $userInventory = new Inventory($this->successData['user']);
        $this->assertTrue($userInventory->getUser() === $this->successData['user']);
    }

    public function testInventoryItemGetterAndSetter()
    {
        $inventoryItem1 = new InventoryItem();
        $inventoryItem1->setPrice($this->successData['inventoryItem']['item1']['Price']);
        $inventoryItem1->setName($this->successData['inventoryItem']['item1']['Name']);
        $inventoryItem1->setType($this->successData['inventoryItem']['item1']['Type']);
        $inventoryItem1->setUsage($this->successData['inventoryItem']['item1']['Usage']);
        $inventoryItem1->setQuantity($this->successData['inventoryItem']['item1']['Quantity']);
        $inventoryItem1->setDescription($this->successData['inventoryItem']['item1']['Description']);

        $inventoryItem2 = new InventoryItem();
        $inventoryItem2->setPrice($this->successData['inventoryItem']['item2']['Price']);
        $inventoryItem2->setName($this->successData['inventoryItem']['item2']['Name']);
        $inventoryItem2->setType($this->successData['inventoryItem']['item2']['Type']);
        $inventoryItem2->setUsage($this->successData['inventoryItem']['item2']['Usage']);
        $inventoryItem2->setQuantity($this->successData['inventoryItem']['item2']['Quantity']);
        $inventoryItem2->setDescription($this->successData['inventoryItem']['item2']['Description']);

        $inventory = new Inventory($this->successData['user']);
        $inventory->setInventoryItems([
            'item1' => $inventoryItem1,
            'item2' => $inventoryItem2
        ]);
        $this->assertTrue(gettype($inventory->getInventoryItems()) === 'array');
    }

    public function testInventoryTotalCountGetterAndSetter()
    {
        $inventory = new Inventory($this->successData['user']);
        $inventory->setTotalCount($this->successData['totalCount']);
        $this->assertTrue($inventory->getTotalCount() === $this->successData['totalCount']);
        $this->assertFalse($inventory->getTotalCount() === 4.00);
    }
}
