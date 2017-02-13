<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\SchoolYearTrait;
use App\Models\Book;
use App\Models\BookUser;
use App\Models\Subject;
use App\Models\User;
use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;
use DB;
use Validator;
use JWTAuth;

/**
 * Librarian endpoints, can be accessed only with role "librarian"
 *
 * @Resource("Librarian", uri="/librarian")
 */
class LibrarianController extends Controller
{
    use Helpers;
    use SchoolYearTrait;

    /**
     * Borrowed books
     *
     * Get all borrowed books
     *
     * @Get("/borrowed_books")
     * @Versions({"v1"})
     * @Request({"token": "foo"})
     * @Response(200, body={
    "books": {
    {"user_book_id":"1",
    "title": "Book for mathematics",
    "author": "Group of authors",
    "get": "2015-08-10"}
    }
    })
     */
    public function borrowedBooks()
    {
        $books = BookUser::join('books', 'books.id', '=', 'book_users.book_id')
            ->whereNotNull('get')
            ->whereNotNull('books.deleted_at')
            ->whereNull('back')
            ->select(array('book_users.id as user_book_id', 'books.title', 'books.author', 'book_users.get'))
            ->get()->toArray();
        return response()->json(['books' => $books], 200);
    }

    /**
     * Post new book
     *
     * @Post("/add_book")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "subject_id":"1", "title":"Title of book", "author":"This is author",
     *              "year":"2015", "quantity":"5","internal": "2015/15","publisher": "Book publisher 2",
    "version": "0.1"}),
     *      @Response(200, body={"success":"success"}),
     *      @Response(500, body={"error":"not_valid_data"})
     *    })
     * })
     */
    public function addBook(Request $request)
    {
        $rules = array(
            'subject_id' => 'integer',
            'internal' => 'required',
            'title' => 'required',
            'author' => 'required',
            'year' => 'required|integer',
            'quantity' => 'required|integer',
            'publisher' => 'required',
            'version' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $book = new Book($request->except('token'));
            $book->save();
            return response()->json(['success' => 'success'], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Delete book
     *
     * @Post("/delete_book")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "book_id":"1"}),
     *      @Response(200, body={"success":"success"}),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    public function deleteBook(Request $request)
    {
        $rules = array(
            'book_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $book = Book::find($request->input('book_id'));
            $book->delete();
            return response()->json(['success' => "success"], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Edit book
     *
     * @Post("/edit_book")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo","book_id":"1", "subject_id":"1", "title":"Title of book", "author":"This is author",
     *              "year":"2015", "quantity":"5","internal": "2015/15","publisher": "Book publisher 2",
    "version": "0.1"}),
     *      @Response(200, body={"success":"success"}),
     *      @Response(500, body={"error":"not_valid_data"})
     *    })
     * })
     */
    public function editBook(Request $request)
    {
        $rules = array(
            'book_id' => 'required|integer',
            'subject_id' => 'integer',
            'internal' => 'required',
            'title' => 'required',
            'author' => 'required',
            'year' => 'required|integer',
            'quantity' => 'required',
            'publisher' => 'required',
            'version' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $book = Book::find($request->input('book_id'));
            $book->update($request->except('token', 'book_id'));
            return response()->json(['success' => 'success'], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Reserved books
     *
     * Get all reserved books
     *
     * @Get("/reserved_books")
     * @Versions({"v1"})
     * @Request({"token": "foo"})
     * @Response(200, body={
    "books": {"id": "1",
    "title": "Book for mathematics",
    "author": "Group of authors",
    "subject": "Mathematics",
    "reserved": "2015-08-10"}
    })
     */
    public function reservedBooks()
    {
        $books = BookUser::join('books', 'books.id', '=', 'book_users.book_id')
            ->whereNotNull('reserved')
            ->whereNotNull('books.deleted_at')
            ->whereNull('get')
            ->select(array('book_users.id', 'books.title', 'books.author',
                DB::raw('(SELECT title from subjects where subjects.id=books.subject_id) as subject'),
                'book_users.reserved'))->get()->toArray();
        return response()->json(["books" => $books], 200);
    }


    /**
     * Delete reserve book
     *
     * @Post("/delete_reserved_book")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "user_book_id":"1"}),
     *      @Response(200, body={"success":"success"}),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    public function deleteReserveBook(Request $request)
    {
        $rules = array(
            'user_book_id' => 'required|integer',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $book_user = BookUser::find($request->input('user_book_id'));
            $book_user->delete();
            return response()->json(['success' => "success"], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Issue reserved book
     *
     * @Post("/issue_reserved_book")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "user_book_id":"1"}),
     *      @Response(200, body={"success":"success"}),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    public function issueReservedBook(Request $request)
    {
        $rules = array(
            'user_book_id' => 'required|integer'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $book_user = BookUser::find($request->input('user_book_id'));
            $book_user->get = date("Y-m-d");
            $book_user->save();
            return response()->json(['success' => "success"], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Issue book
     *
     * @Post("/issue_book")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "book_id":"1", "user_id":"1", "note":"This is note","date":"2015-02-02"}),
     *      @Response(200, body={"success":"success"}),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    public function issueBook(Request $request)
    {
        $rules = array(
            'book_id' => 'required|integer',
            'user_id' => 'required|integer',
            'date' => 'required',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $book_user = new BookUser;
            $book_user->book_id = $request->input('book_id');
            $book_user->user_id = $request->input('user_id');
            $book_user->note = $request->input('note');
            $book_user->get = date('Y-m-d', strtotime($request->input('date')));
            $book_user->save();
            return response()->json(['success' => "success"], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Return ook
     *
     * @Post("/return_book")
     * @Versions({"v1"})
     * @Transaction({
     *      @Request({"token": "foo", "user_book_id":"1"}),
     *      @Response(200, body={"success":"success"}),
     *      @Response(500, body={"error":"not_valid_data"})
     *       })
     * })
     */
    public function returnBook(Request $request)
    {
        $rules = array(
            'user_book_id' => 'required|integer'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            $book_user = BookUser::find($request->input('user_book_id'));
            $book_user->back = date('Y-m-d');
            $book_user->save();
            return response()->json(['success' => "success"], 200);
        } else {
            return response()->json(['error' => 'not_valid_data'], 500);
        }
    }

    /**
     * Get list of subjects
     *
     * Get list of subjects for all directions and class use for creating book
     *
     * @Get("/subject_list")
     * @Versions({"v1"})
     * @Request({"token": "foo"})
     * @Response(200, body={
    "subjects": {{"id": "1",
    "title": "Direction2 (3) English",
    "direction": "Direction2",
    "class": "3",
    "subject": "English"
    }
    }
    })
     */
    public function subjectList()
    {
        $subjects = Subject::join('directions', 'directions.id', '=', 'subjects.direction_id')
            ->whereNull("directions.deleted_at")
            ->orderBy("directions.title")
            ->orderBy("subjects.class")
            ->orderBy("subjects.title")
            ->select(DB::raw('CONCAT(directions.title, " (", subjects.class, ") ", subjects.title) as title'), 'subjects.id',
                "directions.title as direction", 'subjects.class', 'subjects.title as subject')
            ->get()->toArray();

        return response()->json(['subjects' => $subjects], 200);
    }

    /**
     * Get list of users
     *
     * Get list of users for issuing book
     *
     * @Get("/user_list")
     * @Versions({"v1"})
     * @Request({"token": "foo"})
     * @Response(200, body={
    "users":{
    {"id": "1",
    "name": "First Last name",
    "role": "teacher|librarian|admin|student|parent",
    }
    }
    })
     */
    public function userList()
    {
        $users = User::join('role_users', 'role_users.user_id', '=', 'users.id')
            ->join('roles', 'roles.id', '=', 'role_users.role_id')
            ->orderBy("first_name")
            ->orderBy("last_name")
            ->select('users.id', 'users.first_name', 'users.last_name',
                'users.picture', 'users.gender', 'roles.slug as role')
            ->get()->toArray();

        return response()->json(['users' => $users], 200);
    }

}
