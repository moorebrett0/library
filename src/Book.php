<?php

    Class Book
    {
        private $title;
        private $id;

        //CONSTRUCT
        function __construct($title, $id = null)
        {
            $this->title = $title;
            $this->id = $id;
        }

        //SETTERS
        function setTitle($new_title)
        {
            $this->title = (string) $new_title;
        }

        function setId($new_id)
        {
            $this->id =  (int) $new_id;
        }

        //GETTERS
        function getTitle()
        {
            return $this->title;
        }

        function getId()
        {
            return $this->id;
        }

        static function getAll()
        {
            $returned_titles = $GLOBALS['DB']->query("SELECT * FROM books;");
            $titles = [];
            foreach ($returned_titles as $title) {
                $book = $title['title'];
                $id = $title['id'];
                $new_title = new Book($book, $id);
                array_push($titles, $new_title);
            }
            return $titles;
        }

        //SAVE
        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO books (title) VALUES ('{$this->getTitle()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        //DELETE
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM books *;");
        }



        //find title by ID
        static function find($search_id)
        {
            $found_title = null;
            $titles = Book::getAll();
            foreach($titles as $title){
                $title_id = $title->getId();
                if ($title_id == $search_id) {
                    $found_title = $title;
                }
            }
            return $found_title;
        }


    }









 ?>
