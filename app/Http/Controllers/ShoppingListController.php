<?php
namespace App\Http\Controllers;

use App\Model\ShoppingList;

/**
 * Class ShoppingListController
 * @package App\Http\Controllers
 */
class ShoppingListController extends Controller
{
    public static function show($userDetails)
    {
        $userId = $userDetails['id'];
        $list = new ShoppingList($userId);
        return $list->showList();
    }

    public static function getHistoryData($data, $userDetails)
    {
        $userId = $userDetails['id'];
        $shoppingList = new ShoppingList($userId);
        return $shoppingList->saveHistory($data);
    }
}
