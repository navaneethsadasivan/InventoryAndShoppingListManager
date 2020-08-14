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

    public function getData()
    {
        return DB::select('select * from inventory_item');
    }

    public function getSearchData($item)
    {
        $db = DB::select('select * from inventory_item where name like "%' . $item . '%"');

        if ($db === null) {
            $db = DB::select('select * from inventory_item where type like "%' . $item . '%"');
        }

        return $db;
    }

    public function addItem($item)
    {
        try {
            DB::table('inventory_item')->insert(
                [
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'use_by' => $item['useBy']
                ]
            );

            return 'Item Added';
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
