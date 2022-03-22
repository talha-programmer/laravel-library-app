## Running the code
1. Duplicate the ".env.example" file and rename as ".env"
2. Create a MySQL database and save the credentials inside .env file
3. Run these commands:
   * composer install
   * php artisan key:generate
   * php artisan migrate --seed
   * npm install
   * npm run dev
   * php artisan serve

4. Now, the application will be running at http://localhost:8000