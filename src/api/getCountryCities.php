<?php
    include("../inc/database.php");

    $countryId = intval($_GET["id"]);

    $stmt = $conn->prepare("SELECT * FROM cities WHERE id_country = ?");
    $stmt->bind_param("i", $countryId);
    $stmt->execute();
    $data = $stmt->get_result();

    $cities = [];
    while($city = $data->fetch_assoc()){
        $cities[] = $city;
    }

    echo json_encode(["success" => true, "cities" => $cities]);
 