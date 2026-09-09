<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adopt a Pet</title>
</head>
<body>    
    <h1>Adopt a Pet</h1>
    <?php
    $db = new SQLite3("catalog.db");
    
    $db->exec("CREATE TABLE IF NOT EXISTS pets (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT UNIQUE,
        gender TEXT,
        age INTEGER,
        image TEXT
    )");

    $counter = $db->querySingle('SELECT COUNT (*) FROM pets ');
	if ($counter == 0) {
	    $db->exec("INSERT INTO pets (name, gender, age, image) VALUES ('George','Male', 2, 'pic1.png'  )");
        $db->exec("INSERT INTO pets (name, gender, age, image) VALUES ('Joey','Male', 5, 'pic2.png'  )");
        $db->exec("INSERT INTO pets (name, gender, age, image) VALUES ('Catrina','Female', 10, 'pic3.png')");
        $db->exec("INSERT INTO pets (name, gender, age, image) VALUES ('Snowy','Female', 8, 'pic4.png')");
        $db->exec("INSERT INTO pets (name, gender, age, image) VALUES ('Bella','Female', 2, 'pic5.png')");
        $db->exec("INSERT INTO pets (name, gender, age, image) VALUES ('Tom','Male', 3, 'pic6.png')");
        $db->exec("INSERT INTO pets (name, gender, age, image) VALUES ('Oscar','Male', 4, 'pic7.png')");
        $db->exec("INSERT INTO pets (name, gender, age, image) VALUES ('Spencer','Male', 2, 'pic8.png')");
        $db->exec("INSERT INTO pets (name, gender, age, image) VALUES ('Tony','Male', 7, 'pic9.png')");
    }

    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 3;
    $skip = ($page - 1) * $limit; 
    $results = $db->query("SELECT * FROM pets LIMIT $limit OFFSET $skip") ;

    echo "<h1>Pets - Page $page </h1>";
    while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
	    echo "<h2>{$row['name']}</h2>";
	    echo "<p>Gender: {$row['gender']}</p>";
	    echo "<p>Age: {$row['age']}</p>";
	    echo "<img src='{$row['image']}' alt='{$row['name']}' width='200'>";
    }
    $total_posts = $db->querySingle ('SELECT COUNT(*) FROM pets');
    $total_pages = ceil($total_posts / $limit);

    echo "<div style = 'margin-top: 20px; '>";
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo "<strong>$i</strong>"; 
        }
        else {
            echo "<a href='?page=$i'>$i</a>"; 
        }
    }
    echo "</div>";
    ?>

</body>
</html>
