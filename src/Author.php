<?php

    Class Author
    {
        private $name;
        private $id;

        //CONSTRUCT
        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        //SETTERS
        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function setId($new_id)
        {
            $this->id =  (int) $new_id;
        }

        //GETTERS
        function getName()
        {
            return $this->name;
        }

        function getId()
        {
            return $this->id;
        }

        static function getAll()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors;");
            $authors = [];
            foreach ($returned_authors as $author) {
                $name = $author['name'];
                $id = $author['id'];
                $new_author = new Author($name, $id);
                array_push($authors, $new_author);
            }
            return $authors;
        }

        //SAVE
        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO authors (name) VALUES ('{$this->getName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE authors SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        //DELETE
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors *;");
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors Where id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM authors_books WHERE authors_id = {$this->getId()};");
        }

        //find author by ID
        static function find($search_id)
        {
            $found_author = null;
            $authors = Author::getAll();
            foreach($authors as $author){
                $author_id = $author->getId();
                if ($author_id == $search_id) {
                    $found_author = $author;
                }
            }
            return $found_author;
        }

        function getBooks()
        {
            $query = $GLOBALS['DB']->query("SELECT books.* FROM authors JOIN authors_books ON authors.id = authors_books.authors_id JOIN books ON books.id =authors_books.books_id  WHERE authors.id = {$this->getId()}; ");

            $book_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $books = [];
            foreach($book_ids as $id) {
                $book_id = $id['books_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM books WHERE id = {$book_id};");
                $returned_book = $result->fetchAll(PDO::FETCH_ASSOC);

                $title = $returned_book[0]['title'];
                $id = $returned_book[0]['id'];
                $new_book = new Book($title, $id);
                array_push($books, $new_book);
            }
            return $books;
        }

        function addBook($title)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (authors_id, books_id) VALUES ({$this->getId()}, {$title->getId()});");
        }

    }









 ?>
