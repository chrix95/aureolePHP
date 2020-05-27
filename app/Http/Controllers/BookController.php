<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function __construct(UtilityController $utility) {
        $this->utility = $utility;
    }

    public function index (Request $request) {
        if ($request->query()) {
            // define all the search query parameter (if available)
            $options = $this->utility->checkQueryParams($request);
            if ($request->query('release_date')) {
                $books = Book::where($options)->date($request->query('release_date'))->get();
            } else {
                $books = Book::where($options)->get();
            }
        } else {
            // return al books 
            $books = Book::all();
        }
        return response()->json([
            'status_code'   =>  200,
            'status'        =>  'success',
            'data'          =>  $books
        ], 200);
    }

    public function store (Request $request) {
        $book = array(
            'name'              =>  htmlentities(strip_tags(trim($request->name))),
            'isbn'              =>  tmlentities(strip_tags(trim($request->isbn))),
            'authors'           =>  tmlentities(strip_tags(trim($request->authors))),
            'country'           =>  tmlentities(strip_tags(trim($request->country))),
            'number_of_pages'   =>  tmlentities(strip_tags(trim($request->number_of_pages))),
            'publisher'         =>  tmlentities(strip_tags(trim($request->publisher))),
            'release_date'      =>  tmlentities(strip_tags(trim($request->release_date)))
        );
        $validator = \Validator::make($book, [
            'name'              =>  'required|string|max:191',
            'isbn'              =>  'required|string|',
            'authors'           =>  'required|array|',
            'country'           =>  'required|string|max:191',
            'number_of_pages'   =>  'required|numeric',
            'publisher'         =>  'required|string|max:191',
            'release_date'      =>  'required|date|max:191'
        ]);
        if($validator->fails()) {
            $response = $validator->errors();
            return response()->json([
                'status_code'   =>  406,
                'status'        =>  'Validation Error',
            ], 404);
        }
        Book::create($book);
        return response()->json([
            'status_code'   =>  201,
            'status'        =>  'success',
            'data'          =>  [ 'book' => $book ]
        ], 200);
    }

    public function show ($id) {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'status_code'   =>  404,
                'status'        =>  'Book not found',
            ], 404);
        }
        return response()->json([
            'status_code'   =>  200,
            'status'        =>  'success',
            'data'          =>  $book
        ], 200);
    }

    public function destroy ($id) {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'status_code'   =>  404,
                'status'        =>  'Book not found',
            ], 404);
        }
        $book_name = $book->name;
        $book->delete();
        return response()->json([
            'status_code'   =>  204,
            'status'        =>  'success',
            'message'       =>  'The book ' . $book_name . ' was deleted successfully',
            'data'          =>  []
        ], 200);
    }

    public function update (Request $request, $id) {
        $book = Book::find($id);
        if (!$book) {
            return response()->json([
                'status_code'   =>  404,
                'status'        =>  'Book not found',
            ], 404);
        } else {
            $data = array(
                'name'              =>  $request->name ? htmlentities(strip_tags(trim($request->name))): $book->name,
                'isbn'              =>  $request->isbn ? htmlentities(strip_tags(trim($request->isbn))) : $book->isbn,
                'authors'           =>  $request->authors ? $request->authors : $book->authors,
                'country'           =>  $request->country ? htmlentities(strip_tags(trim($request->country))) : $book->country,
                'number_of_pages'   =>  $request->number_of_pages ? htmlentities(strip_tags(trim($request->number_of_pages))) : $book->number_of_pages,
                'publisher'         =>  $request->publisher ? htmlentities(strip_tags(trim($request->publisher))) : $book->publisher,
                'release_date'      =>  $request->release_date ? htmlentities(strip_tags(trim($request->release_date))) : $book->release_date
            );
            $validator = \Validator::make($data, [
                'name'              =>  'string|max:191',
                'isbn'              =>  'string|',
                'authors'           =>  'array|',
                'country'           =>  'string|max:191',
                'number_of_pages'   =>  'numeric',
                'publisher'         =>  'string|max:191',
                'release_date'      =>  'date|max:191'
            ]);
            if($validator->fails()) {
                $response = $validator->errors();
                return response()->json([
                    'status_code'   =>  406,
                    'status'        =>  'Validation Error',
                ], 404);
            }
            $book_name = $book->name;
            $book->update($data);
            return response()->json([
                'status_code'   =>  200,
                'status'        =>  'success',
                'message'       =>  'The book ' . $book_name . ' was updated successfully',
                'data'          =>  $book
            ], 200);
        }
    }

    public function externalBooks (Request $request) {
        $url = "https://www.anapioficeandfire.com/api/books";
        if ($request->query('name')) { 
            $url = $url . "?name=" . urlencode($request->query('name'));
        }
        $response = $this->utility->getExternalBooks($url);
        if ($response['status'] == '-1') {
            return response()->json([
                'status_code'   =>  500,
                'status'        =>  $response['message'],
                'data'          =>  []
            ]);
        }
        return response()->json([
            'status_code'   =>  200,
            'status'        =>  'success',
            'data'          =>  $response['data']
        ]);
    }

}
