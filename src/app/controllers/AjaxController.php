<?php

use Phalcon\Mvc\Controller;


class AjaxController extends Controller
{
    public function getByStatusAction()
    {
        if ($this->request->isAjax()) {
            $postData = $this->request->getPost();
            // get data
            $mongo = new \App\Components\MongoComponent();
            $json = $mongo->query("orders", ["status" => $postData["status"]])->toArray();
            print_r(json_encode($json));
            die;
        }
    }
    public function getTodayAction()
    {
        if ($this->request->isAjax()) {
            // $postData = $this->request->getPost();
            // get data
            $mongo = new \App\Components\MongoComponent();
            $data = $mongo->query(
                "orders",
                ['order date' => ['$gt' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime("-1 day"))))]]
            );
            print_r(json_encode($data->toArray()));
            die;
        }
    }
    public function getThisWeekAction()
    {
        if ($this->request->isAjax()) {
            // $postData = $this->request->getPost();
            // get data
            $mongo = new \App\Components\MongoComponent();
            $data = $mongo->query(
                "orders",
                ['order date' => ['$gt' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime("this week")))), '$lt' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime("this week +6 day"))))]]
            );
            print_r(json_encode($data->toArray()));
            die;
        }
    }
    public function getThisMonthAction()
    {
        if ($this->request->isAjax()) {
            // $postData = $this->request->getPost();
            // get data
            $mongo = new \App\Components\MongoComponent();
            $data = $mongo->query(
                "orders",
                ['order date' => ['$gt' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime("first day of this month")))), '$lt' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime("last day of this month"))))]]
            );
            print_r(json_encode($data->toArray()));
            die;
        }
    }
    public function getCustomAction()
    {
        if ($this->request->isAjax()) {
            $postData = $this->request->getPost();
            // get data
            $mongo = new \App\Components\MongoComponent();
            $data = $mongo->query(
                "orders",
                ['order date' => ['$gt' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime($postData["from"])))), '$lt' => new MongoDB\BSON\UTCDateTime(new \DateTimeImmutable(date("Y-m-d H:i:s", strtotime($postData["to"]))))]]
            );
            print_r(json_encode($data->toArray()));
            die;
        }
    }
    public function changeStatusAction()
    {
        if ($this->request->isAjax()) {
            $postData = $this->request->getPost();
            // update status data
            $mongo = new \App\Components\MongoComponent();
            $data = $mongo->update(
                "orders",
                [
                    '_id' => new MongoDB\BSON\ObjectID($postData["id"])
                ],
                [
                    '$set' => ['status' => $postData['status']]
                ]
            );
            print_r(json_encode($data));
            die;
        }
    }
}
