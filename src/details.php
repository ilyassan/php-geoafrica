<?php
    include("./inc/database.php");
    include("./inc/header.php");

    if (!isset($_GET["id"])) {
        die();
    }

    $country_id = $_GET["id"];
    $sql = "SELECT countries.*, languages.name as language FROM countries
            JOIN languages ON languages.id_language = countries.id_language
            WHERE id_country = $country_id";

    $data = mysqli_query($conn, $sql);
    $country = mysqli_fetch_assoc($data);

    $sql = "SELECT * FROM cities
            WHERE id_country = $country_id";

    $data = mysqli_query($conn, $sql);
    $cities = [];
    while ($city = mysqli_fetch_assoc($data)) {
        $cities[] = $city; 
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
        
                <div class="flex flex-1 justify-between">
                    <form class="flex flex-col gap-3">
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xl" for="country">Country:</label>
                            <input disabled class="text-xl bg-[#eee] outline-none px-3 py-1 rounded-lg" type="text" value="<?= $country["name"] ?>" name="country" id="country">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xl" for="population">Population:</label>
                            <input class="text-xl bg-[#eee] outline-none px-3 py-1 rounded-lg" type="number" step="100000" value="<?= $country["population"] ?>" name="population" id="population">
                        </div>
                        <div class="flex flex-col gap-1.5">
                            <label class="text-xl" for="population">Language:</label>
                            <input class="text-xl bg-[#eee] outline-none px-3 py-1 rounded-lg" type="text" value="<?= $country["language"] ?>" name="language" id="language">
                        </div>
                    </form>
        
                    <div class="flex flex-1 items-start justify-end gap-4">
                        <span class="bg-primary px-2 py-1 rounded-lg text-white">Save <i class="fa-solid fa-pen-to-square"></i></span>
                        <span class="bg-primary px-2 py-1 rounded-lg text-white">Delete <i class="fa-solid fa-delete-left"></i></span>
                    </div>
                </div>
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

        const cityInput = document.getElementById("city");
        const citiesOptionsContainer = document.getElementById("cities");
        const citiesTagsContainer = document.getElementById("cities-tags");
        const citiesCardsContainer = document.getElementById("cities-cards");

        showData();

        function showData(){
            citiesOptionsContainer.innerHTML = "";
            citiesTagsContainer.innerHTML = "";
            citiesCardsContainer.innerHTML = "";

            if (unShowedCities != 0) {
                let lastCity = unShowedCities[unShowedCities.length - 1];

                for (let city of unShowedCities) {
                    let style = city == lastCity ? "": "border-b";
                    cities.innerHTML += `<span data-id='${city['id_city']}' class='cursor-pointer hover:bg-slate-200 px-2 py-1 ${style} border-b-black'>${city['name']}</span>`;
                }
            } else {
                cities.innerHTML = "<span class='px-2 py-1 text-gray-500'>No cities available</span>";
            }
            for(let city of showedCities){
                citiesTagsContainer.innerHTML += `
                    <div style='border-top-left-radius: .3rem; border-bottom-left-radius: .3rem;' class='flex items-center gap-3 relative text-white bg-primary px-2'>
                        <i class='cursor-pointer text-sm rotate-180 fa-solid fa-delete-left'></i>
                        ${city["name"]}
                        <span class='absolute w-0 h-0 -right-[16px] border-y-[16px] border-y-transparent border-l-[16px] border-l-primary'></span>
                    </div>`;   
            }

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

            const citiesOptions = Array.from(citiesOptionsContainer.children);
            citiesOptions.forEach(option => {
                option.onmousedown = function(){
                    let cityId = option.getAttribute("data-id");
                    let city = option.textContent;

                    cityInput.value = city;
                    cityInput.setAttribute("data-id", cityId);
                }
            });
        }


        cityInput.onblur = closeOptionsContainer;
        cityInput.onfocus = openOptionsContainer;

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

        function closeOptionsContainer() {
            citiesOptionsContainer.classList.add("hidden");
        }
        function openOptionsContainer() {
            citiesOptionsContainer.classList.remove("hidden");
        }
    </script>

<?php include "./inc/header.php" ?>