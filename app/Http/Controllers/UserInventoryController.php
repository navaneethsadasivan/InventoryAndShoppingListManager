<?php
namespace App\Http\Controllers;

use App\Model\Inventory;
use Exception;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserInventoryController
 * @package App\Http\Controllers
 */
class UserInventoryController extends Controller
{
    /**
     * @param int $user
     * @return array
     */
    public static function getUserInventory($user)
    {
        $inventory = new Inventory($user);
        return $inventory->getUserInventory();
    }

    /**
     * @param int $itemId
     * @param int $userId
     * @return mixed
     * @throws Exception
     */
    public static function postAddItem($itemId, $userId)
    {
        $inventory = new Inventory($userId);
        return $inventory->addStock($itemId);
    }

    /**
     * @param int $itemId
     * @param int $userId
     * @return array
     * @throws Exception
     */
    public static function postRemoveItem($itemId, $userId)
    {
        $inventory = new Inventory($userId);
        return $inventory->removeStock($itemId);
    }

    /**
     * @param int $userId
     * @return array
     */
    public static function getPrevItems($userId)
    {
        $inventory = new Inventory($userId);
        return $inventory->getPreviousBoughtItems();
    }

    /**
     * @param int $userId
     * @return array
     */
    public static function getExpiringItems($userId)
    {
        $inventory = new Inventory($userId);
        return $inventory->getExpiredItems();
    }
}
