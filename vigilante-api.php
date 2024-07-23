php
Copiar código
<?php
$servername = "localhost";  // Endereço do servidor MySQL
$username = "root";         // Nome de usuário do MySQL
$password = "password";     // Senha do MySQL
$dbname = "equipment_data"; // Nome do banco de dados

// Conectar ao banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obter os dados enviados via POST
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['ipAddress']) && isset($data['hostname']) && isset($data['currentTime'])) {
    $ipAddress = $conn->real_escape_string($data['ipAddress']);
    $hostname = $conn->real_escape_string($data['hostname']);
    $currentTime = $conn->real_escape_string($data['currentTime']);

    // Inserir os dados na tabela
    $sql = "INSERT INTO ip_logs (ipAddress, hostname, currentTime) VALUES ('$ipAddress', '$hostname', '$currentTime')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["status" => "success", "message" => "Data inserted successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid input"]);
}

// Fechar a conexão
$conn->close();
?>