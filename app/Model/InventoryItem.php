<?php
namespace App\Model;

use DateTime;
use http\Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Error\Warning;
use Whoops\Exception\ErrorException;

/**
 * Class InventoryItem
 * @package App\Model
 */
class InventoryItem
{
    /**
     * This is a list of all the different sections for the inventory. E.g: Kitchen, Bathroom, Pantry, etc
     *
     * @var string[]
     */
    private $defaultSections = [
        'Bakery',
        'Breakfast and cereal',
        'Sauce',
        'Pasta',
        'Sweets',
        'Frozen food',
        'Drinks',
        'Milk, butter and eggs',
        'Vegetables',
        'Meat',
        'Cans and Packets',
        'Cooking Ingredients'
    ];

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var float
     */
    protected $price;

    /**
     * @var string
     */
    protected $type;

    /**
     * This is the user entered/predicted usage of an inventory item
     * Set with days as unit
     *
     * @var int
     */
    protected $usage;

    /**
     * @var int
     */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return InventoryItem
     */
    public function setId(int $id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return InventoryItem
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return InventoryItem
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return InventoryItem
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return InventoryItem
     * @throws \Exception
     */
    public function setType(string $type)
    {
        if (in_array($type, $this->defaultSections)) {
            $this->type = $type;
            return $this;
        } else {
            throw new \Exception('This is not a valid section');
        }
    }

    /**
     * @return int
     */
    public function getUsage()
    {
        return $this->usage;
    }

    /**
     * @param int $usage
     * @return InventoryItem
     */
    public function setUsage(int $usage)
    {
        $this->usage = $usage;
        return $this;
    }

    /**
     * @return array
     */
    public function asArray()
    {
        return [
            'Name' => $this->getName(),
            'Description' => $this->getDescription(),
            'Price' => $this->getPrice(),
            'Usage' => $this->getUsage(),
            'Type' => $this->getType()
        ];
    }

    /**
     * @return array
     */
    public function getData()
    {
        return DB::select('select * from inventory_item');
    }

    /**
     * $params should contain the item name and the mode of search
     *0: No type
     *1: User inventory
     *2: List creation
     *
     * @param object $params
     * @param int $user
     * @return array
     */
    public function getSearchData($params, $user)
    {
        $generalSearch = null;
        foreach ($params as $index => $requestDetails) {
            $generalSearch = DB::select('select * from inventory_item where name like "%' . $requestDetails->itemName . '%"');

            if ($generalSearch === null) {
                $generalSearch = DB::select('select * from inventory_item where type like "%' . $requestDetails->itemName . '%"');
            }
            if ($requestDetails->type === 1) {
                $userInventory = new Inventory($user);
                $userCurrentInventory = $userInventory->getUserInventory();
                $userPrevBoughtItems = $userInventory->getPreviousBoughtItems();
                foreach ($generalSearch as $generalIndex => $generalSearchItemDetails) {
                    foreach ($userCurrentInventory as $currentInvIndex => $userCurrentInvDetails) {
                        if ($generalSearchItemDetails->id === $userCurrentInvDetails['itemDetails']->id) {
                            unset($generalSearch[$generalIndex]);
                        }
                    }
                    foreach ($userPrevBoughtItems as $prevBoughtIndex => $prevBoughtDetails) {
                        if ($generalSearchItemDetails->id === $prevBoughtDetails[0]->id) {
                            unset($generalSearch[$generalIndex]);
                        }
                    }
                }
            } elseif ($requestDetails->type === 2) {
                foreach ($generalSearch as $generalIndex => $generalSearchItemDetails) {
                    foreach ($requestDetails->addedItems as $itemId => $quantity) {
                        if ($generalSearchItemDetails->id === (int)$itemId) {
                            unset($generalSearch[$generalIndex]);
                        }
                    }
                }
            }
        }

        return $generalSearch;
    }

    /**
     * @param array $item
     * @return string
     */
    public function addItem($item)
    {
        DB::table('inventory_item')->insert(
            [
                'name' => $item['name'],
                'price' => $item['price'],
                'use_by' => $item['useBy']
            ]
        );

        return 'Item Added';
    }

    /**
     * @param array $updatedItem
     * @return string
     */
    public function updateItem()
    {
        try {
            DB::table('inventory_item')
                ->where(
                    [
                        'id' => $this->getId()
                    ]
                )->update(
                    [
                        'name' => $this->getName(),
                        'price' => $this->getPrice(),
                        'use_by' => $this->getUsage(),
                        'type' => $this->getType()
                    ]
                );

            return 200;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
