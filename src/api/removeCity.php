<?php
    include("../inc/database.php");

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $cityId = intval($data["id"]);

    $sql = "UPDATE cities SET cities.is_showed = 0
            WHERE cities.id_city = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $cityId);
    $stmt->execute();

    echo json_encode(["success" => true, "id_received" => $cityId]);
?>
