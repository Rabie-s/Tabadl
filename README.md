
# TABADL

Exchange Platform is a web application that helps university students share books they no longer need and request books from others. The platform is built using Laravel for the backend, Vue.js for the frontend, JWT for authentication, and TailwindCSS for styling.


## Features

- User authentication (Login, Register) using JWT with admin dashboard.
- User can list a book or request a book.
- Responsive UI using TailwindCSS.
- API-based architecture.
- Users can communicate when requesting a book via the 'Click to Chat using WhatsApp' button.



## Tech Stack

**Client:** Vue.js, TailwindCSS

**Server:** PHP 8.2, Laravel 11

**Database:** MySQL

## Installation

### Backend Setup
Clone the repository:

```bash
  git clone https://github.com/Rabie-s/Tabadl.git
```

Install back-end dependencies:

```bash
  cd Tabadl/back-end
  composer install
```

Copy the environment file and configure the database:

```bash
  cp .env.example .env
```
Generate the application key:

```bash
  php artisan key:generate
```

Generate secret key for jwt:

```bash
  php artisan jwt:secret
```

Run migrations and seed the database:

```bash
  php artisan migrate --seed
```

Serve the application:

```bash
  php artisan serve
```

### Frontend Setup

Install front-end dependencies:

```bash
  cd Tabadl/front-end
  npm install
```

Copy the environment file and configure the app:

```bash
  cp .env.local.example .env.local
```

Run the development server:

```bash
  npm run dev
```

Admin login:

```bash
  email:admin@email.com
  password:admin@email.com
```
    
## Screenshots

![App Screenshot](https://github.com/Rabie-s/Tabadl/blob/master/screenshots/1.png?raw=true)

![App Screenshot](https://github.com/Rabie-s/Tabadl/blob/master/screenshots/2.png?raw=true)

![App Screenshot](https://github.com/Rabie-s/Tabadl/blob/master/screenshots/3.png?raw=true)

![App Screenshot](https://github.com/Rabie-s/Tabadl/blob/master/screenshots/4.png?raw=true)


## License

[MIT](https://choosealicense.com/licenses/mit/)
