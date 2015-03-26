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

    //Crud - CREATE
    $app->post("/authors", function() use ($app) {
         $author = new Author($_POST['name']);
         $author->save();
         return $app['twig']->render('admin.html.twig', array('name' => $author, 'authors' => Author::getAll()));
    });

    //cruD - DELETE
    $app->delete("/authors/{id}", function() use ($app) {
        Author::deleteAll();
        return $app['twig']->render('admin.html.twig', array('name' => Author::getAll()));
    });

    return $app;

 ?>
