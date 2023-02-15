## Configuration
First step is clone this repository. 
Create .env file with your configuration.
Then, run command below
```
composer update
```
Generate key
```
php artisan key:generate
```
Build assets
```
npm install
npm run build
```
Optimize config and route
```
php artisan optimize
```
Migrate tables
```
php artisan migrate
```
Run the service
```
php artisan serve
```
