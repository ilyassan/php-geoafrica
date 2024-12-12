<?php
    include("../inc/database.php");

    $countryId = intval($_GET["id"]);

    $sql = "SELECT * FROM cities WHERE id_country = $countryId";
    $data = mysqli_query($conn, $sql);

    $cities = [];
    while($city = mysqli_fetch_assoc($data)){
        $cities[] = $city;
    }

    echo json_encode(["success" => true, "cities" => $cities]);
 