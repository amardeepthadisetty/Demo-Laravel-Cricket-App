<?php
namespace App\Http\Controllers;


use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $limit = 2;
        $projections = ['name', 'detail','ref'];
        $books =DB::connection('mongodb')->collection('books')->paginate($limit, $projections);

      
        return view('books.index',compact('books'))
            ->with('i', 0);
    }

    public function admin(){

        echo "admin page";
        die;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('books.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);


        $car = new Book();
        $car->nextid(); // auto-increment
        $car->name = $request->input('name');
        $car->detail = $request->input('detail');
        $car->save();


       // Book::create($request->all());


        return redirect()->route('books.index')
                        ->with('success','Book created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show($book)
    {
       // echo "hello";
       // die;
       // dd($book);
        //echo "<br> book is: ".$book."<br>";
       $b[] = (int)$book;
       $book = Book::whereIn('ref', $b)->firstorfail();
       

       

        return view('books.show',compact('book'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit($book)
    {
        $b[] = (int)$book;
        $book = Book::whereIn('ref', $b)->firstorfail();
        return view('books.edit',compact('book'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
         request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);


        $book->update($request->all());


        return redirect()->route('books.index')
                        ->with('success','Book updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();


        return redirect()->route('books.index')
                        ->with('success','Book deleted successfully');
    }
}