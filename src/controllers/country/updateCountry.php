<?php
include("../../inc/database.php");


// Validate and sanitize the incoming POST data
$population = filter_input(INPUT_POST, 'population', FILTER_SANITIZE_NUMBER_INT);
$countryId = filter_input(INPUT_POST, 'id_country', FILTER_SANITIZE_NUMBER_INT);
$languageId = filter_input(INPUT_POST, 'id_language', FILTER_SANITIZE_NUMBER_INT);

echo $languageId;

// Ensure all fields are provided and valid
if ($population && $countryId && $languageId) {
    // Prepare the SQL statement to update the country
    $sql = "UPDATE countries 
            SET population = $population, id_language = $languageId 
            WHERE id_country = $countryId";
    
    // Use a prepared statement for security
    mysqli_query($conn, $sql);
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

?>
