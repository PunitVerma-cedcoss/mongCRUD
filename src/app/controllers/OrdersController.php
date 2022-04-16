<?php

use Phalcon\Mvc\Controller;


class OrdersController extends Controller
{
    public function indexAction()
    {
        // get products from db
        $this->assets->addJs("js/orders.js");
        // get products from db
        $mongo = new \App\Components\MongoComponent();
        $data = $mongo->read(
            "orders"
        );
        // pass into view
        $this->view->data = $data;
    }
    public function addAction()
    {
        $this->assets->addJs("js/orders.js");
        // get products from db
        $mongo = new \App\Components\MongoComponent();
        $data = $mongo->read(
            "products"
        );
        // pass data into view
        $this->view->data = $data->toArray();
        // processing list
        $final = [];
        $var = $mongo->queryProject("products", [], ['projection' => ['variations' => 1]])->toArray();
        foreach (json_decode(json_encode($var), true) as $a) {
            foreach ($a['variations'] as $varient) {
                $tmp = [];
                foreach ($varient["variant"] as $vk => $vv) {
                    $tmp[] = [$vk => $vv];
                }
                $final[$a["_id"]['$oid']][] = $tmp;
                print_r("---------");
            }
        }
        $this->view->list = ($final);

        // if got post
        if ($this->request->isPost()) {
            echo "<pre>";
            print_r($this->request->getPost());
            $postData = $this->request->getPost();
            $mongo = new \App\Components\MongoComponent();
            $data = $mongo->insert("orders", [
                'customer name' => $postData["name"],
                'quantity' => $postData["Quantity"],
                'productId' => new MongoDB\BSON\ObjectID($postData["product"]),
                'varient' => $postData["varient"],
                'status' => "paid",
                'order date' => new \MongoDB\BSON\UTCDateTime(new \DateTime()),
            ]);
            die;
        }
    }
}
