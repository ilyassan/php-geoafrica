<?php
    include("./inc/header.php");
    include("./inc/database.php");

    $continents = selectAllFromTable("continents");
    $countries = selectAllFromTable("countries", "WHERE is_showed = 0");
    $languages = selectAllFromTable("languages");

    function selectAllFromTable($table, $condition = ""){
        global $conn;
        
        $sql = "SELECT * FROM $table $condition";
        $data = mysqli_query($conn, $sql);
        $array = [];
        while ($row = mysqli_fetch_assoc($data)) {
            $array[] = $row;
        }

        return $array;
    }
?>

    <header class="flex justify-between container py-3">
        <a class="text-primary font-bold text-2xl" href="./">GEOAFRICA</a>
    </header>

    <main class="pt-6 pb-12">
        <h1 class="mb-12 font-bold text-center text-3xl">Add Country</h1>

        <div class="flex gap-8 container">
            <div class="w-1/2 max-h-fit rounded-xl overflow-hidden border-4 border-primary">
                <img class="scale-105" src="../assets/images/world.jpg" alt="Map">
            </div>
            <form action="./controllers/country/addCountry.php" method="POST" class="flex flex-1 flex-col gap-3">
                <div class="flex gap-x-2 flex-col md:flex-row justify-between">
                    <div class="relative flex-1">
                        <div class="flex flex-col gap-2">
                            <label class="text-lg" for="continent">Continent:</label>
                            <input autocomplete="off"  id="continent" class="bg-[#eee] rounded-lg py-2 pl-2 pr-8 outline-none" type="text" placeholder="Select a continent">
                        </div>
                        <div id="continents" class="flex hidden overflow-hidden absolute top-[110%] z-10 bg-[#eee] rounded-lg w-full flex-col"></div>
                        <input id="id_continent" name="id_continent" class="hidden" type="text">
                    </div>
                    <div class="relative flex-1">
                        <div class="flex flex-col gap-2">
                            <label class="text-lg" for="country">Country:</label>
                            <input autocomplete="off"  id="country" class="bg-[#eee] rounded-lg py-2 pl-2 pr-8 outline-none" type="text" placeholder="Search for a country">
                        </div>
                        <div id="countries" class="flex hidden overflow-hidden absolute top-[110%] z-10 bg-[#eee] rounded-lg w-full flex-col"></div>
                        <input id="id_country" name="id_country" class="hidden" type="text">
                    </div>
                </div>

                <div class="flex gap-x-2 flex-col md:flex-row justify-between">
                    <div class="flex-1 flex flex-col gap-2">
                        <label class="text-lg" for="population">Population:</label>
                        <input autocomplete="off"  class="bg-[#eee] outline-none px-3 py-2 rounded-lg" type="number" placeholder="Country Population" name="population" id="population">
                    </div>

                    <div class="relative flex-1">
                        <div class="flex flex-col gap-2">
                            <label class="text-lg" for="language">Language:</label>
                            <input autocomplete="off"  id="language" class="bg-[#eee] rounded-lg py-2 pl-2 pr-8 outline-none" type="text" placeholder="Select the language">
                        </div>
                        <div id="languages" class="flex hidden overflow-hidden absolute top-[110%] z-10 bg-[#eee] rounded-lg w-full flex-col"></div>
                        <input id="id_language" name="id_language" class="hidden" type="text">
                    </div>
                </div>
                <div class="relative w-1/2">
                    <div class="flex flex-col gap-2">
                        <label class="text-lg" for="language">Cities:</label>
                        <div class="relative">
                            <input autocomplete="off"  id="city" class="w-full bg-[#eee] rounded-lg py-2 pl-2 pr-8 outline-none" type="text" placeholder="Add a city">
                            <i id="add-city" class="absolute cursor-pointer text-primary text-xl right-2 top-1/2 -translate-y-1/2 fa fa-plus"></i>
                        </div>
                    </div>
                    <div id="cities" class="flex hidden overflow-hidden absolute top-[110%] z-10 bg-[#eee] rounded-lg w-full flex-col">
                        <span class='text-center px-2 py-1 text-gray-500'>Please select a country.</span>
                    </div>
                </div>
                <div id="cities-tags" class="flex gap-2">
                </div>
                <input type="text" class="hidden" name="ids_cities" id="ids_cities" value="[]">

                <button class="flex mt-6 gap-2.5 items-center w-fit bg-primary px-4 py-1 rounded-lg text-white">Add <i class="fa-solid fa-pen-to-square"></i></button>
            </form>
        </div>
    </main>

    <script type="text/javascript">
        const citiesOptionsContainer = document.getElementById("cities");
        const cityInput = document.getElementById("city");
        let cities = [];
        let selectedCities = [];

        const continents = <?= json_encode($continents)?>;
        const continentsContainer = document.getElementById("continents");
        
        const countries = <?= json_encode($countries)?>;
        const countriesContainer = document.getElementById("countries");

        const languages = <?= json_encode($languages)?>;
        const languagesContainer = document.getElementById("languages");

        showData(continentsContainer, continents, 'id_continent');
        showData(countriesContainer, countries, 'id_country');
        showData(languagesContainer, languages, 'id_language');

        function showData(container, array, idKey) {
            container.innerHTML = "";

            if (array.length > 0) {
                let lastElement = array[array.length - 1];

                for (let item of array) {
                    let style = item === lastElement ? "" : "border-b";
                    container.innerHTML += `
                        <span 
                            data-id='${item[idKey]}' 
                            class='cursor-pointer hover:bg-slate-200 px-2 py-1 ${style} border-b-black'>${item["name"]}</span>`;
                }
            } else {
                container.innerHTML = "<span class='px-2 py-1 text-gray-500'>No data available</span>";
            }

            inputEvents();
        }

        const languageInput = document.getElementById("language");
        languageInput.onkeyup = (e) => filterSearch(e, languagesContainer, languages, 'id_language');

        const countryInput = document.getElementById("country");
        countryInput.onkeyup = (e) => filterSearch(e, countriesContainer, countries, 'id_country');

        async function onCountryChange(countryId){
            cityInput.removeAttribute("data-id");
            cityInput.value = "";

            const response = await fetch(`./api/getCountryCities.php?id=${countryId}`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json"
                }
            });
            const data = await response.json();
            cities = data.cities;
            selectedCities = [];

            showData(citiesOptionsContainer, cities, 'id_city');
            showCitiesTags();
        }

        const addCityButton = document.getElementById("add-city");
        addCityButton.onclick = function(){
            let cityId = cityInput.getAttribute("data-id");
            if (!cityId) return;
            
            cityInput.removeAttribute("data-id");
            cityInput.value = "";

            let cityIndex = cities.findIndex(city => city["id_city"] == cityId);
            let city = cities.splice(cityIndex, 1)[0];
            selectedCities.push(city);
            showData(citiesOptionsContainer, cities, 'id_city');
            showCitiesTags();
        }

        function showCitiesTags() {
            let tagsContainer = document.getElementById("cities-tags");
            tagsContainer.innerHTML = "";

            for (let city of selectedCities) {
                tagsContainer.innerHTML += `
                    <div data-id="${city["id_city"]}" class="cursor-pointer flex gap-2 items-center bg-primary text-white px-2 py-1 rounded-lg w-fit">
                        ${city["name"]}
                        <i class="text-sm fa-solid fa-plus rotate-45"></i>
                    </div>`
            }

            Array.from(tagsContainer.children).forEach(tag => {
                tag.onclick = function(){
                    let cityId = tag.getAttribute("data-id");
                    let cityIndex = selectedCities.findIndex(city => city["id_city"] == cityId);
                    let city = selectedCities.splice(cityIndex, 1)[0];
                    cities.push(city);

                    showData(citiesOptionsContainer, cities, 'id_city');
                    showCitiesTags();
                }
            });

            document.getElementById("ids_cities").value = JSON.stringify(selectedCities.map(city => city["id_city"]));
        }

        const continentInput = document.getElementById("continent");
        continentInput.onkeyup = (e) => filterSearch(e, continentsContainer, continents, 'id_continent');

        function filterSearch(e, container, array, idKey){
            let filteredArray = array.filter(item => item["name"].toLowerCase().search(e.target.value.toLowerCase()) != -1);
            showData(container, filteredArray, idKey);
        }

        function inputEvents(){
            inputOptions("continent", "continents");
            inputOptions("country", "countries");
            inputOptions("language", "languages");
            inputOptions("city", "cities");
        }

        function inputOptions(inputId, optionsContainerId){
            const input = document.getElementById(inputId);
            const optionsContainer = document.getElementById(optionsContainerId);
            const hiddenInput = optionsContainer.parentElement.querySelector("input.hidden");

            const options = Array.from(optionsContainer.children);
            options.forEach(option => {
                let id = option.getAttribute("data-id");
                let name = option.textContent;
                if (!id) return;

                option.onmousedown = function(){
                    if (inputId != "city") {
                        hiddenInput.value = id;
                    }
                    input.value = name;
                    input.setAttribute("data-id", id);

                    if (inputId == "country") {
                        onCountryChange(id);
                    }
                }
            });

            input.onblur = closeOptionsContainer;
            input.onfocus = openOptionsContainer;

            function closeOptionsContainer() {
                optionsContainer.classList.add("hidden");
            }
            function openOptionsContainer() {
                optionsContainer.classList.remove("hidden");
            }
        }

        const populationInput = document.getElementById("population");
        populationInput.onkeyup = () => {
            if (parseInt(populationInput.value) <= 0) {
                populationInput.value = 1;
            }
        }
    </script>

<?php include "./inc/footer.php" ?>