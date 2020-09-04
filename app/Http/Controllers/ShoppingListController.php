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
     * @param int $userId
     * @return string[]
     */
    public static function postShoppingList($data, $userId)
    {
        $shoppingList = new ShoppingList($userId);
        return $shoppingList->saveHistory($data);
    }

    /**
     * @param int $userId
     * @return array
     */
    public static function getShoppingListHistory($userId)
    {
        $shoppingList = new ShoppingList($userId);
        return $shoppingList->getHistory();
    }
}
