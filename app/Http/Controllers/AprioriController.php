<?php
namespace App\Http\Controllers;

use App\Model\AprioriTrain;

/**
 * Class AprioriController
 * @package App\Http\Controllers
 */
class AprioriController extends Controller
{
    public static function show()
    {
        $apriori = new AprioriTrain();
        return [
            'Associate' => $apriori->associate(),
            'Frequent' => $apriori->frequentItems(),
            'Predict' => $apriori->predict()
        ];
    }
}
