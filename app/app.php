<?php
     require_once __DIR__."/../src/Author.php";
     require_once __DIR__."/../vendor/autoload.php";
     require_once __DIR__."/../src/Book.php";

     $app = new Silex\Application();

    $DB = new PDO('pgsql:host=localhost;dbname=library');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app['debug']=TRUE;

    //cRud - READ
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    $app->get("/admin", function() use ($app) {
        return $app['twig']->render('admin.html.twig', array('authors' => Author::getAll()));
    });

    $app->get("/patron", function() use ($app) {
        return $app['twig']->render('patron.html.twig');
    });

    $app->get('/authors/{id}', function($id) use ($app) {
        $author = Author::find($id);
        // $author->save();
        return $app['twig']->render('authors_edit.html.twig', array('author' => $author, 'books' => $author->getBooks()));
    });

    $app->get('/books', function() use ($app) {
        return $app['twig']->render('books.html.twig', array('titles' => Book::getAll()));
    });

    $app->get('/add_books', function() use ($app) {
        // $author = Author::find($id);
        return $app['twig']->render('authors_edit.html.twig', array('author' => $author, ));
    });

    //Crud - CREATE
    $app->post("/authors", function() use ($app) {
         $author = new Author($_POST['name']);
         $author->save();
         return $app['twig']->render('admin.html.twig', array('name' => $author, 'authors' => Author::getAll()));
    });

    $app->post('/authors/{id}', function($id) use ($app) {
        $book = new Book($title, $id);
        $book->save();
        return $app['twig']->render('authors_edit.html.twig', array('titles' => $book, 'books' => Book::getAll()));

    });

    $app->post('/add_books/{id}', function($id) use ($app) {
        $authors_id = $_POST['authors_id'];
        $book = new Book($_POST['new_book']);
        $book->save();
        var_dump($book);
        $author = Author::find($authors_id);
        var_dump($author->getBooks());
        return $app['twig']->render('authors_edit.html.twig', array('books' => $book, 'author' => $author));
    });

    // $app->post('/authors/{id}', function($id) use ($app) {
    //     $author = Author::find($id);
    //     $author->save();
    //     return $app['twig']->render('authors_edit.html.twig', array('author' => $author, 'books' => $author->getBooks()));
    // });

    //cruD - DELETE
    $app->delete("/authors", function() use ($app) {
        Author::deleteAll();
        return $app['twig']->render('admin.html.twig', array('authors' => Author::getAll()));
    });

    return $app;

 ?>
