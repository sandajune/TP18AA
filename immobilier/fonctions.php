<?php
require_once 'connexion.php';

function getProprietes()
{
    global $connexion;
    $sql = "SELECT * FROM proprietes";
    $result = $connexion->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

function getProprieteById($id)
{
    global $connexion;
    $sql = "SELECT * FROM proprietes WHERE id_propriete = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $propriete = $result->fetch_assoc();
    $stmt->close();
    return $propriete;
}

function getAgentByProprieteId($id_propriete)
{
    global $connexion;
    $sql = "SELECT agents.* FROM agents JOIN listings ON agents.id_agent = listings.id_agent WHERE listings.id_propriete = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("i", $id_propriete);
    $stmt->execute();
    $result = $stmt->get_result();
    $agent = $result->fetch_assoc();
    $stmt->close();
    return $agent;
}

function getProprietesByAgentId($id_agent)
{
    global $connexion;
    $sql = "SELECT proprietes.* FROM proprietes JOIN listings ON proprietes.id_propriete = listings.id_propriete WHERE listings.id_agent = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("i", $id_agent);
    $stmt->execute();
    $result = $stmt->get_result();
    $proprietes = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $proprietes;
}

function getAgentById($id_agent)
{
    global $connexion;
    $sql = "SELECT * FROM agents WHERE id_agent = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("i", $id_agent);
    $stmt->execute();
    $result = $stmt->get_result();
    $agent = $result->fetch_assoc();
    $stmt->close();
    return $agent;
}

function verifyLogin($email)
{
    global $connexion;
    $sql = "SELECT id_client FROM clients WHERE email = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->num_rows > 0 ? $result->fetch_assoc()['id_client'] : false;
    $stmt->close();
    return $client;
}

function registerClient($nom, $prenom, $date_naissance, $genre, $email)
{
    global $connexion;
    $sql_check = "SELECT id_client FROM clients WHERE email = ?";
    $stmt_check = $connexion->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    if ($stmt_check->get_result()->num_rows > 0) {
        $stmt_check->close();
        return false;
    }
    $stmt_check->close();

    $sql = "INSERT INTO clients (nom, prenom, date_naissance, genre, email) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("sssss", $nom, $prenom, $date_naissance, $genre, $email);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
}
?>
