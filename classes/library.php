<?php 

require_once "database.php";

class Library {
    public $id = "";
    public $title = "";
    public $author = "";
    public $genre = "";
    public $year = "";

    protected $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function addBook(){
        $sql = "INSERT INTO book (title, author, genre, year) VALUE (:title, :author, :genre, :year)";

        $query = $this->db->connect()->prepare($sql);
        $query->bindParam(":title", $this->title);
        $query->bindParam(":author", $this->author);
        $query->bindParam(":genre", $this->genre);
        $query->bindParam(":year", $this->year);

        return $query->execute();
    }

    public function viewBookFilter($search, $filter){
    $sql = "SELECT * FROM book WHERE 1=1";
    $params = [];

    if(!empty($search)){
        $sql .= " AND (title LIKE :search OR author LIKE :search)";
        $params[":search"] = "%" . $search . "%";
    }
    if(!empty($filter)){
        $sql .= " AND genre = :filter";
        $params[":filter"] = $filter;
    }

    $query = $this->db->connect()->prepare($sql);
    $query -> execute($params);
    return $query -> fetchAll();
}


    public function viewBook(){
        $sql = "SELECT * FROM book ORDER BY title ASC";
        $query = $this->db->connect()->prepare($sql);

        if($query->execute()){
            return $query->fetchAll();
        }else{
            return null;
        }
    }
}