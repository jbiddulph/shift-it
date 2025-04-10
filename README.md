# ShiftList

<p align="center">
  <svg xmlns="http://www.w3.org/2000/svg" color="#ffffff" width="64" height="58">
    <path d="M19 3h-1a7.973 7.973 0 0 0-6 2.727A7.973 7.973 0 0 0 6 3H5V0L0 5.113 5 10V7h1a4 4 0 0 1 4 4v11h4V11a4 4 0 0 1 4-4h1v3l5-4.887L19 0z" fill="#d71964"/>
  </svg>
</p>

ShiftList is a task management application designed to help you organize and shift your to-do list efficiently.

## Installation

Follow these steps to set up the application locally:

1. **Clone the repository**:
   ```bash
   git clone https://github.com/your-username/shift-it.git
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
