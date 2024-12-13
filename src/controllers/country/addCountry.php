<?php
session_start();
include("../../inc/database.php");

$population = filter_input(INPUT_POST, 'population', FILTER_SANITIZE_NUMBER_INT);
$countryId = filter_input(INPUT_POST, 'id_country', FILTER_SANITIZE_NUMBER_INT);
$languageId = filter_input(INPUT_POST, 'id_language', FILTER_SANITIZE_NUMBER_INT);
$cities_ids = array_map('intval', json_decode($_POST['ids_cities'], true));


if ($countryId && $languageId && $population && $population >= 1) {
    $sql = "UPDATE countries 
            SET population = $population, id_language = $languageId, is_showed = 1
            WHERE id_country = $countryId";
    
    mysqli_query($conn, $sql);

    $sql = "UPDATE cities
            SET is_showed = 1
            WHERE id_city IN (" . implode(',', $cities_ids) . ")";

    mysqli_query($conn, $sql);

    $_SESSION['status'] = 'success';
    $_SESSION['message'] = 'Country added successfully!';
        header("Location: ../../");
}
else {
     $_SESSION['status'] = 'error';
     $_SESSION['message'] = 'Invalid inputs data.';
     header("Location: ". $_SERVER['HTTP_REFERER']);
}
    
?>
