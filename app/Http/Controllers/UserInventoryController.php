<?php
namespace App\Http\Controllers;

use App\Model\Inventory;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserInventoryController
 * @package App\Http\Controllers
 */
class UserInventoryController extends Controller
{
    public static function getUserInventory()
    {
        $user = Auth::user();
        $inventory = new Inventory($user['id']);
        return $inventory->getUserInventory();
    }

    public static function postAddItem($item)
    {
        $user = Auth::user();
        $inventory = new Inventory($user['id']);
        return $inventory->addStock($item);
    }

    public static function postRemoveItem($item)
    {
        $user = Auth::user();
        $inventory = new Inventory($user['id']);
        return $inventory->removeStock($item);
    }
}
