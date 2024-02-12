<?php

use PDO;

function createConnection() {
    $dbname = "jenjetsu";
    $username = "Stey";
    $password = "1228";
    $host = "127.0.0.1";
    $port = 5001;
    $options = [];

    $dsn = "pgsql:host=".$host.";port=".$port.";dbname=".$dbname;
    return new PDO($dsn, $username, $password, $options);
}

function insert(PDO $connection) {
    $sql = "INSERT INTO test(id, name) values(?, ?)";
    $params = ['47aa7b61-2dbe-454b-9920-b5b23e39d526', 'Another'];
    $stmt = $connection->prepare($sql);
    $stmt->execute($params);
}

function read(PDO $connection) {
    $sql = "SELECT * FROM test";
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    while($row = $stmt->fetch(PDO::FETCH_LAZY)) {
        echo "id: $row->id name $row->name\n";
    }
}

function update(PDO $connection) {
    $sql = "UPDATE test SET name = 'CHANGED' WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['47aa7b61-2dbe-454b-9920-b5b23e39d526']);
}

function delete(PDO $connection) {
    $sql = "DELETE FROM test WHERE id = :id";
    $stmt = $connection->prepare($sql);
    $stmt->execute(['id' => '47aa7b61-2dbe-454b-9920-b5b23e39d526']);
}

$connection = createConnection();
insert($connection);
read($connection);
update($connection);
read($connection);
delete($connection);
read($connection);