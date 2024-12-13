<?php 
    include("./inc/database.php");
    include("./inc/header.php");

    $sql = "SELECT * FROM countries WHERE id_continent = 1 AND is_showed = 1";
    $result = mysqli_query($conn, $sql);

    $countries = [];
    while ($data = mysqli_fetch_assoc($result)) {
        $countries[] = $data;
    };

    $sql = "SELECT * FROM languages";
    $result = mysqli_query($conn, $sql);

    $languages = [];
    while ($data = mysqli_fetch_assoc($result)) {
        $languages[] = $data;
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
    
    function countryCardHtml($id, $name, $imageUrl, $description, $languageId) {
        return "
            <a data-language='$languageId' href='./details.php?id=$id'  class='h-56 cursor-pointer group relative rounded-lg overflow-hidden'>
                <img class='min-h-full' src='$imageUrl' alt='$name'>
                <div class='absolute top-0 right-0 group-hover:right-full transition-all duration-300 w-full h-full bg-primary bg-opacity-45'></div>
                <div class='absolute top-0 left-0 group-hover:left-full transition-all duration-300 w-full h-full text-center p-2 py-4 text-white'>
                    <span class='text-2xl font-bold'>$name</span>
                    <p class='lg:text-sm mt-6'>$description</p>
                </div>
            </a>
        ";
    }    
?>

    <header class="flex justify-between container py-5">
        <a class="text-primary font-bold text-2xl" href="./">GEOAFRICA</a>
        <a href="./addCountry.php" class="bg-primary py-1 px-3 text-white rounded-lg flex gap-2 items-center"><i class="fa fa-plus"></i>Add Country</a>
    </header>

    <main class="flex py-10 justify-center bg-primary bg-opacity-50">
        <div class="max-w-2xl relative">
            <img class="w-full" src="../assets/images/africa (2).svg" alt="Africa Map">

            <div id="map-cities">
            <?php foreach ($countries as $country) {
                echo countryMapHtmlElement($country["id_country"], $country["name"], $country["shortname"], $country["x"], $country["y"]);
            }?>
            </div>
        </div>
    </main>

    <div class="container pt-6 pb-12">
        <h1 class="text-center font-bold text-3xl mb-12">Explore Countries</h1>
        <div class="gap-4 flex w-fit mb-8">
            <div class="relative">
                <input autocomplete="off" id="language" class="bg-[#eee] rounded-lg py-1 pl-2 pr-8 outline-none" type="text" placeholder="Filter by language">
                <div id="languages" class="flex hidden overflow-hidden absolute top-[110%] z-10 bg-[#eee] rounded-lg w-full flex-col"></div>
            </div>
            <button id="reset-language" class="mx-auto w-fit bg-primary py-1 px-3 text-white rounded-lg flex gap-2 items-center">Reset</butotn>
        </div>
        <div id="cities-cards" class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
            <?php foreach ($countries as $country) {
                echo countryCardHtml($country["id_country"] ,$country['name'], $country['image_url'], $country['description'], $country["id_language"]);
            }?>
        </div>

        <a href="./addCountry.php" class="mx-auto w-fit bg-primary mt-8 py-1 px-3 text-white rounded-lg flex gap-2 items-center"><i class="fa fa-plus"></i>Add Country</a>
    </div>

    <script>
        if (screen.width < 600 || document.body.clientWidth < 600) {
            Array.from(document.getElementById("map-cities").children).forEach((element) =>{
                element.style.left = `${parseInt(element.style.left) - 2.35}%`;
                element.style.top = `${parseInt(element.style.top) - 2.35}%`;
            })
        }

        const citiesContainer = document.getElementById("cities-cards");
        const languages = <?= json_encode($languages) ?>

        const languageInput = document.getElementById("language");
        const languagesContainer = document.getElementById("languages");

        const resetLanguageButton = document.getElementById("reset-language");
        resetLanguageButton.onclick = function(){
            languageInput.value = "";
                                
            Array.from(citiesContainer.children).forEach((card) => {
                card.classList.remove("hidden");
            });
        }

        languageInput.onblur = () => closeOptionsContainer(languagesContainer, filterByLanguage);
        languageInput.onfocus = () => openOptionsContainer(languagesContainer, filterByLanguage);
        languageInput.onkeyup = filterByLanguage;

        function filterByLanguage(){
            let filteredArray = languages.filter(city => city["name"].toLowerCase().search(languageInput.value.toLowerCase()) != -1);
            filterLanguagesOptions(filteredArray);
        }

        function filterLanguagesOptions(array){
            languagesContainer.innerHTML = "";
            let lastLanguage = array[array.length - 1];

            if (array != 0) {
                for (let language of array) {
                    let style = language == lastLanguage ? "": "border-b";
                    languagesContainer.innerHTML += `<span data-id='${language['id_language']}' class='cursor-pointer hover:bg-slate-200 px-2 py-1 ${style} border-b-black'>${language['name']}</span>`;
                }
            }else{
                languagesContainer.innerHTML = "<span class='px-2 py-1 text-gray-500'>No languages available</span>";
            }

            const languageOptions = Array.from(languagesContainer.children);
            languageOptions.forEach(option => {
                option.onmousedown = function(){
                    let languageId = option.getAttribute("data-id");
                    languageInput.value = option.textContent;
                    
                    Array.from(citiesContainer.children).forEach((card) => {
                        let cityLanguageId = card.getAttribute("data-language");

                        if (languageId == cityLanguageId) {
                            card.classList.remove("hidden");
                        }
                        else{
                            card.classList.add("hidden");
                        }
                    });
                }
            });
        }

        function closeOptionsContainer(element, func) {
            func();
            element.classList.add("hidden");
        }
        function openOptionsContainer(element, func) {
            func();
            element.classList.remove("hidden");
        }
    </script>

<?php include "./inc/footer.php" ?>