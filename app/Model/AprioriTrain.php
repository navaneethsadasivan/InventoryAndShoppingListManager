<?php
namespace App\Model;
use Illuminate\Support\Facades\DB;
use Phpml\Association\Apriori;

/**
 * Class AprioriTrain
 * @package App\Model
 */
class AprioriTrain
{
//    protected $testSamples = [
//        ['Milk', 'Bread', 'Eggs', 'Apples', 'Rice'],
//        ['Milk', 'Bread', 'Flour', 'Tortilla', 'Chocolates'],
//        ['Milk', 'Tortilla', 'Chocolates', 'Apples', 'Eggs'],
//        ['Milk', 'Bread', 'Rice', 'Mushrooms', 'Rice'],
//        ['Tortilla', 'Eggs', 'Apples', 'Chocolates', 'Flour']
//    ];

    protected $testSamples = [];

    protected $testLabels = [];

    protected $associator = null;

    protected function train($sup = 0.5, $conf = 0.85)
    {
        $this->associator = new Apriori($support = $sup, $confidence = $conf);
        $this->associator->train($this->testSamples, $this->testLabels);
    }

    public function frequentItems()
    {
        return $this->associator->apriori();
    }

    public function associate()
    {
        return $this->associator->getRules();
    }

    public function predict($items)
    {
        return $this->associator->predict($items);
    }

    public function generateList($expiringItems)
    {
        $shoppingListModel = new ShoppingList();

        $items = DB::select('select * from shopping_list_items WHERE shopping_list_id like "U02%"');
        $itemSet = [];

        foreach ($items as $index => $itemData) {
            $itemSet[$itemData->shopping_list_id][] = $itemData->item_id;
        }

        foreach ($itemSet as $listId => $itemList) {
            array_push($this->testSamples, $itemList);
        }

        $confidence = $this->getConfidence(count($this->testSamples));

        $this->train();

        $finalList = $shoppingListModel->getItemsForApriori();

        $generatedList = $this->buildList($this->associate(), $finalList);

        $newList = [];
        foreach ($generatedList as $index => $itemId) {
            $item = DB::selectOne('select * from inventory_item where id =' . $itemId);
//            array_push($newList, $item->name);
            $newList[$itemId] = $item->name;
        }

        return $newList;
    }

    protected function getConfidence($arrayCount)
    {
        return $arrayCount/100;
    }

    protected function buildList($mlList, $frequentItems)
    {
        $data = [];
        $referenceItems = [];

        foreach ($frequentItems as $item) {
            foreach ($mlList as $mlData) {
                if (in_array($item, $mlData['antecedent'])) {
                    if ($mlData['confidence'] >= 0.8 && $mlData['support'] >= 0.4) {
                        foreach ($mlData['antecedent'] as $listItemA) {
                            if (!in_array($listItemA, $referenceItems)) {
                                $referenceItems[] = $listItemA;
                                $data[] = $listItemA;
                            } else {
                                continue;
                            }
                        }
                        foreach ($mlData['consequent'] as $listItemB) {
                            if (!in_array($listItemB, $referenceItems)) {
                                $referenceItems[] = $listItemB;
                                $data[] = $listItemB;
                            } else {
                                continue;
                            }
                        }
                    }
                }
            }
        }

        return $data;
    }
}
