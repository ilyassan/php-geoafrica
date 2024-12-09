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
    name varchar(20),
    population INT,
    id_language INT,
    id_continent INT,
    PRIMARY KEY (id_country),
    FOREIGN KEY (id_language) REFERENCES languages(id_language),
    FOREIGN KEY (id_continent) REFERENCES continents(id_continent)
);

CREATE TABLE cities (
    id_city INT AUTO_INCREMENT,
    name varchar(20),
    type ENUM("capital", "not capital"),
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

INSERT INTO countries (name, population, id_language, id_continent) VALUES
('Egypte', 104000000, 1, 1),
('Kenya', 53771296, 2, 1),
('South Africa', 59308690, 3, 1),
('Ethiopia', 123379000, 4, 1),
('Nigeria', 211400708, 5, 1),
('Somalia', 16900000, 7, 1),
('Morocco', 37600000, 8, 1),
('Algeria', 44900000, 1, 1),
('Tanzania', 63000000, 2, 1);

INSERT INTO cities (name, type, id_country) VALUES
('Cairo', 'capital', 1),
('Alexandria', 'not capital', 1),
('Giza', 'not capital', 1),
('Nairobi', 'capital', 2),
('Mombasa', 'not capital', 2),
('Kisumu', 'not capital', 2),
('Pretoria', 'capital', 3),
('Cape Town', 'not capital', 3),
('Johannesburg', 'not capital', 3),
('Addis Ababa', 'capital', 4),
('Dire Dawa', 'not capital', 4),
('Gondar', 'not capital', 4),
('Abuja', 'capital', 5),
('Lagos', 'not capital', 5),
('Kano', 'not capital', 5),
('Mogadishu', 'capital', 6),
('Hargeisa', 'not capital', 6),
('Bosaso', 'not capital', 6),
('Rabat', 'capital', 7),
('Casablanca', 'not capital', 7),
('Marrakech', 'not capital', 7),
('Fes', 'not capital', 7),
('Tangier', 'not capital', 7),
('Agadir', 'not capital', 7),
('Chefchaouen', 'not capital', 7),
('Ouarzazate', 'not capital', 7),
('Algiers', 'capital', 8),
('Oran', 'not capital', 8),
('Constantine', 'not capital', 8);


-- Ajouter un pays africain avec ses informations (population, langue, villes).
-- Modifier les détails d'un pays ou d'une ville.
-- Supprimer un pays et toutes ses villes associées.
-- Afficher la liste des pays africains et leurs détails.

-- Update country data
UPDATE countries
SET countries.name = "Egypte"
WHERE countries.name = "Egypt";

-- Delete a country with it cities
DELETE FROM cities
WHERE cities.id_country = (SELECT id_country FROM countries WHERE countries.name = "Egypt");
DELETE FROM countries
WHERE countries.name = "Egypt"; 

-- Show list of the countries with their informations
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
    AND cities.type = 'capital'
JOIN
    languages
    ON countries.id_language = languages.id_language
JOIN 
    continents
    ON countries.id_continent = continents.id_continent
WHERE
    continents.name = 'Africa'
;