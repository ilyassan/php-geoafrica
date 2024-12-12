<?php
include("../../inc/database.php");


// Validate and sanitize the incoming POST data
$population = filter_input(INPUT_POST, 'population', FILTER_SANITIZE_NUMBER_INT);
$countryId = filter_input(INPUT_POST, 'id_country', FILTER_SANITIZE_NUMBER_INT);
$languageId = filter_input(INPUT_POST, 'id_language', FILTER_SANITIZE_NUMBER_INT);
$cities_ids = array_map('intval', json_decode($_POST['ids_cities'], true));

// Ensure all fields are provided and valid
if ($population && $countryId && $languageId) {
    $sql = "UPDATE countries 
            SET population = $population, id_language = $languageId, is_showed = 1
            WHERE id_country = $countryId";
    
    mysqli_query($conn, $sql);

    $sql = "UPDATE cities
            SET is_showed = 1
            WHERE id_city IN (" . implode(',', $cities_ids) . ")";

    mysqli_query($conn, $sql);

    header("Location: ../../");
}
?>
