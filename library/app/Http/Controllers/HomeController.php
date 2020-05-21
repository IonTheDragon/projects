<?php

namespace App\Http\Controllers;

use App\Author;
use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
	
	public function authors()
    {
        return view('authors');
    }
	
	public function books()
    {
        return view('books');
    }
	
	public function search()
    {
        return view('search');
    }
	
	public function add_author_form()
    {
        return view('add_author_form');
    }
	
	public function add_book_form()
    {
		$authors = Author::get();
        return view('add_book_form', ['authors' => $authors]);
    }
	
	public function get_authors(Request $request)
    {
		$authors = Author::offset($request->start)->limit($request->length)->get();
		$data = [];
		
		foreach ($authors as $author)
		{
			$data[] = [$author->name];
		}

        return ['data' => $data];
    }

	public function get_books(Request $request)
    {
		$books = Book::offset($request->start)->limit($request->length)->get();
		$data = [];
		
		foreach ($books as $book)
		{
			$data[] = [$book->name];
		}

        return ['data' => $data];
    }	
	
	public function search_books(Request $request)
    {
		if(empty($request->search['value'])) return ['data' => []];
			
		$regs = explode(",", $request->search['value']);
		$found_authors = [];
		foreach($regs as $reg)
		{
			$reg = trim($reg);
			if (!empty($reg))
			{
				$authors = Author::where('name', 'like', '%'.$reg.'%')->get();
				foreach ($authors as $author)
				{
					$found_authors[$author->id] = $author->id;
				}
			}
		}
		
		if(empty($found_authors))
		{
			$books = Book::where('name', 'like', '%'.$reg.'%')->get();
		}
		else
		{
			$books = [];
			foreach ($found_authors as $found_author)
			{
				//Ищем по автору
				$abooks = Book::where('author_id', $found_author)->get();
				foreach ($abooks as $abook)
				{
					$books[$abook->id] = $abook;
				}
				
				//Ищем по соавтору
				$cbooks = DB::table('coauthors')->where('author_id', $found_author)->get();
				foreach ($cbooks as $cbook)
				{
					$book = Book::where('id', $cbook->book_id)->first();
					$books[$book->id] = $book;
				}
			}	

			//Если у авторов нет книг - ищем по названию книги
			if (empty($books))
				$books = Book::where('name', 'like', '%'.$reg.'%')->get();
		}
		
		$data = [];
		
		foreach ($books as $book)
		{
			$data[] = [$book->name];
		}

        return ['data' => $data];
    }	
	
	public function add_author(Request $request)
    {
		
		$author = new Author;

        $author->name = $request->name;

        $author->save();
		
        return redirect('authors');
    }
	
	public function add_book(Request $request)
    {
		
		$book = new Book;

        $book->name = $request->name;
		$book->author_id = $request->author_id[0];

        $book->save();
		
		foreach ($request->author_id as $key => $author_id)
		{
			if ($key > 0)
			{
				DB::table('coauthors')->insert(
					['book_id' => $book->id, 'author_id' => $author_id]
				);				
			}
		}
		
        return redirect('books');
    }
}
