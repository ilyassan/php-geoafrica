<?php
    include("./inc/database.php");
    include("./inc/header.php");

    if (!isset($_GET["id"]) || !filter_var($_GET["id"], FILTER_VALIDATE_INT)) {
        die("Invalid ID parameter.");
    }

    $country_id = (int) $_GET["id"];

    $stmt = $conn->prepare( "SELECT countries.*, languages.name as language FROM countries
    JOIN languages ON languages.id_language = countries.id_language
    WHERE id_country = ?");

    $stmt->bind_param("i", $country_id);
    $stmt->execute();
    $data = $stmt->get_result();
    $country = $data->fetch_assoc();

    $stmt = $conn->prepare("SELECT * FROM cities
            WHERE id_country = ?");
    $stmt->bind_param("i", $country_id);
    $stmt->execute();

    $data = $stmt->get_result();
    $cities = [];
    while ($city = mysqli_fetch_assoc($data)) {
        $cities[] = $city; 
    }

    $stmt = $conn->prepare("SELECT * FROM languages");
    $stmt->execute();

    $data = $stmt->get_result();
    $languages = [];
    while ($language = mysqli_fetch_assoc($data)) {
        $languages[] = $language; 
    }

    $showedCities = [];
    $unShowedCities = [];
    foreach($cities as $city){
        if ($city["is_showed"]) {
            $showedCities[] = $city;
        }else{
            $unShowedCities[] = $city;
        }
    }
?>

    <header class="flex justify-between container py-3">
        <a class="text-primary font-bold text-2xl" href="./">GEOAFRICA</a>
    </header>

    <main class="pt-6 pb-12">
        <h1 class="mb-12 font-bold text-center text-3xl">Country Details</h1>

        <div class="container">
            <div class="flex items-center gap-12">
                <div class="max-w-[28rem] overflow-hidden rounded-xl">
                    <img src="<?= $country["image_url"] ?>" alt="<?= $country["name"] ?>">
                </div>
        
                <form class="flex flex-1 justify-between" method="POST">
                    <div class="flex flex-col gap-3">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xl" for="country">Country:</label>
                            <input disabled class="text-xl bg-[#eee] outline-none px-3 py-1 rounded-lg" type="text" value="<?= $country["name"] ?>" id="country">
                            <input class="hidden" type="text" value="<?= $country["id_country"] ?>" name="id_country">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xl" for="population">Population:</label>
                            <input autocomplete="off" class="text-xl bg-[#eee] outline-none px-3 py-1 rounded-lg" type="number" value="<?= $country["population"] ?>" name="population" id="population">
                        </div>
                        <div class="relative flex flex-col gap-1.5">
                            <label class="text-xl" for="population">Language:</label>
                            <input autocomplete="off"  data-id="<?= $country["id_language"]?>" class="text-xl bg-[#eee] outline-none px-3 py-1 rounded-lg" type="text" value="<?= $country["language"] ?>" name="language" id="language">
                            <input id="id_language" class="hidden" type="text" value="<?= $country["id_language"] ?>" name="id_language">
                            <div id="languages" class="flex hidden overflow-hidden absolute top-[110%] z-10 bg-[#eee] rounded-lg w-full flex-col">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-1 items-start justify-end gap-4">
                        <button type="submit" formaction="./controllers/country/updateCountry.php" class="bg-primary px-2 py-1 rounded-lg text-white">Save <i class="fa-solid fa-pen-to-square"></i></button>
                        <button type="submit" formaction="./controllers/country/deleteCountry.php" class="bg-primary px-2 py-1 rounded-lg text-white">Delete <i class="fa-solid fa-delete-left"></i></button>
                    </div>
                </form>
            </div>
        </div>

        <div class="bg-primary h-[1px] mt-10 mb-4"></div>

        <div class="container">
            <h1 class="text-center font-bold text-3xl mb-8">Cities</h1>
            <div class="flex gap-14 mb-10">
                <div class="relative">
                    <div class="relative">
                        <input id="city" class="bg-[#eee] rounded-lg py-1 pl-2 pr-8 outline-none" type="text" placeholder="Add a city">
                        <i id="add-city" class="absolute cursor-pointer text-primary text-xl right-1 top-1/2 -translate-y-1/2 fa fa-plus"></i>
                    </div>
                    <div id="cities" class="flex hidden overflow-hidden absolute top-[110%] z-10 bg-[#eee] rounded-lg w-full flex-col">
                    </div>
                </div>
                <div id="cities-tags" class="flex gap-10 flex-1 max-w-full overflow-y-hidden overflow-x-scroll no-scrollbar">
                </div>
            </div>

            <div id="cities-cards" class="grid grid-cols-4 gap-2">
            </div>
        </div>
    </main>

    <script type="text/javascript">

        const unShowedCities = <?= json_encode($unShowedCities)?>;
        const showedCities = <?= json_encode($showedCities)?>;
        const languages = <?= json_encode($languages)?>;

        const cityInput = document.getElementById("city");
        const citiesOptionsContainer = document.getElementById("cities");
        const citiesTagsContainer = document.getElementById("cities-tags");
        const citiesCardsContainer = document.getElementById("cities-cards");

        const languageInput = document.getElementById("language");
        const languagesContainer = document.getElementById("languages");

        showData();

        function showData(){
            citiesTagsContainer.innerHTML = "";
            citiesCardsContainer.innerHTML = "";

            filterCitiesOptions(unShowedCities);
            searchLanguage();

            for(let city of showedCities){
                citiesTagsContainer.innerHTML += `
                    <div style='border-top-left-radius: .3rem; border-bottom-left-radius: .3rem;' class='flex items-center gap-3 relative text-white bg-primary px-2'>
                        <i data-id="${city["id_city"]}" class='remove-city cursor-pointer text-sm rotate-180 fa-solid fa-delete-left'></i>
                        ${city["name"]}
                        <span class='absolute w-0 h-0 -right-[16px] border-y-[16px] border-y-transparent border-l-[16px] border-l-primary'></span>
                    </div>`;   
            }

            document.querySelectorAll(".remove-city").forEach((button) =>{
                button.onclick= function(){
                    let cityId = button.getAttribute("data-id");
                    removeCity(cityId);
                }
            })


            for( let city of showedCities){
                citiesCardsContainer.innerHTML += `
                    <div class='card cursor-pointer relative rounded-lg overflow-hidden'>
                        <img src='https://ilyassan.github.io/VisitMorocco/dev/assets/images/homepage/img_explore/safi.jpg' alt='morocco'>
                        <div class='flex items-center justify-center absolute top-0 right-0 w-full h-full bg-primary bg-opacity-45'>
                            <span class='text-2xl font-bold text-white'>${city["name"]}</span>
                        </div>
                        ${city["is_capital"] == 1
                            ?
                            "<div class='absolute left-1 top-1 text-xs text-white font-bold bg-primary px-2 py-1 rounded-xl'>Capital</div>"
                            :
                            ""
                        }
                    </div>`;
                }
        }

        function filterCitiesOptions(array){
            citiesOptionsContainer.innerHTML = "";

            if (array != 0) {
                let lastCity = array[array.length - 1];

                for (let city of array) {
                    let style = city == lastCity ? "": "border-b";
                    citiesOptionsContainer.innerHTML += `<span data-id='${city['id_city']}' class='cursor-pointer hover:bg-slate-200 px-2 py-1 ${style} border-b-black'>${city['name']}</span>`;
                }
            } else {
                citiesOptionsContainer.innerHTML = "<span class='px-2 py-1 text-gray-500'>No cities available</span>";
            }

            const citiesOptions = Array.from(citiesOptionsContainer.children);
            citiesOptions.forEach(option => {
                let cityId = option.getAttribute("data-id");
                let city = option.textContent;
                if (!cityId) return;

                option.onmousedown = function(){

                    cityInput.value = city;
                    cityInput.setAttribute("data-id", cityId);
                }
            });
        }

        function filterLanguagesOptions(array){
            languagesContainer.innerHTML = "";

            let lastLanguage = array[array.length - 1];

            for (let language of array) {
                let style = language == lastLanguage ? "": "border-b";
                languagesContainer.innerHTML += `<span data-id='${language['id_language']}' class='cursor-pointer hover:bg-slate-200 px-2 py-1 ${style} border-b-black'>${language['name']}</span>`;
            }

            const languageOptions = Array.from(languagesContainer.children);
            languageOptions.forEach(option => {
                option.onmousedown = function(){
                    let languageId = option.getAttribute("data-id");
                    let language = option.textContent;

                    languageInput.value = language;
                    document.getElementById("id_language").value = languageId;
                }
            });
        }

        cityInput.onblur = () => closeOptionsContainer(citiesOptionsContainer, searchCity);
        cityInput.onfocus = () => openOptionsContainer(citiesOptionsContainer, searchCity);
        cityInput.onkeyup = searchCity;

        function searchCity(){
            let filteredArray = unShowedCities.filter(city => city["name"].toLowerCase().search(cityInput.value.toLowerCase()) != -1);
            filterCitiesOptions(filteredArray);
        }

        languageInput.onblur = () => closeOptionsContainer(languagesContainer, searchLanguage);
        languageInput.onfocus = () => openOptionsContainer(languagesContainer, searchLanguage);
        languageInput.onkeyup = searchLanguage;

        function searchLanguage(){
            let filteredArray = languages.filter(language => language["name"].toLowerCase().search(languageInput.value.toLowerCase()) != -1);
            filterLanguagesOptions(filteredArray);
        }

        const addCityButton = document.getElementById("add-city");
        addCityButton.onclick = async function(){
            let cityId = cityInput.getAttribute("data-id");
            if (!cityId) return;
            
            cityInput.removeAttribute("data-id");
            cityInput.value = "";

            let cityIndex = unShowedCities.findIndex(city => city["id_city"] == cityId);

            let city = unShowedCities.splice(cityIndex, 1)[0];
            showedCities.push(city);
            showData();

            await fetch("./api/addCity.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ id: cityId })
                    });
        }

        async function removeCity(id){
            let cityIndex = showedCities.findIndex(city => city["id_city"] == id);

            let city = showedCities.splice(cityIndex, 1)[0];
            unShowedCities.push(city);
            showData();

            await fetch("./api/removeCity.php", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify({ id })
                    });
        }

        const populationInput = document.getElementById("population");
        populationInput.onkeyup = () => {
            if (parseInt(populationInput.value) <= 0) {
                populationInput.value = 1;
            }
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