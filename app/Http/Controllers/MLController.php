<?php
namespace App\Http\Controllers;

use App\Model\ML;
use Illuminate\Support\Facades\Auth;

/**
 * Class MLController
 * @package App\Http\Controllers
 */
class MLController extends Controller
{
    /**
     * @return array
     */
    public static function show()
    {
        $user = Auth::user();
        $apriori = new ML($user['id']);
        return [
            'Associate' => $apriori->associate(),
            'Frequent' => $apriori->frequentItems(),
            'Predict' => $apriori->predict()
        ];
    }
}
