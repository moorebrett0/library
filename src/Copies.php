<?php

    class Copies
    {
        private $total;
        private $remaining;
        private $id;


        function __construct($total, $remaining, $id = null)
        {
            $this->total = $total;
            $this->remaining = $remaining;
            $this->id = $id;
        }
        //SETTERS
        function setTotal($new_total)
        {
            $this->total = (int) $new_total;
        }

        function setId($new_id)
        {
            $this->id =  (int) $new_id;
        }

        function setRemaining($new_remaining)
        {
            $this->remaining = (int) $new_remaining;
        }

        //GETTERS
        function getTotal()
        {
            return $this->total;
        }

        function getId()
        {
            return $this->id;
        }

        function getRemaining()
        {
            return $this->remaining;
        }

        //SAVE
        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO copies (total, remaining) VALUES ({$this->getTotal()}, {$this->getRemaining()}) RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies;");
            $totals = [];
            foreach ($returned_copies as $copy) {
                $book = $copy['total_copies'];
                $book_id = $copy['books_id'];
                $id = $copy['id'];
                $new_book = new Copies($book, $books_id, $id);
                array_push($totals, $new_book);
            }
            return $totals;
        }

        //DELETE
        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies WHERE id = {$this->getId()};");

        }

        //FIND
        static function find($search_id)
        {
            $found_copy = null;
            $copies = Copies::getAll();
            foreach($copies as $copy){
                $copy_id = $copy->getId();
                if ($copy_id == $search_id) {
                    $found_copy = $copy;
                }
            }
            return $found_copy;
        }
    }

 ?>
