<?php
namespace App\Model;

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
}
