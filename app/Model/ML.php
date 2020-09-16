<?php
namespace App\Model;
use Illuminate\Support\Facades\DB;
use Phpml\Association\Apriori;

/**
 * Class ML
 * @package App\Model
 */
class ML
{
    /**
     * @var array
     */
    protected $samples = [];

    /**
     * @var array
     */
    protected $labels = [];

    /**
     * @var null
     */
    protected $associator = null;

    /**
     * @var int
     */
    protected $userId;

    public function __construct($userId)
    {
        $this->setUserId($userId);
    }

    /**
     * @return int
     */
    public function getUserIdWithoutFormat()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return sprintf("%'02d", $this->userId);
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

    /**
     * @param float $sup
     * @param float $conf
     */
    protected function train($sup = 0.1, $conf = 0.5)
    {
        $this->associator = new Apriori($support = $sup, $confidence = $conf);
        $this->associator->train($this->samples, $this->labels);
    }

    /**
     * @return array
     */
    public function frequentItems()
    {
        return $this->associator->apriori();
    }

    /**
     * @return array
     */
    public function associate()
    {
        return $this->associator->getRules();
    }

    /**
     * @param array $items
     * @return array
     */
    public function predict($items)
    {
        return $this->associator->predict($items);
    }

    /**
     * @return array
     */
    public function generateList()
    {
        $inventory = new Inventory($this->getUserIdWithoutFormat());

        $items = DB::select('select * from shopping_list_items WHERE shopping_list_id like "Test%"');
        $itemSet = [];

        foreach ($items as $index => $itemData) {
            $itemSet[$itemData->shopping_list_id][] = $itemData->item_id;
        }

        foreach ($itemSet as $listId => $itemList) {
            array_push($this->samples, $itemList);
        }

        $this->train();
        $generatedList = $this->buildList($this->associate());
        $newList = [];
        foreach ($generatedList as $index => $itemId) {
            $item = DB::selectOne('select * from inventory_item where id =' . $itemId);
            $newList[] = $item;
        }

        return $newList;
    }

    /**
     * @param array $mlList
     * @param null $expiredItems
     * @return array
     */
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
}
