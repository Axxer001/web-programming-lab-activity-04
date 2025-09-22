<?php

require_once "../classes/library.php";
$bookObj = new Library();

$book = ["title"=>"", "author"=>"", "genre"=>"", "year"=>""];
$error = ["title"=>"", "author"=>"", "genre"=>"", "year"=>""];

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $book["title"] = trim(htmlspecialchars($_POST["title"]));
    $book["author"] = trim(htmlspecialchars($_POST["author"]));
    $book["genre"] = trim(htmlspecialchars($_POST["genre"]));
    $book["year"] = trim(htmlspecialchars($_POST["year"]));

    if(empty($book["title"])){
        $error["title"] = "Book requires a Title";
    }

    if(empty($book["author"])){
        $error["author"] = "Who wrote this Book???";
    }

    if(empty($book["genre"])){
        $error["genre"] = "Book requires a Genre";
    }

    if(empty($book["year"])){
        $error["year"] = "Book was published when???";
    } elseif(!is_numeric($book["year"]) || $book["year"] > 2025) {
        $error["year"] = "Invalid Book year";
    }

    if(empty(array_filter($error))){
        $bookObj->title = $book["title"];
        $bookObj->author = $book["author"];
        $bookObj->genre = $book["genre"];
        $bookObj->year = $book["year"];

        if($bookObj->addBook()){
            header("Location: viewBook.php");
        }else{
            echo "failed";
        }
    } else {
        echo "failed"; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <style>
        label { display : block; }
        span, .error { color: red; margin: 0; }
    </style>
</head>
<body>
    <h1>Add Book</h1>
    <form action="" method="post">
        <label for="">Field with <span>*</span> is required</label>
        <label for="title">Book Title <span>*</span></label>
        <input type="text" name="title" id="title" value="<?= $book["title"]?>">
        <p class="error"><?= $error["title"]?></p>

        <label for="author">Author Name <span>*</span></label>
        <input type="text" name="author" id="author" value="<?= $book["author"]?>">
        <p class="error"><?= $error["author"]?></p>

        <label for="genre">Genre <span>*</span></label>
        <select name="genre" id="genre">
            <option value="">--Select Genre--</option>
            <option value="history" <?= ($book["genre"] == "history")? "selected":""?>>History</option>
            <option value="science" <?= ($book["genre"] == "science")? "selected":""?>>Science</option>
            <option value="fiction" <?= ($book["genre"] == "fiction")? "selected":""?>>Fiction</option>
        </select>
        <p class="error"><?= $error["genre"]?></p>

        <label for="year">Publication Year <span>*</span></label>
        <input type="number" name="year" id="year" value="<?= $book["year"]?>">
        <p class="error"><?= $error["year"]?></p>

        <break>

        <input type="submit" value="Save Book">
    </form>
</body>
</html>