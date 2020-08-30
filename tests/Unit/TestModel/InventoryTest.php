<?php
namespace Tests\Unit\TestModel;

use App\Model\Inventory;
use Tests\TestCase;

class InventoryTest extends TestCase
{
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
    }
}
