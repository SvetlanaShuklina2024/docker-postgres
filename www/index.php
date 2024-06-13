<!-- put in ./www directory -->

<html>
 <head>
  <title>Hello...</title>

  <!-- <meta charset="utf-8">  -->

  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

</head>
<body>
    <div class="container">
        <h1>Hi! I'm happy</h1>


    <?php
    $conn = mysqli_connect('db', 'user', 'test', 'myDb');

    if (mysqli_connect_errno()) {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      exit();
    }

    echo("hhh");

    $query = "SELECT * From Person";
    $result = mysqli_query($conn, $query);

    echo '<table class="table table-striped">';
    echo '<thead><tr><th></th><th>id</th><th>name</th></tr></thead>';
    while($value = $result->fetch_array())
    {
        echo '<tr>';
        echo '<td><a href="#"><span class="glyphicon glyphicon-search"></span></a></td>';
        foreach($value as $element){
            echo '<td>' . $element . '</td>';
        }

        echo '</tr>';
    }
    echo '</table>';

    $result->close();

    mysqli_close($conn);
	?>
	<div class="container-2">
        <h1>Postgres</h1>
	<?php
    $host = 'postgresql';
    $port = '5432';
    $dbname = 'myPgDb';
    $user = 'user';
    $password = 'test';
    try {
            $pdo = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<h2>PostgreSQL Connection!</h2>";

            // Insert data if form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['name'])) {
                $name = $_POST['name'];
                $stmt = $pdo->prepare("INSERT INTO people (name) VALUES (:name)");
                $stmt->bindParam(':name', $name);
                $stmt->execute();
                echo "<p>Added user $name!</p>";
            }

            // Fetch data from PostgreSQL
            $stmt = $pdo->query("SELECT * FROM people");
            $people = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo '<h2>People from PostgreSQL</h2>';
            echo '<table class="table table-striped">';
            echo '<thead><tr><th>ID</th><th>Name</th></tr></thead>';
            foreach ($people as $person) {
                echo '<tr>';
                echo '<td>' . $person['id'] . '</td>';
                echo '<td>' . $person['name'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    ?>
	<h2>Добавить пользователя</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="name">Имя пользователя:</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <button type="submit" class="btn btn-primary">Добавить</button>
        </form>
    </div>
</body>
</html>
