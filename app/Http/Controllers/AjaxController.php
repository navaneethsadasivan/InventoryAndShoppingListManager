<?php

namespace App\Http\Controllers;
use Exception;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class AjaxController
 * @package App\Http\Controllers
 */
class AjaxController extends Controller
{
    /**
     * @var null/int
     */
    protected $user = null;

    /**
     * @return null
     */
    protected function getUser()
    {
        return $this->user;
    }

    /**
     * @param int $user
     * @return $this
     */
    protected function setUser(int $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @param Request $request
     * @return string[]
     */
    protected function authorizeUser(Request $request)
    {
        $user = null;
        if (Auth::user()) {
            $user = Auth::user();
            $this->setUser($user['id']);
            return null;
        } else if ($request->headers->get('Api-Token')) {
            $user = DB::selectOne('select * from users where api_token = "' . $request->headers->get('Api-Token') . '"');
            if ($user) {
                $this->setUser($user->id);
                return null;
            } else {
                return [
                    'Message' => 'User API token invalid'
                ];
            }
        }
        return [
            'Message' => 'No API token defined',
        ];
    }

    /**
     * Connect InventoryItemController to get all items in the database
     *
     * @return JsonResponse
     */
    public function getInventoryItems()
    {
        return response()->json(InventoryItemController::show(), 200);
    }

    /**
     * Connect ShoppingListController to generate a new list
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getShoppingList(Request $request)
    {
        $errorMessage = $this->authorizeUser($request);

        if ($errorMessage) {
            return response()->json($errorMessage, 200);
        }
        return response()->json(['list' => ShoppingListController::show($this->getUser())], 200);
    }

    /**
     * Connect MLController to get all apriori association rules after training
     *
     * @return JsonResponse
     */
    public function getApriori()
    {
        return response()->json(['apriori' => MLController::show()], 200);
    }

    /**
     * Connect to ShoppingLIstController to save the user list history
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function postShoppingList(Request $request)
    {
        $response = null;
        $errorMessage = $this->authorizeUser($request);

        if ($errorMessage) {
            $response = response()->json($errorMessage, 200);
        } else {
            $responseBody = json_decode($request->getContent());
            if (isset($responseBody[0]->listItems)) {
                $response = ShoppingListController::postShoppingList($responseBody[0]->listItems, $this->getUser());
            }
        }

        return $response;
    }

    /**
     * Connect to ShoppingListController and retrieve history of shopping lists
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getHistory(Request $request)
    {
        $errorMessage = $this->authorizeUser($request);

        if ($errorMessage) {
            return response()->json($errorMessage, 200);
        }

        return response()->json(['history' => ShoppingListController::getShoppingListHistory($this->getUser())]);
    }

    /**
     * Connect to InventoryItemController to retrieve matching item data
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function postSearchItem(Request $request)
    {
        $data = null;
        $errorMessage = $this->authorizeUser($request);

        if ($errorMessage) {
            $response = response()->json($errorMessage, 200);
        } else {
            $requestBody = json_decode($request->getContent());
            if (isset($requestBody[0]->itemName)) {
                $params =  json_decode($request->getContent());
                $response = InventoryItemController::searchItem($params, $this->getUser());
            } else {
                $response = response()->json(['Message' => 'No item declared'], 200);
            }
        }

        return $response;
    }

    /**
     * Connect to InventoryItemController to add a new singular item to the database
     *
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public function postAddNewItem(Request $request)
    {
        $response = null;
        $requestBody = json_decode($request->getContent());
        if (isset($requestBody[0]->name)) {
            try {
                $response = InventoryItemController::addItem($requestBody[0]);
            } catch (\TypeError $te) {
                $response = response()->json(['Message' => $te->getMessage()]);
            } catch (Exception $e) {
                $response = response()->json(['Message' => $e->getMessage()]);
            }
        } else {
            $response = response()->json(['Message' => 'No name given']);
        }

        return $response;
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
        $requestBody = json_decode($request->getContent());
        if (isset($requestBody[0]->id)) {
            try {
                $response = InventoryItemController::updateItem($requestBody[0]);
            } catch (\TypeError $te) {
                $response = response()->json(['Message' => $te->getMessage()]);
            } catch (Exception $e) {
                $response = response()->json(['Message' => $e->getMessage()]);
            }
        } else {
            $response = response()->json(['Message' => 'Item id for updating not provided']);
        }

        return $response;
    }

    /**
     * Connect to InventoryItemController to delete an item
     *
     * @param Request $request
     * @return array|string|null
     */
    public function deleteItem(Request $request)
    {
        $response = null;
        $requestBody = json_decode($request->getContent());
        if (isset($requestBody[0]->id)) {
            $response = InventoryItemController::deleteItem($requestBody[0]);
        } else {
            $response = response()->json(['Message' => 'Item id to be deleted not provided']);
        }

        return $response;
    }

    /**
     * Connect to UserInventoryController to get all items in their inventory
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getUserInventory(Request $request)
    {
        $errorMessage = $this->authorizeUser($request);
        if ($errorMessage) {
            return response()->json($errorMessage, 200);
        }
        return response()->json(['items' => UserInventoryController::getUserInventory($this->getUser())], 200);
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
        $errorMessage = $this->authorizeUser($request);

        if ($errorMessage) {
            $response = response()->json($errorMessage, 200);
        } else {
            $requestBody = json_decode($request->getContent());
            if (isset($requestBody[0]->itemId)) {
                $itemId = $requestBody[0]->itemId;
                $response = UserInventoryController::postAddItem($itemId, $this->getUser());
            } else {
                $response = response()->json(['Message' => 'No item declared'], 200);
            }
        }

        return $response;
    }

    /**
     * Connect to UserInventoryController to remove stock of a single item
     *
     * @param Request $request
     * @return array|JsonResponse
     * @throws Exception
     */
    public function postRemoveItem(Request $request)
    {
        $response = null;
        $itemId = null;
        $errorMessage = $this->authorizeUser($request);

        if ($errorMessage) {
            $response = response()->json($errorMessage, 200);
        } else {
            $requestBody = json_decode($request->getContent());
            if (isset($requestBody[0]->itemId)) {
                $itemId = $requestBody[0]->itemId;
                $response = UserInventoryController::postRemoveItem($itemId, $this->getUser());
            } else {
                $response = response()->json(['Message' => 'No item declared'], 200);
            }
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
        $errorMessage = $this->authorizeUser($request);
        if ($errorMessage) {
            return response()->json($errorMessage, 200);
        }
        return response()->json(['prevItems' => UserInventoryController::getPrevItems($this->getUser())], 200);
    }

    /**
     * Connect to UserInventoryController to get the expired items
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getExpiringItems(Request $request)
    {
        $errorMessage = $this->authorizeUser($request);

        if ($errorMessage) {
            return response()->json($errorMessage, 200);
        }
        return response()->json(['expiringItems' => UserInventoryController::getExpiringItems($this->getUser())], 200);
    }
}
