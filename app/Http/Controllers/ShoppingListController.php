<?php
namespace App\Http\Controllers;

use App\Model\ShoppingList;

/**
 * Class ShoppingListController
 * @package App\Http\Controllers
 */
class ShoppingListController extends Controller
{
    /**
     * @param array $userDetails
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
     * @param array $userDetails
     * @return string[]
     */
    public static function getHistoryData($data, $userDetails)
    {
        $userId = $userDetails['id'];
        $shoppingList = new ShoppingList($userId);
        return $shoppingList->saveHistory($data);
    }
}
