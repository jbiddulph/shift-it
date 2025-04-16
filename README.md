![ShiftList Banner](https://res.cloudinary.com/dagb1kdy2/image/upload/v1744305713/snro22zljepf5fiowtnt.png)

# ShiftList

ShiftList is a task management application built with Laravel (backend), Vue (frontend) and Inertia (the glue - no api needed) designed to help you organize and shift your to-do list efficiently.

## Installation


Install Herd if you don't have it already:

Download from the official site: https://herd.laravel.com
Or install via Homebrew: brew install --cask herd


After installing Herd:

Launch the Herd application
Complete the initial setup process
It will configure your system with the necessary services


Navigate to your project directory in the terminal and run:
php artisan herd:link
This will link your project to Herd's Nginx server
Your project should now be accessible at http://shift-it.test (assuming your project folder name is "shift-it")
Make sure your database configuration in .env matches what Herd is using (by default, it would be MySQL with username "root" and an empty password)
Run your migrations and seeders:
php artisan migrate
php artisan db:seed

Install and build your frontend assets:
npm install
npm run build