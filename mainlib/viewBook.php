<?php

require_once "../classes/library.php";
$bookObj = new Library();

$search = "";
$filter ="";
$books = [];

if($_SERVER["REQUEST_METHOD"] == "GET"){
    $search = isset($_GET["search"]) ? trim($_GET["search"]) : "";
    $filter = isset($_GET["filter"]) ? $_GET["filter"] : "";
    $books = $bookObj->viewBookFilter($search, $filter);
} else {
    $books = $bookObj->viewBook();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Book</title>
</head>
<body>
    <h1>List of Products</h1>
    <button><a href="addBook.php">Add another Book</a></button>
    <form action="" method="get">
        <label for="">Search:</label>
        <input type="search" name="search" id="search" value="<?= htmlspecialchars($search) ?>">
        <select name="filter" id="filter">
            <option value="" <?= ($filter == "")? "selected":""?>>--Select Genre--</option>
            <option value="history" <?= ($filter == "history")? "selected":""?>>History</option>
            <option value="science" <?= ($filter == "science")? "selected":""?>>Science</option>
            <option value="fiction" <?= ($filter == "fiction")? "selected":""?>>Fiction</option>
        </select>
        <button type="submit">Filter</button>
    </form>
    <table border="1">
        <tr>
            <td>No.</td>
            <td>Title</td>
            <td>Author</td>
            <td>Genre</td>
            <td>Year</td>
        </tr>
        <?php
        $id = 1;
        foreach($books as $book){
        ?>
        <tr>
            <td><?= $id++?></td>
            <td><?= htmlspecialchars($book["title"])?></td>
            <td><?= htmlspecialchars($book["author"])?></td>
            <td><?= htmlspecialchars($book["genre"])?></td>
            <td><?= htmlspecialchars($book["year"])?></td>
        </tr>
        <?php
        }
        ?>
    </table>
</body>
</html>