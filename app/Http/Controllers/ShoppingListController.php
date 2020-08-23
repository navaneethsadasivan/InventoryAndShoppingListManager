<?php
namespace App\Http\Controllers;

use App\Model\ShoppingList;

/**
 * Class ShoppingListController
 * @package App\Http\Controllers
 */
class ShoppingListController extends Controller
{
    public static function show()
    {
        $list = new ShoppingList();
        return $list->showList();
    }

    public static function getHistoryData($data, $userDetails)
    {
        $userId = $userDetails['id'];
        $shoppingList = new ShoppingList();
        return $shoppingList->saveHistory($data, $userId);
    }
}
