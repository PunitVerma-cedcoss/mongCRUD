<?php

namespace App\Components;

use Phalcon\Di\Injectable;

/**
 * Helper class for MongoDb CRUD
 */
class MongoComponent extends Injectable
{
    /**
     * inserts any given data into given collection name
     *
     * @param [string] $collection
     * @param [array] $data
     * @return void
     */
    public function insert($collection, $data)
    {
        $resp = $this->mongo->$collection->insertOne(
            $data
        );
        return $resp->getInsertedId();
    }
    /**
     * returns all data of given collection name
     *
     * @param [string] $collection
     * @return array
     */
    public function read($collection)
    {
        $resp = $this->mongo->$collection->find();
        return $resp;
    }
    /**
     * returns the response of the given query
     *
     * @param [type] $collection
     * @param [type] $query
     * @return array
     */
    public function query($collection, $query)
    {
        $resp = $this->mongo->$collection->find($query);
        return $resp;
    }
    public function queryProject($collection, $query, $projection)
    {
        $resp = $this->mongo->$collection->find($query, $projection);
        return $resp;
    }
    public function updateDoc($collection, $id, $doc)
    {
        $resp = $this->mongo->$collection->replaceOne(['_id' => new \MongoDB\BSON\ObjectID($id)], $doc);
        return $resp;
    }
    public function delete($collection, $id)
    {
        $resp = $this->mongo->$collection->deleteOne(['_id' => new \MongoDB\BSON\ObjectID($id)]);
        return $resp;
    }
    public function update($collection, $query, $data)
    {
        $resp = $this->mongo->$collection->updateOne($query, $data);
        return $resp;
    }
}
