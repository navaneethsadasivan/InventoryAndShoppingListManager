<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class AjaxController
 * @package App\Http\Controllers
 */
class AjaxController extends Controller
{
    public function getInventoryItems() {
        return response()->json(['items' => InventoryItemController::show()], 200);
    }

    public function getShoppingList() {
        return response()->json(['list' => ShoppingListController::show()], 200);
    }

    public function getApriori() {
        return response()->json(['apriori' => AprioriController::show()], 200);
    }

    public function postHistory(Request $request) {
        $data = null;
        if (json_decode($request->getContent())) {
            $data = ShoppingListController::getHistoryData(json_decode($request->getContent()), Auth::user());
        }

        return response()->json(['message' => $data], 200);
    }

    public function postSearchItem(Request $request) {
        $data = null;
        if (json_decode($request->getContent())) {
            $data = InventoryItemController::searchItem(json_decode($request->getContent()));
        }

        return response()->json(['data' => $data, 'status' => 200], 200);
    }

    public function postAddNewItem(Request $request) {
        $response = null;
        if (json_decode($request->getContent())) {
            $response = InventoryItemController::addItem(json_decode($request->getContent()));
        }

        return response()->json(['message' => $response], 200);
    }

    public function postNewList(Request $request) {
        $response = null;
        if (json_decode($request->getContent())) {
            $response = ShoppingListController::getHistoryData(json_decode($request->getContent()), Auth::user());
        }

        return response()->json(['message' => $response], 200);
    }
}
