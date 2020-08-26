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
     * @return array
     */
    public static function getUserInventory()
    {
        $user = Auth::user();
        $inventory = new Inventory($user['id']);
        return $inventory->getUserInventory();
    }

    /**
     * @param int $item
     * @return mixed
     * @throws Exception
     */
    public static function postAddItem($item)
    {
        $user = Auth::user();
        $inventory = new Inventory($user['id']);
        return $inventory->addStock($item);
    }

    /**
     * @param int $item
     * @throws Exception
     */
    public static function postRemoveItem($item)
    {
        $user = Auth::user();
        $inventory = new Inventory($user['id']);
        return $inventory->removeStock($item);
    }

    public static function getPrevItems()
    {
        $user = Auth::user();
        $inventory = new Inventory($user['id']);
        return $inventory->getPreviousBoughtItems();
    }
}
