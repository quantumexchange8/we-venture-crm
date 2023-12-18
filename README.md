

## Prerequisites

-   Require Node.js
-   Require Apache & MySQL in XAMPP
-   Run $ npm install -D tailwindcss postcss autoprefixer
-   Run $ npx tailwindcss init -p
-   Run $ npm install tw-elements
-   Run $ npm install flowbite

## Run environment

-   Copy and Paste new .env file
-   Insert User Name and Password
-   Start environment with $ npm run dev
-   Then run $ php artisan serve
-   php artisan migrate --seed

## Debug / Clear Cache

-   composer update --no-scripts
-   php artisan key:generate
-   php artisan jwt:secret
-   php artisan clear-compiled
-   php artisan cache:clear
-   php artisan config:clear
-   php artisan route:clear
-   php artisan view:clear
-   composer dump-autoload
-   php artisan optimize
