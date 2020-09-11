<?php

namespace App\Http\Controllers;
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
        $user = null;
        $userDetails = Auth::user();
        $test = json_decode($request->getContent());

        if ($test) {
            if (isset($test[0]->user)) {
                $user = $test[0]->user;
            } else if ($userDetails) {
                $user = $userDetails['id'];
            } else {
                return response()->json(['message' => 'User id is not declared'], 400);
            }
        }

        if (json_decode($request->getContent())) {
            $data = ShoppingListController::postShoppingList($test[0]->ListItems, $user);
        }

        return response()->json(['message' => $data], 200);
    }

    /**
     * Connect to ShoppingListController and retrieve history of shopping lists
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getHistory(Request $request)
    {
        $user = null;
        $userDetails = Auth::user();
        $test = json_decode($request->getContent());

        if (is_null($test) && is_null($userDetails)) {
            return response()->json(['message' => 'User id is not declared'], 400);
        } else {
            if (isset($test[0]->user)) {
                $user = $test[0]->user;
            } else if ($userDetails['id']) {
                $user = $userDetails['id'];
            }
        }

        return response()->json(['history' => ShoppingListController::getShoppingListHistory($user)]);
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
        $user = null;
        $userDetails = Auth::user();
        $test = json_decode($request->getContent());

        if ($test) {
            if (isset($test[0]->user)) {
                $user = $test[0]->user;
            } else if ($userDetails) {
                $user = $userDetails['id'];
            } else {
                return response()->json(['message' => 'User id is not declared'], 400);
            }
        }

        if (json_decode($request->getContent())) {
            $params =  json_decode($request->getContent());
            $data = InventoryItemController::searchItem($params, $user);
        }

        return response()->json(['data' => $data], 200);
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
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserInventory(Request $request)
    {
        $user = null;
        $userDetails = Auth::user();
        $test = json_decode($request->getContent());

        if (is_null($test) && is_null($userDetails)) {
            return response()->json(['message' => 'User Id is not declared'], 400);
        } else {
            if (isset($test[0]->user)) {
                $user = $test[0]->user;
            } elseif ($userDetails){
                $user = $userDetails['id'];
            }
        }

        return response()->json(['items' => UserInventoryController::getUserInventory($user)], 200);
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
        $user = null;
        $itemId = null;
        $test = json_decode($request->getContent());
        if ($test) {
            if (isset($test[0]->user)) {
                $user = $test[0]->user;
            }
            $itemId = $test[0]->itemId;
        }

        if ($request->getContent()) {
            $response = UserInventoryController::postAddItem($itemId, $user);
        }
        return $response;
    }

    /**
     * Connect to UserInventoryController to remove stock of a single item
     *
     * @param Request $request
     * @return array
     * @throws Exception
     */
    public function postRemoveItem(Request $request)
    {
        $response = null;
        $user = null;
        $itemId = null;
        $test = json_decode($request->getContent());

        if ($test) {
            if (isset($test[0]->user)) {
                $user = $test[0]->user;
            }
            $itemId = $test[0]->itemId;
        }

        if ($request->getContent()) {
            $response = UserInventoryController::postRemoveItem($itemId, $user);
        }
        return $response;
    }

    /**
     * Connect to UserInventoryController to get previously bought item
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getPreviousItem(Request $request)
    {
        $user = null;
        $test = json_decode($request->getContent());

        if ($test) {
            if ($test[0]->user) {
                $user = $test[0]->user;
            }
        }

        return response()->json(['prevItems' => UserInventoryController::getPrevItems($user)], 200);
    }

    /**
     * @return JsonResponse
     */
    public function getExpiringItems()
    {
        return response()->json(['expiringItems' => UserInventoryController::getExpiringItems()], 200);
    }
}
