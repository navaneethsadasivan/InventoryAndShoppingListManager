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
     * @param int $item
     * @return mixed
     * @throws Exception
     */
    public static function postAddItem($itemId, $requestUser = null)
    {
        $user = Auth::user();

        if ($user === null && $requestUser !== null) {
            $user = [
                'id' => $requestUser
            ];
        }

        $inventory = new Inventory($user['id']);
        return $inventory->addStock($itemId);
    }

    /**
     * @param int $item
     * @throws Exception
     */
    public static function postRemoveItem($itemId, $requestUser)
    {
        $user = Auth::user();

        if ($user === null && $requestUser !== null) {
            $user = [
                'id' => $requestUser
            ];
        }

        $inventory = new Inventory($user['id']);
        return $inventory->removeStock($itemId);
    }

    /**
     * @return array
     */
    public static function getPrevItems($requestUser)
    {
        $user = Auth::user();

        if ($user === null && $requestUser !== null) {
            $user = [
                'id' => $requestUser
            ];
        }

        $inventory = new Inventory($user['id']);
        return $inventory->getPreviousBoughtItems();
    }

    /**
     * @return array
     */
    public static function getExpiringItems()
    {
        $user = Auth::user();
        $inventory = new Inventory($user['id']);
        return $inventory->getExpiredItems();
    }
}
