<?php

use App\Book;

class BookTest extends TestCase
{
    /**
     * api/external-books [GET]
     */
    public function testShouldReturnAllBooksFromIceAndFire(){
        $this->get("api/external-books", []);
        $this->seeStatusCode(200);
        $this->seeJson([
            'status_code' => 200,
            'status' => 'success'
        ]);
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'name',
                    'isbn',
                    'authors',
                    'country',
                    'number_of_pages',
                    'publisher',
                    'release_date'
                ]
            ]
        ]);
    }

    /**
     * api/external-books [GET] with name query parameter
     */
    public function testShouldReturnBooksFromIceAndFireWithQuery(){
        $this->get("api/external-books?name=A Game of Thrones", []);
        $this->seeStatusCode(200);
        $this->seeJson([
            'status_code' => 200,
            'status' => 'success'
        ]);
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'name',
                    'isbn',
                    'authors',
                    'country',
                    'number_of_pages',
                    'publisher',
                    'release_date'
                ]
            ]
        ]);
    }

    /**
     * api/v1/books [POST]
     */
    public function testShouldCreateBook(){
        Book::truncate();
        $book = [
            "name"              => "Aureole Test PHP new",
            "isbn"              => "098-8798992343",
            "country"           => "Australia",
            "authors"           => ["Omonoba E. Agatha", "Martins E. Emmanuel"],
            "number_of_pages"   => 321,
            "publisher"         => "Christopher Developer",
            "release_date"      => "1947-09-30"
        ];

        $this->post("api/v1/books", $book, []);
        $this->seeStatusCode(201);
        $this->seeJson([
            'status_code' => 201,
            'status' => 'success'
        ]);
        $this->seeJsonStructure([
            'data' => [
                'book' => [
                    "name",
                    "isbn",
                    "authors",
                    "country",
                    "number_of_pages",
                    "publisher",
                    "release_date"
                ]
            ]
        ]);
    }

    /**
     * api/v1/books [GET]
     */
    public function testShouldReturnAllBooks(){
        $this->get("api/v1/books", []);
        $this->seeStatusCode(200);
        $this->seeJson([
            'status_code' => 200,
            'status' => 'success'
        ]);
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'isbn',
                    'authors',
                    'country',
                    'number_of_pages',
                    'publisher',
                    'release_date'
                ]
            ]
        ]);
    }

    /**
     * api/v1/books [GET] with some query parameter
     */
    public function testShouldReturnAllBooksWithQuery(){
        $this->get("api/v1/books?name=Aureole Test PHP new&country=Australi", []);
        $this->seeStatusCode(200);
        $this->seeJson([
            'status_code' => 200,
            'status' => 'success'
        ]);
        $this->seeJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'isbn',
                    'authors',
                    'country',
                    'number_of_pages',
                    'publisher',
                    'release_date'
                ]
            ]
        ]);
    }

    /**
     * api/v1/books/id [GET]
     */
    public function testShouldReturnBook() {
        $randomBookId = 1;
        $this->get("api/v1/books/".$randomBookId, []);
        $this->seeStatusCode(200);
        $this->seeJson([
            'status_code' => 200,
            'status' => 'success'
        ]);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'id',
                    'name',
                    'isbn',
                    'authors',
                    'country',
                    'number_of_pages',
                    'publisher',
                    'release_date'
                ]
            ]    
        );
    }

    /**
     * api/v1/books/id [GET] 404 for invalid BookId
     */
    public function testShouldReturnBook404() {
        $randomBookId = 3290;
        $this->get("api/v1/books/".$randomBookId, []);
        $this->seeStatusCode(404);
        $this->seeJsonEquals([
            'status_code' => 404,
            'status' => 'Book not found'
        ]);
    }
    
    /**
     * api/v1/books/id [PATCH]
     */
    public function testShouldUpdateBook(){
        $randomBookId = 1;
        $book = [
            "name"       => "Aureole Test PHP 2 New",
            "isbn"       => "098-8798992343",
            "country"    => "Toronto"
        ];
        $this->patch("api/v1/books/" . $randomBookId, $book, []);
        $this->seeStatusCode(200);
        $this->seeJson([
            'status_code' => 200,
            'status' => 'success'
        ]);
        $this->seeJsonStructure(
            ['data' =>
                [
                    'id',
                    'name',
                    'isbn',
                    'authors',
                    'country',
                    'number_of_pages',
                    'publisher',
                    'release_date'
                ]
            ]    
        );
    }

    /**
     * api/v1/books/id [PATCH] for invalid BookId
     */
    public function testShouldUpdateBook404(){
        $randomBookId = 3290;
        $book = [
            "name"       => "Aureole Test PHP 2 New",
            "isbn"       => "098-8798992343",
            "country"    => "Toronto"
        ];
        $this->patch("api/v1/books/" . $randomBookId, $book, []);
        $this->seeStatusCode(404);
        $this->seeJsonEquals([
            'status_code' => 404,
            'status' => 'Book not found'
        ]);
    }

    /**
     * api/v1/books/id [DELETE]
     */
    public function testShouldDeleteBook(){
        $randomBookId = 1;
        $this->delete("api/v1/books/".$randomBookId, [], []);
        $this->seeStatusCode(200);
        $this->seeJson([
            'status_code' => 204,
            'status' => 'success',
            'data' => []
        ]);
        $this->seeJsonStructure(
            [
                'message'
            ]    
        );
    }

    /**
     * api/v1/books/id [PATCH] for invalid BookId
     */
    public function testShouldDeleteBook404(){
        $randomBookId = 1;
        $this->delete("api/v1/books/" . $randomBookId, []);
        $this->seeStatusCode(404);
        $this->seeJsonEquals([
            'status_code' => 404,
            'status' => 'Book not found'
        ]);
    }

}