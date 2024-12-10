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

INSERT INTO countries (name, population, shortname, id_language, id_continent, x, y) VALUES
('Egypt', 104000000, 'eg', 1, 1, 60, 10),
('Kenya', 53771296, 'ke', 2, 1, 73, 48),
('South Africa', 59308690, 'za', 3, 1, 55, 90),
('Ethiopia', 123379000, 'et', 4, 1, 74, 35),
('Nigeria', 211400708, 'ng', 5, 1, 37, 35),
('Somalia', 16900000, 'so', 7, 1, 85, 35),
('Morocco', 37600000, 'ma', 8, 1, 15, 6),
('Algeria', 44900000, 'dz', 1, 1, 30, 10),
('Tanzania', 63000000, 'tz', 2, 1, 70, 58),
('Wakando', 192028, 'eg', 1, 1, 60, 10);

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
