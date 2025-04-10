![ShiftList Banner](https://res.cloudinary.com/dagb1kdy2/image/upload/v1744305713/snro22zljepf5fiowtnt.png)

# ShiftList

ShiftList is a task management application built with Laravel (backend), Vue (frontend) and Inertia (the glue - no api needed) designed to help you organize and shift your to-do list efficiently.

## Installation

Follow these steps to set up the application locally:

1. **Clone the repository**:
   ```bash
   git clone https://github.com/jbiddulph/shift-it.git
   cd shift-it
   ```

2. **Install dependencies**:
   - Install PHP dependencies using Composer:
     ```bash
     composer install
     ```
   - Install JavaScript dependencies using npm:
     ```bash
     npm install
     ```

3. **Set up the environment**:
   - Copy the `.env.example` file to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Generate the application key:
     ```bash
     php artisan key:generate
     ```
   - Configure your database settings in the `.env` file.

4. **Run database migrations**:
   ```bash
   php artisan migrate
   ```

## Running the Application

1. **Start the development server**:
   ```bash
   php artisan serve
   ```

2. **Compile assets**:
   - For development:
     ```bash
     npm run dev
     ```
   - For production:
     ```bash
     npm run build
     ```

3. Open your browser and navigate to `http://localhost:8000`.

## Features

- User authentication (login/register).
- Task management with a clean and intuitive interface.
- Dark mode support.

## Contributing

Feel free to submit issues or pull requests to improve the application.

## License

This project is open-source and available under the [MIT License](LICENSE).
