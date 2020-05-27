# Aureole API project setup
This project is build on a PHP framework Lumen (The stunningly fast micro-framework by Laravel.)

## Project setup
1. Install wampserver or xamp on your computer. The project uses PHP >= 7.2
2. Clone the project into your local directory (www for wampserver users || htdocs for xamp users)
3. Change into the directory using your cli
4. Install the required composer packages and dependencies for the project using the code below
```
composer install
```
5. After installation is complete, you need to duplicate the `.env.example` file and rename to `.env` and set your configurations
DB_DATABASE=DATABASE_NAME <br>
DB_USERNAME=DATABASE_USERNAME <br>
DB_PASSWORD=DATABASE_PASSWORD <br>
DB_CONNECTION=mysql <br>
DB_HOST=127.0.0.1 <br>
Don't forget to run `php artisan key:generate` to generate a new key for your application
6. Run `php artisan migrate` to migrate the create the `book` table into your database
7. Open your command line and change into your project directory

### Serving your application
We can use the built-in PHP development server code below:
```
php -S localhost:8000 -t public
```

### Available endpoints and payload
- Returns an array of books from IceAndFire API and returns an empty array of no result found. Also you can use the name query parameter to search for a book on IceAndFire API <br>
``` 
GET http://localhost:8000/api/external-books?name=:nameOfABook 
```
sample response
```
{
    "status_code": 200,
    "status": "success",
    "data": [
        {
            "name": "The Hedge Knight",
            "isbn": "978-0976401100",
            "authors": [
                "George R. R. Martin"
            ],
            "number_of_pages": 164,
            "publisher": "Dabel Brothers Publishing",
            "country": "United States",
            "release_date": "2005-03-09"
        },
        {
            "name": "A Storm of Swords",
            "isbn": "978-0553106633",
            "authors": [
                "George R. R. Martin"
            ],
            "number_of_pages": 992,
            "publisher": "Bantam Books",
            "country": "United States",
            "release_date": "2000-10-31"
        }
    ]
}
```

- Create a book on the local machine
``` 
POST http://localhost:8000/api/v1/books 
```
sample payload
```
{
	"name": "Drifted Apart 23",
	"isbn": "098-012345678",
	"country": "Nigeria",
	"authors": ["Eddy R. Charles", "Sylvester G. O."],
	"number_of_pages": 234,
	"publisher": "Simi Enisu",
	"release_date": "2020-04-23"
}
```
sample response
```
{
    "status_code": 201,
    "status": "success",
    "data": {
        "book": {
            "name": "Drifted Apart 23",
            "isbn": "098-012345678",
            "country": "Nigeria",
            "authors": [
                "Eddy R. Charles",
                "Sylvester G. O."
            ],
            "number_of_pages": 234,
            "publisher": "Simi Enisu",
            "release_date": "2020-04-23"
        }
    }
}
```

- Read all books on the local machine
``` 
GET http://localhost:8000/api/v1/books 
```
sample response
```
{
    "status_code": 200,
    "status": "success",
    "data": [
        {
            "id": 27,
            "name": "Drifted Apart 23",
            "isbn": "098-012345678",
            "authors": [
                "Eddy R. Charles",
                "Sylvester G. O."
            ],
            "number_of_pages": 987,
            "publisher": "Simi Enisu",
            "country": "Canada",
            "release_date": "2020-04-23"
        },
        {
            "id": 28,
            "name": "Drifted Apart 23",
            "isbn": "098-012345678",
            "authors": [
                "Eddy R. Charles",
                "Sylvester G. O."
            ],
            "number_of_pages": 234,
            "publisher": "Simi Enisu",
            "country": "Nigeria",
            "release_date": "1990-07-01"
        }
    ]
}
```

- The Read API can be searchable by name (stirng), country(string), publisher(string) and realease date(year, integer). Note: The search query parameter are optional
``` 
GET http://localhost:8000/api/v1/books?name=Drifted Apart 23&country=Nigeria&release_date=1990 
```
sample response
```
{
    "status_code": 200,
    "status": "success",
    "data": [
        {
            "id": 28,
            "name": "Drifted Apart 23",
            "isbn": "098-012345678",
            "authors": [
                "Eddy R. Charles",
                "Sylvester G. O."
            ],
            "number_of_pages": 234,
            "publisher": "Simi Enisu",
            "country": "Nigeria",
            "release_date": "1990-07-01"
        }
    ]
}
```

- Update a book on the local machine. Note: The payload requires you send parameter that are meant to be changed as it ONLY updates the parameter sent in the payload
``` 
PATCH http://localhost:8000/api/v1/books/28 
```
sample payload
```
{
	"name": "Fast & Furious 7",
	"isbn": "098-10982929",
	"country": "Nigeria",
	"authors": ["Eddy R. Charles", "Sylvester G. O."]
}
```
sample response
```
{
    "status_code": 200,
    "status": "success",
    "message": "The book Drifted Apart 23 was updated successfully",
    "data": {
        "id": 28,
        "name": "Fast & Furious 7",
        "isbn": "098-10982929",
        "authors": [
            "Eddy R. Charles", 
            "Sylvester G. O."
        ],
        "number_of_pages": "3293",
        "publisher": "Simi Enisu",
        "country": "Nigeria",
        "release_date": "2020-08-01"
    }
}
```

- Delete a book on the local machine.
``` 
DELETE http://localhost:8000/api/v1/books/28 
```
sample response
```
{
    "status_code": 204,
    "status": "success",
    "message": "The book Fast & Furious 7 was deleted successfully",
    "data": []
}
```

- Show a book on the local machine.
``` 
GET http://localhost:8000/api/v1/books/28 
```
sample response
```
{
    "status_code": 200,
    "status": "success",
    "data": {
        "id": 28,
        "name": "Fast & Furious 7",
        "isbn": "098-10982929",
        "authors": [
            "Eddy R. Charles", 
            "Sylvester G. O."
        ],
        "number_of_pages": 3293,
        "publisher": "Simi Enisu",
        "country": "Nigeria",
        "release_date": "2020-08-01"
    }
}
```

### Available endpoints and payload
You can import the postman collection for the project using the <a href="https://www.getpostman.com/collections/cc257a6e18e4ae34f8dc">URL</a>

## Support
For support towards this project, reach me on <a href="tel:2348183780409">+2348183780409</a> or <a href="mailto:engchris95@gmail.com">email</a>.
