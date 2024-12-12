<?php
include("../../inc/database.php");

$population = filter_input(INPUT_POST, 'population', FILTER_SANITIZE_NUMBER_INT);
$countryId = filter_input(INPUT_POST, 'id_country', FILTER_SANITIZE_NUMBER_INT);
$languageId = filter_input(INPUT_POST, 'id_language', FILTER_SANITIZE_NUMBER_INT);

if ($population && $countryId && $languageId) {
    $sql = "UPDATE countries 
            SET population = $population, id_language = $languageId 
            WHERE id_country = $countryId";
    
    mysqli_query($conn, $sql);
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

?>
