<?php
namespace Tests\Unit\TestModel;

use App\Model\InventoryItem;
use PHPUnit\Framework\TestCase;

class InventoryItemTest extends TestCase
{
    protected $successTestData = [
        'quantity' => 2,
        'name' => 'Vanilla Cheesecake',
        'type' => 'Bakery',
        'description' => 'This is a vanilla cheesecake',
        'price' => 1.45,
        'usage' => 2
    ];

    public function testInventoryItemQuantityGetterAndSetter()
    {
        $inventoryItem = new InventoryItem();
        $inventoryItem->setQuantity($this->successTestData['quantity']);
        $this->assertTrue($inventoryItem->getQuantity() === $this->successTestData['quantity']);
        $this->assertFalse($inventoryItem->getQuantity() === 3);
    }

    public function testInventoryItemNameGetterAndSetter()
    {
        $inventoryItem = new InventoryItem();
        $inventoryItem->setName($this->successTestData['name']);
        $this->assertTrue($inventoryItem->getName() === $this->successTestData['name']);
        $this->assertFalse($inventoryItem->getName() === 'This is wrong');
    }

    public function testInventoryItemDescriptionGetterAndSetter()
    {
        $inventoryItem = new InventoryItem();
        $inventoryItem->setDescription($this->successTestData['description']);
        $this->assertTrue($inventoryItem->getDescription() === $this->successTestData['description']);
        $this->assertFalse($inventoryItem->getDescription() === 'This is not the description');
    }

    public function testInventoryItemUsageGetterAndSetter()
    {
        $inventoryItem = new InventoryItem();
        $inventoryItem->setUsage($this->successTestData['usage']);
        $this->assertTrue($inventoryItem->getUsage() === $this->successTestData['usage']);
        $this->assertFalse($inventoryItem->getUsage() === 1);
    }

    public function testInventoryItemTypeGetterAndSetter()
    {
        $inventoryItem = new InventoryItem();
        $inventoryItem->setType($this->successTestData['type']);
        $this->assertTrue($inventoryItem->getType() === $this->successTestData['type']);
        $this->assertFalse($inventoryItem->getType() === 'Not Bakery');
    }

    public function testInventoryItemPriceGetterAndSetter()
    {
        $inventoryItem = new InventoryItem();
        $inventoryItem->setPrice($this->successTestData['price']);
        $this->assertTrue($inventoryItem->getPrice() === $this->successTestData['price']);
        $this->assertFalse($inventoryItem->getPrice() === 2.8);
    }
}
