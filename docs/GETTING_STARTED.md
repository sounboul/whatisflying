# Getting started

## Prerequisites

### FontAwesome

This application uses [FontAwesome](https://fontawesome.com/) pro icons, because we think these icons fit better into
the app theme than the free icons.

If you have a FontAwesome Pro license, you just need to set the *FONTAWESOME_NPM_AUTH_TOKEN* environment variable before
installing JS dependencies.

If you don't have a FontAwesome Pro license, you can skip the installation of the pro icons by appending the
`--no-optional` flag to the `npm install` command. When building the assets, the free icons will be automatically used
instead of the paid ones.

### Development

This application requires Docker and Docker Compose to run the development environment. Please refer to the installation
instructions for your operating system:

* [Install Docker engine](https://docs.docker.com/engine/install/)
* [Install Docker Compose](https://docs.docker.com/compose/install/)

## Configuring the application

To run this application, you will need to set some environment variables with API keys and other things.

### OpenSky Network API key

* Go to [OpenSky Network](https://opensky-network.org/) and sign up.
* Generate an HTTP [Basic access authentication](https://en.wikipedia.org/wiki/Basic_access_authentication) token with
  your credentials.
* Set the `OPENSKY_NETWORK_API_KEY` environment variable with the generated token.

> ⚠️ **Warning**
>
> We strongly suggest not to use any sensitive information or any credentials used elsewhere for this step, as the
> generated key can be very easily reversed and leak this information.

### Open Weather Map API key

* Go to [Open Weather Map](https://openweathermap.org/) and sign up.
* Go to the [API keys](https://home.openweathermap.org/api_keys) section of your user dashboard to generate an API key.
* Set the `OPEN_WEATHER_MAP_API_KEY` environment variable with the API key.

### Sentry API key

* Go to [Sentry](https://sentry.io/) and sign up.
* Create a project and copy the generated DSN.
* Set the `SENTRY_DSN` environment variable with the DSN.

> ℹ️ **Tip**
>
> If you do not plan on using Sentry, you can safely leave this step aside.

### Email transport

You must configure the transport used by the Symfony mailer component to be able to send emails as needed. See
the [transport setup](https://symfony.com/doc/current/mailer.html#transport-setup) section of the Symfony mailer
component documentation for a list of available transports.

Then set the `MAILER_DSN` environment according to the transport you have chosen and your credentials.

## Deploying the application

### Development

Clone the repository:

```bash
git clone git@github.com:jbroutier/whatisflying.git
```

Navigate to the newly created directory:

```bash
cd whatisflying
```

Start Docker services:

```bash
docker-compose up
```

Install PHP dependencies:

```bash
docker-compose exec php composer install
```

Create the database and apply migrations:

```bash
docker-compose exec php php bin/console doctrine:schema:create --no-interaction
docker-compose exec php php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
```

Create a user with administrator privileges:

```bash
php bin/console user:create <email> <username> <password> --admin
```

Install JS dependencies:

```bash
npm install
```

> ℹ️ **Tip**
>
> You can skip the installation of optional FontAwesome pro icons by appending the `--no-optional` flag to the command.


Build the assets:

```bash
npm run build:prod
```

### Production

Navigate to the nginx root directory:

```bash
cd /usr/share/nginx/html
```

> ⚠️ **Warning**
>
> Make sure the nginx root directory is empty before continuing, otherwise you will receive an error at the next step.

Clone the repository:

```bash
git clone git@github.com:jbroutier/whatisflying.git .
```

Create directories:

```bash
mkdir -p /usr/share/nginx/html/{public/cache,public/upload,var}
```

Set file permissions:

```bash
setfacl -dR -m u:www-data:rwX -m u:root:rwX /usr/share/nginx/html/{config/jwt,public/upload,var}
setfacl -R -m u:www-data:rwX -m u:root:rwX /usr/share/nginx/html/{config/jwt,public/upload,var}
```

Install PHP dependencies:

```bash
composer install --classmap-authoritative --no-dev --no-interaction
```

Create the database and apply migrations:

```bash
php bin/console doctrine:database:create --no-interaction
php bin/console doctrine:schema:create --no-interaction
php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
```

Generate private & public key pair used to encode JWT tokens:

```bash
openssl genpkey -out /usr/share/nginx/html/config/jwt/private.pem \
  -pass pass:<password> \
  -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
openssl pkey -in /usr/share/nginx/html/config/jwt/private.pem \
  -passin pass:<password> \
  -out /usr/share/nginx/html/config/jwt/public.pem -pubout
```

Create a user with administrator privileges:

```bash
php bin/console user:create <email> <username> <password> --admin
```

Install JS dependencies:

```bash
npm install
```

> ℹ️ **Tip**
>
> You can skip the installation of optional FontAwesome pro icons by appending the `--no-optional` flag to the command.

Build the assets:

```bash
npm run build:prod
```

Dump environment variables:

```bash
composer dump-env prod
```

Clear the cache:

```bash
php bin/console cache:clear
```

## Importing the database

> ⚠️ **Warning**
>
> Since some entities depends on other ones during import, it's important to respect the import order.
> Otherwise the application will still work but imported data will be incomplete.

Navigate to the nginx root directory:

```bash
cd /usr/share/nginx/html
```

Clone the database:

```bash
git clone git@github.com:jbroutier/whatisflying-db.git database --depth 1
```

Import aircraft types:

```bash
php bin/console import:aircraft-types database/data/aircraft_types.csv
php bin/console import:aircraft-types-pictures database/data/aircraft_types_pictures.csv
```

Import aircraft models:

```bash
php bin/console import:aircraft-models database/data/aircraft_models.csv
```

Import airlines:

```bash
php bin/console import:airlines database/data/airlines.csv
php bin/console import:airlines-logos database/data/airlines_logos.csv
php bin/console import:airlines-pictures database/data/airlines_pictures.csv
```

Import aircraft:

```bash
php bin/console import:aircraft database/data/aircraft.csv
find database/data/aircraft -type f -iname "*.csv" -exec php bin/console import:aircraft {} \;
php bin/console import:aircraft-pictures database/data/aircraft_pictures.csv
```

Import flight information regions:

```bash
php bin/console import:firs database/data/firs.csv
```

Import airports:

```bash
php bin/console import:airports database/data/airports.csv
php bin/console import:airports-datasets database/data/airports_datasets.csv
php bin/console import:airports-frequencies database/data/airports_frequencies.csv
php bin/console import:airports-runways database/data/airports_runways.csv
```

Import navaids:

```bash
find database/data/navaids -type f -iname "*.csv" -exec php bin/console import:navaids {} \;
```

Import fixes/waypoints:

```bash
php bin/console import:fixes database/data/fixes.csv
```

Import flights:

```bash
php bin/console import:flights database/data/flights.csv
```

Dump the sitemap:

```bash
php bin/console presta:sitemaps:dump --gzip
```

> ℹ️ **Tip**
>
> You can dump only a specific section of the sitemap by appending the `--section <section_name>` parameter to the command.
> Supported sections are as follows: `aircraft`, `aircraft_types`, `airlines`, `airports`, `flights` and `navaids`.
