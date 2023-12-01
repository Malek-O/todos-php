<?php

class Todo {
    private $id;
    private $task;
    private $createdAt;
    private $dbConnection;
    private $done = false;
    private $dbTable = "tasks";

    public function __construct($dbConnection){
        $this->dbConnection = $dbConnection;
    }

    public function create()
    {
        $query = "INSERT INTO " . $this->dbTable . "(task, createdAt, done) VALUES(:taskName, now(),0);";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":taskName", $this->task);
        if ($stmt->execute()) {
            return true;
        }
        // print an error message
        printf("Error: %s", $stmt->error);
        return false;
    }

     public function readOne()
    {
        $query = "SELECT * FROM " . $this->dbTable . " WHERE id=:id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":id", $this->id);
        if ($stmt->execute() && $stmt->rowCount() == 1) {
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            $this->id = $result->id;
            $this->task = $result->task;
            $this->createdAt = $result->createdAt;
            $this->done = $result->done;
            return true;
        }
        return false;
    }

    public function readAll()
    {
        $query = "SELECT * FROM " . $this->dbTable . " WHERE done = false";
        $stmt = $this->dbConnection->prepare($query);
        if ($stmt->execute() && $stmt->rowCount() > 0) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return [];
    }

    public function update()
    {
        $query = "UPDATE " . $this->dbTable . " SET done=:done WHERE id=:id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":done", $this->done);
        $stmt->bindParam(":id", $this->id);
        if ($stmt->execute() && $stmt->rowCount() ==1) {
            return true;
        }
        return false;
    }

    public function delete()
    {
        $query = "DELETE FROM " . $this->dbTable . " WHERE id=:id";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->bindParam(":id", $this->id);
        if ($stmt->execute() && $stmt->rowCount() ==1) {
            return true;
        }
        return false;
    }



    public function getId (){
        return $this->id;
    }

    public function getTask (){
        return $this->task;
    }

      public function getCreatedAt (){
        return $this->createdAt;
    }

        public function getDone (){
        return $this->done;
    }

    public function setId ($id){
     return $this->id = $id;
    }

     public function setTask ($task){
     return $this->task = $task;
    }
     public function setCreatedAt ($createdAt){
     return $this->createdAt = $createdAt;
    }
    public function setDone ($done){
     return $this->done = $done;
    }
}