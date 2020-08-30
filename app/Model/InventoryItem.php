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
     * @var int
     */
    protected $quantity;

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
     * @var DateTime
     */
    protected $expiryDate;

    /**
     * This is the user entered/predicted usage of an inventory item
     * Set with days as unit
     *
     * @var int
     */
    protected $usage;

    /**
     * InventoryItem constructor.
     * @param null|int $id
     */
    public function __construct($id = null)
    {
        if ($id === null) {
            return true;
        }

        $data = DB::selectOne('select * from inventory_item where id = ' . $id);

        if ($data) {
            $this->setName($data->name);
            $this->setDescription($data->description);
            $this->setPrice($data->price);
            $this->setQuantity(2);
            $this->setType($data->type);
            $this->setUsage($data->use_by);
        }

        return [
            'item' => $this->asArray()
        ];
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity)
    {
        $this->quantity = $quantity;
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
     */
    public function setName(string $name)
    {
        $this->name = $name;
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
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
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
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
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
     */
    public function setType(string $type)
    {
        $this->type = $type;
    }

    /**
     * @return DateTime
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * @param DateTime $expiryDate
     */
    public function setExpiryDate(DateTime $expiryDate)
    {
        $this->expiryDate = $expiryDate;
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
     */
    public function setUsage(int $usage)
    {
        $this->usage = $usage;
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
            'Type' => $this->getType(),
            'Quantity' => $this->getQuantity()
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
    public function updateItem($updatedItem)
    {
        DB::table('inventory_item')
            ->where(
                [
                    'id' => $updatedItem['id']
                ]
            )->update(
                [
                    'name' => $updatedItem['name'],
                    'price' => $updatedItem['price'],
                    'use_by' => $updatedItem['useBy']
                ]
            );

        return 'Item Updated';
    }
}
