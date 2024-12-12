<?php
    include("../inc/database.php");

    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    $cityId = intval($data["id"]);

    $sql = "UPDATE cities SET cities.is_showed = 1
            WHERE cities.id_city = $cityId";
    /*
          $sql = "UPDATE cities SET cities.is_showed = ? WHERE cities.id_city = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("ii", $cityId, 1);
          $stmt->execute()
          $stmt->close()
     */
    mysqli_query($conn, $sql);

    echo json_encode(["success" => true, "id_received" => $cityId]);
?>
