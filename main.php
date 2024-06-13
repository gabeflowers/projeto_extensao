<?php $servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "projeto_a3";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}else {
    $sql = "SELECT * FROM centrocusto";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"]. " - Nome: " . $row["nome"]. " - ID Usuário: " . $row["idUsuario"]. " - Ativo: " . $row["ativo"]. " - Data de Cadastro: " . $row["dtCadastro"]. "<br>";
    }
    } else {
        echo "0 resultados";
    }
    $conn->close();
}