<?php
    class Contact{

        private $conn;

        private $db_table = "contacts";

        public $id;
        public $name;
        public $last_name;
        public $email;
        public $address;
        public $created_at;

        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getContacts(){
            $sqlQuery = "SELECT id, name, last_name, email, address, created_at FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createContact(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        last_name = :last_name,
                        email = :email, 
                        address = :address, 
                        created_at = :created_at";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->last_name=htmlspecialchars(strip_tags($this->last_name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->address=htmlspecialchars(strip_tags($this->address));
            $this->created_at=$this->created_at;
        
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":last_name", $this->last_name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":address", $this->address);
            $stmt->bindParam(":created_at", $this->created_at);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // UPDATE
        public function getContactById(){
            $sqlQuery = "SELECT  * FROM ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->name = $dataRow['name'];
            $this->last_name = $dataRow['last_name'];
            $this->email = $dataRow['email'];
            $this->address = $dataRow['address'];
            $this->created_at = $dataRow['created_at'];
        }        

        // UPDATE
        public function updateContact(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        name = :name, 
                        last_name = :last_name, 
                        email = :email, 
                        address = :address, 
                        created_at = :created_at
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
            
            $this->id=htmlspecialchars(strip_tags($this->id));
            $this->name=htmlspecialchars(strip_tags($this->name));
            $this->last_name=htmlspecialchars(strip_tags($this->last_name));
            $this->email=htmlspecialchars(strip_tags($this->email));
            $this->address=htmlspecialchars(strip_tags($this->address));
            $this->created_at=$this->created_at;
        
            // bind data
            $stmt->bindParam(":name", $this->name);
            $stmt->bindParam(":last_name", $this->last_name);
            $stmt->bindParam(":email", $this->email);
            $stmt->bindParam(":address", $this->address);
            $stmt->bindParam(":created_at", $this->created_at);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteContact(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }

        }

    }
?>

