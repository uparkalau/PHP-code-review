<?php

class Database {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli("localhost", "root", "password", "my_database");

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function saveData($name, $description, $price) {
        $sql = "INSERT INTO items (name, description, price) VALUES ('$name', '$description', '$price')";
        if (!$this->conn->query($sql)) {
            echo "Error: " . $sql . "<br>" . $this->conn->error;
        }
    }

    public function __destruct() {
        $this->conn->close();
    }
}

class ApiClient {
    public function fetchData() {
        $api_url = "https://api.example.com/data";
        $response = file_get_contents($api_url);
        return json_decode($response, true);
    }
}

$database = new Database();
$client = new ApiClient();
$data = $client->fetchData();

foreach ($data as $item) {
    $database->saveData($item['name'], $item['description'], $item['price']);
}
?>
