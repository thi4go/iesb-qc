# Site Exame da OAB

Compile assets:
	(npm run dev) ou (npm run watch)

To include new .scss file, please, create it into the "styles/components" folder, and do not forget to import it on "main.scss"

-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

##Now you need to use Docker.

> Docker for Laravel 5.4 (Node, Postgres, PHP7.1 and Nginx)

## How to run

Make sure you have already installed [Docker](https://www.docker.com).

```bash
# Start Laravel application (You can access application through http://localhost)
./develop up -d && ./develop composer install
```
## `develop` Helper
```bash
# Run artisan command
./develop art [command]

# Run composer
./develop composer [command]

# Run NPM commands
./develop npm [command]

# Run tests
./develop test [command]
./develop t [command]

# Run Docker Compose commands
./develop [command]
```