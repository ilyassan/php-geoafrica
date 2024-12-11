<?php
    include("../inc/database.php");

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $cityId = intval($data["id"]);

    $sql = "UPDATE cities SET cities.is_showed = 1
            WHERE cities.id_city = $cityId";
    mysqli_query($conn, $sql);

    echo json_encode(["success" => true, "id_received" => $cityId]);
?>
