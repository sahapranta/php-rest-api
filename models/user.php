<?php 
class User{
    private $conn;
    private $table_name = "users";

    public $id;
    public $username;
    public $password;
    public $created_at;

    public function __construct($db){
        $this->conn = $db;
    }

    public function read(){
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();    
        return $stmt;
    }
    public function duplicate($str){
        $str = htmlspecialchars(strip_tags($str));
        $query = "SELECT id FROM " . $this->table_name . " WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(array(':username' => $str));
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function create(){
        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->password = htmlspecialchars(strip_tags($this->password));

        if (!$this->duplicate($this->username)) {
            $query = "INSERT INTO " . $this->table_name  . " SET username=:username, password=:password";
            $stmt = $this->conn->prepare($query);
                    
            // bind values
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":password", $this->password);
            // execute query
            try{
                if($stmt->execute()){
                    return true;
                }
            } catch(PDOException $e) {
                return $e->getMessage();
            }
        } else {
            return "Username already exist";
        }
    }

    public function readOne(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->username = $row['username'];
        $this->password = $row['password'];
        $this->created_at = $row['created_at'];
    }

    protected function updateSingle($data, $field){
        $query = "UPDATE " . $this->table_name . " SET " . $field . " = :data WHERE id = :id ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function update($both){
        if($both === 2 ){
            if($this->updateSingle($this->username, 'username') && $this->updateSingle($this->password, 'password')){
                return true;
            }
        }
        if($both === 1){
            if (isset($this->username)) {
                return $this->updateSingle($this->username, 'username') ? true : false;                 
            }
            if (isset($this->password)) {
                return $this->updateSingle($this->password, 'password') ? true : false;                 
            }        
        }
        return false;
    }

    public function delete(){
        $query = "DELETE FROM " . $this->table_name . " WHERE `id` = :id";
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        if($stmt->execute()){
            return $stmt->rowCount();
        }
        return false;
    }

    public function search($keywords){
        $query = "SELECT * FROM " . $this->table_name . " WHERE username LIKE ? OR id LIKE ? ORDER BY created_at DESC";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // sanitize
        $keywords=htmlspecialchars(strip_tags($keywords));
        $keywords = "%{$keywords}%";
        $stmt->bindParam(1, $keywords);
        $stmt->bindParam(2, $keywords);
        // execute query
        $stmt->execute();
        return $stmt;
    }

    public function readPaging($from_record_num, $records_per_page){
        $query = "SELECT * FROM " . $this->table_name . " LIMIT ?, ?";
        // prepare query statement
        $stmt = $this->conn->prepare( $query );

        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt;
    }

    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . " ";
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $row['total_rows'];
    }
}

?>