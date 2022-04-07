<?php
    class ContactDetail{

        private $conn;

        private $db_table = "contact_detail";

        public $id;
        public $contact_id;
        public $phone;
        public $created_at;

        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getContactDetails(){
            $sqlQuery = "SELECT id, contact_id, phone, created_at FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createContactDetail(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        contact_id = :contact_id,
                        phone = :phone, 
                        created_at = :created_at";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->contact_id=$this->contact_id;
            $this->phone=htmlspecialchars(strip_tags($this->phone));
            $this->created_at=$this->created_at;
        
            $stmt->bindParam(":contact_id", $this->contact_id);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":created_at", $this->created_at);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // UPDATE
        public function getContactDetailById(){
            $sqlQuery = "SELECT  * FROM ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $this->contact_id = $dataRow['contact_id'];
            $this->phone = $dataRow['phone'];
            $this->created_at = $dataRow['created_at'];
        }        

        // UPDATE
        public function updateContactDetail(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                    contact_id = :contact_id, 
                    phone = :phone, 
                    created_at = :created_at
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
            
            $this->id=$this->id;
            $this->contact_id=$this->contact_id;
            $this->phone=htmlspecialchars(strip_tags($this->phone));
            $this->created_at=$this->created_at;
        
            // bind data
            $stmt->bindParam(":id", $this->id);
            $stmt->bindParam(":contact_id", $this->contact_id);
            $stmt->bindParam(":phone", $this->phone);
            $stmt->bindParam(":created_at", $this->created_at);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteContactDetail(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>

