<?php
namespace App\Http\Controllers;

use App\Model\ShoppingList;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Class ShoppingListController
 * @package App\Http\Controllers
 */
class ShoppingListController extends Controller
{
    /**
     * @param Authenticatable $userDetails
     * @return array
     */
    public static function show($userDetails)
    {
        $userId = $userDetails['id'];
        $list = new ShoppingList($userId);
        return $list->showList();
    }

    /**
     * @param object $data
     * @param Authenticatable $userDetails
     * @return string[]
     */
    public static function postShoppingList($data, $userDetails)
    {
        $userId = $userDetails['id'];
        $shoppingList = new ShoppingList($userId);
        return $shoppingList->saveHistory($data);
    }

    /**
     * @param Authenticatable $userDetails
     */
    public static function getShoppingListHistory(Authenticatable $userDetails)
    {
        $userId = $userDetails['id'];
        $shoppingList = new ShoppingList($userId);
        return $shoppingList->getHistory();
    }
}
