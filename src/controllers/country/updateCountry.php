<?php
session_start();
include("../../inc/database.php");

$population = filter_input(INPUT_POST, 'population', FILTER_SANITIZE_NUMBER_INT);
$countryId = filter_input(INPUT_POST, 'id_country', FILTER_SANITIZE_NUMBER_INT);
$languageId = filter_input(INPUT_POST, 'id_language', FILTER_SANITIZE_NUMBER_INT);

if ($countryId && $languageId && $population && $population >= 1) {
    $stmt = $conn->prepare("UPDATE countries 
            SET population = ?, id_language = ? 
            WHERE ? = $countryId");
    $stmt->bind_param("iii", $population, $languageId, $countryId);
    $stmt->execute();
    $_SESSION['status'] = 'success';
    $_SESSION['message'] = 'Country updated successfully!';

} else {
    $_SESSION['status'] = 'error';
    $_SESSION['message'] = 'Invalid inputs data.';
}

header("Location: " . $_SERVER['HTTP_REFERER']);

?>
