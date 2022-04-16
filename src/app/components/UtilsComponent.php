<?php

namespace App\Components;

use Phalcon\Di\Injectable;

/**
 * Helper class for useful componenets
 */
class UtilsComponent extends Injectable
{
    /**
     * pre-process the given data
     *
     * @param [array] $data
     * @return array
     */
    public function preProcessData($arr)
    {
        $str = implode(" ", array_keys($arr));
        $pattern = "/variationSubField/i";
        $total_var = preg_match_all($pattern, $str);
        $list = [];
        $variations = [];
        $final = [];
        // appending static fields
        $final["product name"] = $arr["name"];
        $final["category name"] = $arr["category_name"];
        $final["product price"] = $arr["Price"];
        $final["product stock"] = $arr["Stock"];
        // processing variations
        for ($i = 0; $i < $total_var; $i++) {
            foreach ($arr["variationSubField" . ($i + 1)] as $ele) {
                array_push($list, $ele);
            }
            foreach ($arr["variationSubValue" . ($i + 1)] as $ele) {
                array_push($list, $ele);
            }
            $tmp = [];
            for ($j = 0; $j < count($list) / 2; $j++) {
                $tmp[$list[$j]] = $list[$j + (count($list) / 2)];
            }
            $variations[] = ["variant" => $tmp, "price" => $arr["variationPrice" . ($i + 1)][0]];
            $list = [];
        }
        $final["variations"] = $variations;
        //processing meta fields
        $tmp2 = [];
        $toal = preg_match_all("/metaField/", implode(" ", array_keys($arr)));
        for ($i = 0; $i < $toal; $i++) {
            $tmp2[$arr["metaField" . ($i + 1)]] = $arr["metaValue" . ($i + 1)];
        }
        $final["metas"] = $tmp2;
        return $final;
    }
}
