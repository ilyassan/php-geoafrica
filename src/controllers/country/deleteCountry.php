<?php
include("../../inc/database.php");


$countryId = filter_input(INPUT_POST, 'id_country', FILTER_SANITIZE_NUMBER_INT);

if (isset($countryId)) {
    $sql = "UPDATE countries
            SET is_showed = 0
            WHERE id_country = $countryId";
    
    mysqli_query($conn, $sql);

    $sql = "UPDATE cities
            SET is_showed = 0
            WHERE id_country = $countryId";
    
    mysqli_query($conn, $sql);
    header("Location: ../../");
}

?>