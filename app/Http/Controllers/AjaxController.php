<?php

namespace App\Http\Controllers;
use App\Model\Inventory;
use App\Model\InventoryItem;
use Error;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class AjaxController
 * @package App\Http\Controllers
 */
class AjaxController extends Controller
{
    /**
     * Connect InventoryItemController to get all items in the database
     *
     * @return JsonResponse
     */
    public function getInventoryItems()
    {
        if (InventoryItemController::show() === 'No data found') {
            return response()->json(['message' => 'No data found'], 200);
        } else {
            return response()->json(['items' => InventoryItemController::show()], 200);
        }
    }

    /**
     * Connect ShoppingListController to generate a new list
     *
     * @return JsonResponse
     */
    public function getShoppingList()
    {
        return response()->json(['list' => ShoppingListController::show(Auth::user())], 200);
    }

    /**
     * Connect AprioriController to get all apriori association rules after training
     *
     * @return JsonResponse
     */
    public function getApriori()
    {
        return response()->json(['apriori' => AprioriController::show()], 200);
    }

    /**
     * Connect to ShoppingLIstController to save the user list history
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function postShoppingList(Request $request)
    {
        $data = null;
        if (json_decode($request->getContent())) {
            $data = ShoppingListController::postShoppingList(json_decode($request->getContent()), Auth::user());
        }

        return response()->json(['message' => $data], 200);
    }

    public function getHistory()
    {
        return response()->json(['history' => ShoppingListController::getShoppingListHistory(Auth::user())]);
    }

    /**
     * Connect to InventoryItemController to retrieve a singular item data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function postSearchItem(Request $request)
    {
        $data = null;
        if (json_decode($request->getContent())) {
            $params =  json_decode($request->getContent());
            $data = InventoryItemController::searchItem($params, Auth::user());
        }

        return response()->json(['data' => $data, 'status' => 200], 200);
    }

    /**
     * Connect to InventoryItemController to add a new singular item to the database
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function postAddNewItem(Request $request)
    {
        $response = null;
        if (json_decode($request->getContent())) {
            try {
                $response = InventoryItemController::addItem(json_decode($request->getContent()));
            } catch (\Error $e) {
                return response()->json(['errorMessage' => $e->getMessage()], 400);
            } catch (Exception $e) {
                return response()->json(['errorMessage' => $e->getMessage()], 400);
            }
        }

        return response()->json(['message' => $response], 200);
    }

    /**
     * Connect to InventoryItemController to update an item
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function putUpdateItem(Request $request)
    {
        $response = null;
        if (json_decode($request->getContent())) {
            try {
                $response = InventoryItemController::updateItem(json_decode($request->getContent()));
            } catch (\Error $e) {
                return response()->json(['errorMessage' => $e->getMessage()], 400);
            }
        }

        return response()->json(['message' => $response], 200);
    }

    /**
     * Connect to ShoppingListController to save a new list to the database
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function postNewList(Request $request)
    {
        $response = null;
        if (json_decode($request->getContent())) {
            $response = ShoppingListController::postShoppingList(json_decode($request->getContent()), Auth::user());
        }

        return response()->json(['message' => $response], 200);
    }

    /**
     * Connect to UserInventoryController to get all items in their inventory
     *
     * @return JsonResponse
     */
    public function getUserInventory()
    {
        return response()->json(['items' => UserInventoryController::getUserInventory()], 200);
    }

    /**
     * Connect to UserInventoryController to add to stock of a single item
     *
     * @param Request $request
     * @return mixed|null
     * @throws Exception
     */
    public function postAddItem(Request $request)
    {
        $response = null;
        if ($request->getContent()) {
            $response = UserInventoryController::postAddItem($request->getContent());
        }
        return $response;
    }

    /**
     * Connect to UserInventoryController to remove stock of a single item
     *
     * @param Request $request
     * @return void|null
     */
    public function postRemoveItem(Request $request)
    {
        $response = null;
        if ($request->getContent()) {
            $response = UserInventoryController::postRemoveItem($request->getContent());
        }
        return $response;
    }

    /**
     * Connect to UserInventoryController to get previously bought item
     */
    public function getPreviousItem()
    {
        return response()->json(['prevItems' => UserInventoryController::getPrevItems()], 200);
    }
}
