<?php 
    include("./inc/database.php");
    include("./inc/header.php");

    $sql = "SELECT * FROM countries WHERE id_continent = 1";
    $result = mysqli_query($conn, $sql);

    $countries = [];
    while ($data = mysqli_fetch_assoc($result)) {
        $countries[] = $data;
    };

    function countryMapHtmlElement($id, $country, $countryShortName, $x, $y) {
        return "
            <a href='./details.php?id=$id' class='absolute cursor-pointer group' style='left: $x%; top: $y%;'>
                <div class='relative p-0.5 bg-primary rounded-sm z-20 group-hover:scale-[2.75] group-hover:rounded-b-none group-hover:z-30 duration-500 transition-all'>
                    <div class='flag max-w-10'>
                        <img class='w-full min-h-7' src='https://flagcdn.com/w320/$countryShortName.png' alt='$country'>
                    </div>

                    <div class='absolute opacity-0 -z-10 flex  justify-center items-center w-full left-0 top-0 group-hover:top-[98%] group-hover:opacity-100 transition-all duration-300'>
                        <span class='w-full pb-0.5 text-center rounded-b-sm bg-primary px-0.5 text-[.35rem] text-white'>$country</span>
                    </div>
                </div>
                <span class='absolute left-1/2 -translate-x-1/2 top-[98%] border-8 border-transparent border-t-primary'></span>
            </a>
        ";
    }    
    
    function countryCardHtml($id, $name, $imageUrl, $description) {
        return "
            <a href='./details.php?id=$id'  class='h-56 cursor-pointer group relative rounded-lg overflow-hidden'>
                <img class='min-h-full' src='$imageUrl' alt='$name'>
                <div class='absolute top-0 right-0 group-hover:right-full transition-all duration-300 w-full h-full bg-primary bg-opacity-45'></div>
                <div class='absolute top-0 left-0 group-hover:left-full transition-all duration-300 w-full h-full text-center p-2 py-4 text-white'>
                    <span class='text-2xl font-bold'>$name</span>
                    <p class='text-xs mt-7'>$description</p>
                </div>
            </a>
        ";
    }    
?>

    <header class="flex justify-between container py-5">
        <a class="text-primary font-bold text-2xl" href="./">GEOAFRICA</a>
        <button class="bg-primary py-1 px-3 text-white rounded-lg flex gap-2 items-center"><i class="fa fa-plus"></i>Add Country</button>
    </header>

    <main class="flex py-10 justify-center bg-primary bg-opacity-50">
        <div class="max-w-2xl relative">
            <img class="w-full" src="../assets/images/africa (2).svg" alt="Africa Map">

            <?php foreach ($countries as $country) {
                echo countryMapHtmlElement($country["id_country"], $country["name"], $country["shortname"], $country["x"], $country["y"]);
            }?>
        </div>
    </main>

    <div class="container pt-6 pb-12">
        <h1 class="text-center font-bold text-3xl mb-12">Explore Countries</h1>
        <div class="grid grid-cols-4 gap-2">
            <?php foreach ($countries as $country) {
                echo countryCardHtml($country["id_country"] ,$country['name'], $country['image_url'], $country['description']);
            }?>
        </div>

        <button class="mx-auto bg-primary mt-8 py-1 px-3 text-white rounded-lg flex gap-2 items-center"><i class="fa fa-plus"></i>Add Country</button>
    </div>

<?php include "./inc/footer.php" ?>