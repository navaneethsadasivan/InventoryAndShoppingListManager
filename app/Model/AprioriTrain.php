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
    protected $testSamples = [];

    protected $testLabels = [];

    protected $associator = null;

    protected $userId;

    public function __construct($userId)
    {
        $this->setUserId($userId);
    }

    public function getUserIdWithoutFormat()
    {
        return $this->userId;
    }

    public function getUserId()
    {
        return sprintf("%'02d", $this->userId);
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    protected function train($sup = 0.27, $conf = 0.5)
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

    public function generateList()
    {
        $inventory = new Inventory($this->getUserIdWithoutFormat());

        $items = DB::select('select * from shopping_list_items WHERE shopping_list_id like "Test%"');
        $itemSet = [];

        foreach ($items as $index => $itemData) {
            $itemSet[$itemData->shopping_list_id][] = $itemData->item_id;
        }

        foreach ($itemSet as $listId => $itemList) {
            array_push($this->testSamples, $itemList);
        }


        $confidence = $this->getConfidence(count($this->testSamples));

        $this->train();

//        return $this->testSamples;
//        return $this->associate();
//        return $this->test($this->associate());

        $generatedList = $this->buildList($this->associate());

        $newList = [];
        foreach ($generatedList as $index => $itemId) {
            $item = DB::selectOne('select * from inventory_item where id =' . $itemId);
            $newList[] = $item;
        }

        return $newList;
    }

    protected function getConfidence($arrayCount)
    {
        return $arrayCount/100;
    }

    protected function buildList($mlList, $expiredItems = null)
    {
        $data = [];
        $expired = [];
        $referenceItems = [];

        foreach ($mlList as $mlData) {
            if ($mlData['confidence'] >= 0.7 && $mlData['support'] >= 0.15) {
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

        if ($expiredItems !== null) {
            foreach ($expiredItems as $expiredItemId => $expiredItemDetails) {
                $expired[] = $expiredItemId;
            }

            foreach ($expired as $expiredId) {
                if (!in_array($expiredId, $data)) {
                    $data[] = $expiredId;
                }
            }
        }

        return $data;
    }

    public function test($associationRules)
    {
        $test = [];
        foreach ($associationRules as $rule) {
            if ($rule['antecedent'] === 49 || in_array(49, $rule['antecedent'])) {
                $test[] = $this->predict([49]);
            }
        }

        return $test;
    }
}
