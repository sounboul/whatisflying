#!/bin/bash

if [ "${APP_ENV:-dev}" == "prod" ]; then
    PHP="php"
else
    PHP="docker-compose exec php php"
fi

$PHP bin/console import:aircraft-types database/data/aircraft_types.csv
$PHP bin/console import:aircraft-types-pictures database/data/aircraft_types_pictures.csv
$PHP bin/console import:aircraft-models database/data/aircraft_models.csv
$PHP bin/console import:airlines database/data/airlines.csv
$PHP bin/console import:airlines-logos database/data/airlines_logos.csv
$PHP bin/console import:airlines-pictures database/data/airlines_pictures.csv
$PHP bin/console import:aircraft database/data/aircraft.csv

find database/data/aircraft -type f -iname "*.csv" -exec $PHP bin/console import:aircraft {} \;

$PHP bin/console import:aircraft-pictures database/data/aircraft_pictures.csv
$PHP bin/console import:firs database/data/firs.csv
$PHP bin/console import:airports database/data/airports.csv
$PHP bin/console import:airports-datasets database/data/airports_datasets.csv
$PHP bin/console import:airports-frequencies database/data/airports_frequencies.csv
$PHP bin/console import:airports-runways database/data/airports_runways.csv

find database/data/navaids -type f -iname "*.csv" -exec $PHP bin/console import:navaids {} \;

$PHP bin/console import:fixes database/data/fixes.csv
$PHP bin/console import:flights database/data/flights.csv

$PHP bin/console cache:generate

if [ "${APP_ENV:-dev}" == "prod" ]; then
    $PHP bin/console presta:sitemaps:dump --gzip
fi
