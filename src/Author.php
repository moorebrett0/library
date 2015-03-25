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
            $authors = array();
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

        //DELETE EVERYTHING
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors *;");
        }


    }









 ?>
