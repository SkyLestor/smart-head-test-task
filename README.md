# Smart Head Test Task API

A RESTful API application for managing a movie catalog, built with Laravel 11.

## Installation and Setup

Follow these steps to set up and run the project locally.

### 1. Clone the repository

```bash
git clone <repository-url>
cd smart-head-test-task
```

### 2. Install dependencies

```bash
composer install
```

### 3. Environment Configuration

Copy the example environment file and generate the application key.

```bash
cp .env.example .env
php artisan key:generate
```

Open the `.env` file and configure your database settings (DB_DATABASE, DB_USERNAME, DB_PASSWORD).

### 4. Database Migration and Seeding

Run the migrations to create the database tables and seed them with default data (genres and test movies).

```bash
php artisan migrate --seed
```

### 5. Link Storage

Create a symbolic link to make uploaded files accessible from the web.

```bash
php artisan storage:link
```

### 6. Run the Server

Start the local development server.

```bash
php artisan serve
```

The API will be available at `http://127.0.0.1:8000/api`.

---

## API Documentation

### Genres

#### List All Genres

Returns a list of all available genres.

* **URL:** `/api/genres`
* **Method:** `GET`
* **Success Response:**

```json
{
    "data": [
        {
            "id": 1,
            "name": "Horror"
        },
        {
            "id": 2,
            "name": "Sci-Fi"
        }
    ]
}
```

#### Get Genre Details

Returns a paginated list of movies belonging to a specific genre.

* **URL:** `/api/genres/{id}`
* **Method:** `GET`
* **Success Response:**

```json
{
    "data": [
        {
            "id": 5,
            "title": "Movie Title",
            "poster_url": "https://placehold.co/400x600/2c3e50/ffffff?text=Movie+Poster",
            "is_published": true,
            "genres": []
        }
    ],
    "links": {
        ...
    },
    "meta": {
        ...
    }
}
```

---

### Movies

#### List All Movies

Returns a paginated list of movies.

* **URL:** `/api/movies`
* **Method:** `GET`
* **Success Response:**

```json
{
    "data": [
        {
            "id": 1,
            "title": "Movie Title",
            "poster_url": "https://placehold.co/400x600/2c3e50/ffffff?text=Movie+Poster",
            "is_published": true,
            "genres": [
                {
                    "id": 1,
                    "name": "Horror"
                }
            ]
        }
    ],
    "links": {
        ...
    },
    "meta": {
        ...
    }
}
```

#### Get Movie Details

Returns details for a single movie.

* **URL:** `/api/movies/{id}`
* **Method:** `GET`
* **Success Response:**

```json
{
    "data": {
        "id": 1,
        "title": "Inception",
        "poster_url": "[http://127.0.0.1:8000/storage/posters/inception.jpg](http://127.0.0.1:8000/storage/posters/inception.jpg)",
        "is_published": true,
        "genres": [
            {
                "id": 1,
                "name": "Sci-Fi"
            },
            {
                "id": 2,
                "name": "Action"
            }
        ]
    }
}
```

#### Create Movie

Creates a new movie.

* **URL:** `/api/movies`
* **Method:** `POST`
* **Content-Type:** `multipart/form-data`
* **Parameters:**
* `title` (required, string): The title of the movie.
* `poster` (optional, file): Image file (jpeg, png, jpg, webp, max 2MB).
* `genres[]` (required, array): Array of genre IDs.


* **Request Example (Form Data):**
* `title`: "Interstellar"
* `genres[]`: 2
* `genres[]`: 3
* `poster`: (Binary File)


* **Success Response (201 Created):**

```json
{
    "data": {
        "id": 2,
        "title": "Interstellar",
        "poster_url": "[http://127.0.0.1:8000/storage/posters/hash.jpg](http://127.0.0.1:8000/storage/posters/hash.jpg)",
        "is_published": false,
        "genres": [
            {
                "id": 2,
                "name": "Sci-Fi"
            },
            {
                "id": 3,
                "name": "Thriller"
            }
        ]
    }
}
```

#### Update Movie

Updates an existing movie.

* **URL:** `/api/movies/{id}`
* **Method:** `PUT` (or `POST` with `_method=PUT` if uploading a file)
* **Content-Type:** `application/x-www-form-urlencoded` or `multipart/form-data`
* **Parameters:**
* `title` (optional, string)
* `poster` (optional, file)
* `genres[]` (optional, array)


* **Request Body Example (JSON):**

```json
{
    "title": "Interstellar (Remastered)",
    "genres": [
        2,
        3
    ]
}
```

* **Success Response:**

```json
{
    "data": {
        "id": 2,
        "title": "Interstellar (Remastered)",
        "poster_url": "...",
        "is_published": false,
        "genres": [
            ...
        ]
    }
}
```

#### Publish / Unpublish Movie

Toggles the publication status of a movie.

* **URL:** `/api/movies/{id}/publish`
* **Method:** `PATCH`
* **Success Response:**

```json
{
    "data": {
        "id": 2,
        "title": "Interstellar",
        "poster_url": "...",
        "is_published": true,
        "genres": [
            ...
        ]
    }
}
```

#### Delete Movie

Removes a movie from the database.

* **URL:** `/api/movies/{id}`
* **Method:** `DELETE`
* **Success Response (200 OK):**

```json
{
    "message": "Movie deleted successfully"
}
```
