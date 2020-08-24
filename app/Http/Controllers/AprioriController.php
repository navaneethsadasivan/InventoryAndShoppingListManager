<?php
namespace App\Http\Controllers;

use App\Model\AprioriTrain;
use Illuminate\Support\Facades\Auth;

/**
 * Class AprioriController
 * @package App\Http\Controllers
 */
class AprioriController extends Controller
{
    public static function show()
    {
        $user = Auth::user();
        $apriori = new AprioriTrain($user['id']);
        return [
            'Associate' => $apriori->associate(),
            'Frequent' => $apriori->frequentItems(),
            'Predict' => $apriori->predict()
        ];
    }
}
