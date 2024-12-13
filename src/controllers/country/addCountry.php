<?php
session_start();
include("../../inc/database.php");

$continentId = filter_input(INPUT_POST, 'id_continent', FILTER_SANITIZE_NUMBER_INT);
$population = filter_input(INPUT_POST, 'population', FILTER_SANITIZE_NUMBER_INT);
$countryId = filter_input(INPUT_POST, 'id_country', FILTER_SANITIZE_NUMBER_INT);
$languageId = filter_input(INPUT_POST, 'id_language', FILTER_SANITIZE_NUMBER_INT);
$cities_ids = array_map('intval', json_decode($_POST['ids_cities'], true));


if ($continentId && $countryId && $languageId && $population && $population >= 1) {
    $stmt = $conn->prepare("UPDATE countries 
            SET population = ?, id_language = ?, is_showed = 1
            WHERE id_country = ?");
    $stmt->bind_param("iii", $population, $languageId, $countryId);
    $stmt->execute();

    if (!empty($cities_ids)) {
        $placeholders = implode(',', array_fill(0, count($cities_ids), '?'));

        $sql = "UPDATE cities SET is_showed = 1 WHERE id_city IN ($placeholders)";
        $stmt = $conn->prepare($sql);
    
        $types = str_repeat('i', count($cities_ids));
        $stmt->bind_param($types, ...$cities_ids);
    
        $stmt->execute();
    }

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
