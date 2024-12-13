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
    is_showed BOOLEAN DEFAULT TRUE,
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
('Tamazight'),
('Takelondo'),
('Eldien');

INSERT INTO countries (name, population, shortname, id_language, id_continent, x, y, description, image_url) VALUES
('Egypt', 104000000, 'eg', 1, 1, 60, 10, "Egypt, the cradle of ancient civilization, boasts iconic monuments like the Pyramids of Giza.", "https://image.jimcdn.com/app/cms/image/transf/dimension=2080x10000:format=jpg/path/s2217cd0bb1220415/image/i0aa51da086cc095c/version/1695120184/a-towering-view-of-the-great-pyramid-of-giza-with-a-silhouette-of-a-camel-and-its-rider-in-the-foreground.jpg"),
('Kenya', 53771296, 'ke', 2, 1, 73, 48, "Kenya is famous for its breathtaking safaris and wildlife, including the Big Five.", "https://images.goway.com/production/hero_image/shutterstock_2224170519.jpg"),
('South Africa', 59308690, 'za', 3, 1, 55, 90, "South Africa offers a diverse landscape from beaches to mountains.", "https://static.independent.co.uk/2022/04/01/16/iStock-477451698.jpg"),
('Morocco', 37600000, 'ma', 8, 1, 15, 6, "Morocco, where tradition meets modernity, is known for bustling souks and historic cities.", "https://www.ilove-marrakech.com/blog/wp-content/uploads/2024/05/Is-Alcohol-Legal-in-Morocco.png"),
('Ethiopia', 123379000, 'et', 4, 1, 74, 35, "Ethiopia, the land of origins, is celebrated for its ancient culture.", "https://www.originaltravel.co.uk/img/mag/201602/istock-163639070bodyimage.jpg"),
('Nigeria', 211400708, 'ng', 5, 1, 37, 35, "Nigeria, Africa's most populous country, is rich in culture and resources.", "https://cdn.punchng.com/wp-content/uploads/2023/08/29134058/Best-city-to-live-work-in-Africa.jpg"),
('Somalia', 16900000, 'so', 7, 1, 85, 35, 'Somalia, with its extensive coastline, has a history tied to maritime trade. The capital, Mogadishu.', 'https://www.meltingpot.org/app/uploads/2022/10/IMG_3935-scaled.jpeg'),
('Algeria', 44900000, 'dz', 1, 1, 30, 10, 'Algeria, the largest African country, features vast desert landscapes and Roman ruins. Its capital, Algiers.', 'https://www.travelguide.net/media/c/dz.jpeg'),
('Tanzania', 63000000, 'tz', 2, 1, 70, 58, 'Tanzania is famed for Mount Kilimanjaro and Serengeti National Park. Zanzibar, with its pristine beaches.', 'https://weareworldchallenge.com/uk/wp-content/uploads/sites/11/2021/03/northern-tanzania-1.jpg'),
('Ghana', 31072940, 'gh', 6, 1, 25, 36, "Ghana is known for its vibrant culture, beautiful beaches, and historical significance.", "https://www.africanadventures.co.uk/wp-content/uploads/2023/11/Ghana-banner-1440x900-c-center.jpg"),
('Uganda', 45741000, 'ug', 7, 1, 66, 43, "Uganda is known as the 'Pearl of Africa' for its stunning landscapes and wildlife.", "https://www.nkuringosafaris.com/wp-content/uploads/2024/02/beuatiful_uganda_country.jpg"),
('Angola', 32866272, 'ao', 8, 1, 48, 65, "Angola boasts rich natural resources and a dynamic cultural heritage.", "https://lp-cms-production.imgix.net/2019-06/83430407%20.jpg"),
('Senegal', 16743856, 'sn', 9, 1, 9, 26, "Senegal is famous for its vibrant music, beautiful beaches, and historic Goree Island.", "https://www.okayafrica.com/media-library/an-aerial-view-of-goree-island.jpg?id=32247430&width=1200&height=800&quality=85&coordinates=0%2C167%2C0%2C167"),
('Rwanda', 13728499, 'rw', 10, 1, 63, 49, "Rwanda is known as the 'Land of a Thousand Hills' with breathtaking scenery.", "https://www.travelandleisure.com/thmb/eDZBsNz7hzqvVNTsthL7TcAP-k4=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/TAL-header-virunga-mountains-rwanda-ALISTRWANDA0123-049a3b1c218e4358a90015bd09fff7be.jpg");

INSERT INTO cities (name, is_capital, id_country) VALUES
-- Egypt
('Cairo', 1, 1),
('Alexandria', 0, 1),
('Giza', 0, 1),
-- Kenya
('Nairobi', 1, 2),
('Mombasa', 0, 2),
('Kisumu', 0, 2),
-- South Africa
('Pretoria', 1, 3),
('Cape Town', 0, 3),
('Johannesburg', 0, 3),
-- Morocco
('Rabat', 1, 4),
('Casablanca', 0, 4),
('Marrakech', 0, 4),
('Fes', 0, 4),
('Tangier', 0, 4),
('Agadir', 0, 4),
('Chefchaouen', 0, 4),
('Ouarzazate', 0, 4),
-- Ethiopia
('Addis Ababa', 1, 5),
('Dire Dawa', 0, 5),
('Gondar', 0, 5),
-- Nigeria
('Abuja', 1, 6),
('Lagos', 0, 6),
('Kano', 0, 6),
-- Somalia
('Mogadishu', 1, 7),
('Hargeisa', 0, 7),
('Bosaso', 0, 7),
-- Algeria
('Algiers', 1, 8),
('Oran', 0, 8),
('Constantine', 0, 8),
-- Tanzania
('Dodoma', 1, 9),
('Dar es Salaam', 0, 9),
('Arusha', 0, 9),
('Mbeya', 0, 9),
('Mwanza', 0, 9),
('Tanga', 0, 9),
('Morogoro', 0, 9),
-- Ghana
('Accra', 1, 10),
('Kumasi', 0, 10),
('Tamale', 0, 10),
-- Uganda
('Kampala', 1, 11),
('Entebbe', 0, 11),
('Gulu', 0, 11),
-- Angola
('Luanda', 1, 12),
('Lobito', 0, 12),
('Benguela', 0, 12),
-- Senegal
('Dakar', 1, 13),
('Saint-Louis', 0, 13),
('Touba', 0, 13),
-- Rwanda
('Kigali', 1, 14),
('Musanze', 0, 14),
('Gisenyi', 0, 14);


-- Update country data
UPDATE countries
SET countries.name = "Wakanda"
WHERE countries.name = "Wakando";

UPDATE countries
SET countries.is_showed = 0
WHERE countries.name in ("Morocco", "Nigeria", "Egypt", "Tanzania", "South Africa");

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
