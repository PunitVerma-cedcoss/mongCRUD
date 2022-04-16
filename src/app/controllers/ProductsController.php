<?php

use Phalcon\Mvc\Controller;


class ProductsController extends Controller
{
    public function indexAction()
    {
        $this->view->t = $this->translator;
        $this->assets->addJs("js/main.js");
        $this->assets->addCss("css/style.css");
        $mongo = new \App\Components\MongoComponent();
        // if got post
        if ($this->request->isPost()) {
            // pass searched data into view
            $this->view->search = $mongo->query("products", ["product name" => ['$regex' => strtolower($this->request->getPost()["search"])]]);
            $this->view->query = $this->request->getPost()["search"];
        }
        // pass data into view
        $this->view->data = $mongo->read("products");
    }
    public function addAction()
    {
        $this->view->t = $this->translator;
        $this->assets->addJs("js/main.js");
        // if got post
        if ($this->request->isPost()) {
            $postData = $this->request->getPost();
            echo "<pre>";
            print_r($postData);
            $arr = $postData;
            // preprocessing the data
            $dataprepross = new \App\Components\UtilsComponent();
            $finalData = ($dataprepross->preProcessData($arr));
            //inserting into db
            $mongo = new \App\Components\MongoComponent();
            $mongo->insert("products", $finalData);
        }
    }
    public function detailsAction()
    {
        $this->view->t = $this->translator;
        $id = explode("/", $this->request->getQuery()["_url"])[3];
        if (strlen($id) == 0) {
            header("location:/products");
        }
        $mongo = new \App\Components\MongoComponent();
        $data = $mongo->query("products", [
            '_id' => new MongoDB\BSON\ObjectID($id)
        ]);
        // pass data into view
        $this->view->data = $data->toArray();
    }
    public function editAction()
    {
        $this->view->t = $this->translator;
        $this->assets->addJs("js/main.js");
        $id = explode("/", $this->request->getQuery()["_url"])[3];
        if (strlen($id) == 0) {
            header("location:/products");
        }
        $mongo = new \App\Components\MongoComponent();
        $data = $mongo->query("products", [
            '_id' => new MongoDB\BSON\ObjectID($id)
        ]);
        // pass data into view
        $this->view->data = $data->toArray();
        $this->view->id = $id;
        //if got post
        if ($this->request->isPost()) {
            $arr = $this->request->getPost();
            $util = new \App\Components\UtilsComponent();
            $preproArr = $util->preProcessData($arr);
            // now update the data
            $mongo->updateDoc(
                "products",
                $id,
                $preproArr
            );
        }
    }
    public function deleteAction()
    {
        $id = explode("/", $this->request->getQuery()["_url"])[3];
        if (strlen($id) == 0) {
            header("location:/products");
        }
        $mongo = new \App\Components\MongoComponent();
        $data = $mongo->delete("products", $id);
        header("location:/products");
    }
}
