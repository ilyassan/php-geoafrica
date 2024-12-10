-- Drop tables if exist
DROP TABLE IF EXISTS cities;
DROP TABLE IF EXISTS countries;
DROP TABLE IF EXISTS languages;
DROP TABLE IF EXISTS continents;

-- Create the tables structure
CREATE TABLE continents (
    id_continent INT AUTO_INCREMENT,
    name varchar(20),
    PRIMARY KEY (id_continent)
);

CREATE TABLE languages (
    id_language INT AUTO_INCREMENT,
    name varchar(20),
    PRIMARY KEY (id_language)
);

CREATE TABLE countries (
    id_country INT AUTO_INCREMENT,
    name VARCHAR(20),
    population INT,
    shortname VARCHAR(2),
    description TEXT,
    image_url TEXT,
    x INT,
    y INT,
    is_showed BOOLEAN DEFAULT FALSE,
    id_language INT,
    id_continent INT,
    PRIMARY KEY (id_country),
    FOREIGN KEY (id_language) REFERENCES languages(id_language),
    FOREIGN KEY (id_continent) REFERENCES continents(id_continent)
);

CREATE TABLE cities (
    id_city INT AUTO_INCREMENT,
    name varchar(20),
    is_capital BOOLEAN,
    is_showed BOOLEAN DEFAULT FALSE,
    id_country INT,
    PRIMARY KEY (id_city),
    FOREIGN KEY (id_country) REFERENCES countries(id_country)
);

-- Inserting Data
INSERT INTO continents (name) VALUES
('Africa');

INSERT INTO languages (name) VALUES
('Arabic'),
('Swahili'),
('Zulu'),
('Amharic'),
('Hausa'),
('Yoruba'),
('Somali'),
('Tamazight');

INSERT INTO countries (name, population, shortname, id_language, id_continent, x, y, description, image_url) VALUES
('Egypt', 104000000, 'eg', 1, 1, 60, 10, 'Egypt, the cradle of ancient civilization, boasts iconic monuments like the Pyramids of Giza. The country is also known for the Nile River, a lifeline for agriculture and culture. Modern Egypt combines a vibrant heritage with bustling urban centers.', 'https://encrypted-tbn1.gstatic.com/licensed-image?q=tbn:ANd9GcSI6KMeAlSgUZdSwLjKWISueLD7uGfQF1J5IVm-XplAfDH-F2rSTnNF9GUfTUXq5HmsoUX-LOsBLDZLscitF0HiEzQ5HhIpV5FIWh0fog'),
('Kenya', 53771296, 'ke', 2, 1, 73, 48, 'Kenya is famous for its breathtaking safaris and wildlife, including the Big Five. The Great Rift Valley and Mount Kenya showcase stunning landscapes. The capital, Nairobi, is a hub for culture and economic activity.', 'https://images.goway.com/production/hero_image/shutterstock_2224170519.jpg'),
('South Africa', 59308690, 'za', 3, 1, 55, 90, 'South Africa offers a diverse landscape from beaches to mountains. It is renowned for its rich history, including Nelson Mandela\'s legacy. Cape Town and Johannesburg blend modernity with cultural heritage.', 'https://static.independent.co.uk/2022/04/01/16/iStock-477451698.jpg'),
('Ethiopia', 123379000, 'et', 4, 1, 74, 35, 'Ethiopia, the land of origins, is celebrated for its ancient culture and landmarks like Lalibela churches. Coffee, a global favorite, traces its roots here. Addis Ababa serves as the vibrant capital city.', 'https://www.originaltravel.co.uk/img/mag/201602/istock-163639070bodyimage.jpg'),
('Nigeria', 211400708, 'ng', 5, 1, 37, 35, 'Nigeria, Africa\'s most populous country, is rich in culture and resources. It is known for Nollywood, its booming film industry. Lagos, the economic powerhouse, thrives as a bustling urban hub.', 'https://cdn.punchng.com/wp-content/uploads/2023/08/29134058/Best-city-to-live-work-in-Africa.jpg'),
('Somalia', 16900000, 'so', 7, 1, 85, 35, 'Somalia, with its extensive coastline, has a history tied to maritime trade. The capital, Mogadishu, reflects resilience and cultural heritage. Known for frankincense, it plays a key role in global trade.', 'https://www.meltingpot.org/app/uploads/2022/10/IMG_3935-scaled.jpeg'),
('Morocco', 37600000, 'ma', 8, 1, 15, 6, 'Morocco, where tradition meets modernity, is known for its bustling souks and historic cities like Marrakesh. The Atlas Mountains and Sahara Desert showcase stunning natural beauty. Rabat is the capital.', 'https://www.ilove-marrakech.com/blog/wp-content/uploads/2024/05/Is-Alcohol-Legal-in-Morocco.png'),
('Algeria', 44900000, 'dz', 1, 1, 30, 10, 'Algeria, the largest African country, features vast desert landscapes and Roman ruins. Its capital, Algiers, combines Mediterranean charm with historical significance. The Sahara dominates much of the land.', 'https://www.travelguide.net/media/c/dz.jpeg'),
('Tanzania', 63000000, 'tz', 2, 1, 70, 58, 'Tanzania is famed for Mount Kilimanjaro and Serengeti National Park. Zanzibar, with its pristine beaches, is a tropical paradise. Dar es Salaam, the largest city, is a cultural and economic center.', 'https://weareworldchallenge.com/uk/wp-content/uploads/sites/11/2021/03/northern-tanzania-1.jpg'),
('Wakando', 192028, 'eg', 1, 1, 60, 10, 'Wakando, a fictional country, is imagined as a peaceful land with lush greenery. It symbolizes harmony between tradition and innovation. Its people cherish their rich cultural and natural heritage.', 'https://static1.cbrimages.com/wordpress/wp-content/uploads/2020/03/Wakanda-FI-Cropped.png');

INSERT INTO cities (name, is_capital, id_country) VALUES
('Cairo', 1, 1),
('Alexandria', 0, 1),
('Giza', 0, 1),
('Nairobi', 1, 2),
('Mombasa', 0, 2),
('Kisumu', 0, 2),
('Pretoria', 1, 3),
('Cape Town', 0, 3),
('Johannesburg', 0, 3),
('Addis Ababa', 1, 4),
('Dire Dawa', 0, 4),
('Gondar', 0, 4),
('Abuja', 1, 5),
('Lagos', 0, 5),
('Kano', 0, 5),
('Mogadishu', 1, 6),
('Hargeisa', 0, 6),
('Bosaso', 0, 6),
('Rabat', 1, 7),
('Casablanca', 0, 7),
('Marrakech', 0, 7),
('Fes', 0, 7),
('Tangier', 0, 7),
('Agadir', 0, 7),
('Chefchaouen', 0, 7),
('Ouarzazate', 0, 7),
('Algiers', 1, 8),
('Oran', 0, 8),
('Constantine', 0, 8),
('Dodoma', 1, 9),
('Dar es Salaam', 0, 9),
('Arusha', 0, 9),
('Mbeya', 0, 9),
('Mwanza', 0, 9),
('Tanga', 0, 9),
('Morogoro', 0, 9);


-- Update country data
UPDATE countries
SET countries.name = "Wakanda"
WHERE countries.name = "Wakando";

-- Delete a country with its cities
DELETE FROM cities
WHERE cities.id_country = (SELECT id_country FROM countries WHERE countries.name = "Wakanda");
DELETE FROM countries
WHERE countries.name = "Wakanda"; 

-- Show list of the countries with their information
SELECT
    countries.name AS country_name,
    cities.name AS capital,
    languages.name AS language,
    countries.population AS population,
    continents.name AS continent
FROM
    countries
JOIN
    cities
    ON countries.id_country = cities.id_country
    AND cities.is_capital = 1
JOIN
    languages
    ON countries.id_language = languages.id_language
JOIN 
    continents
    ON countries.id_continent = continents.id_continent
WHERE
    continents.name = 'Africa';
