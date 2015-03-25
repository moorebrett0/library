<?php

    class Checkout
    {
        private $patron_id;
        private $copy_id;
        private $id;

        function __construct($patron_id, $copy_id, $id = null)
        {
            $this->patron_id = $patron_id;
            $this->copy_id = $copy_id;
            $this->id = $id;
        }

        //SETTERS
        function setPatronId($new_patron_id)
        {
            $this->patron_id = (int) $new_patron_id;
        }

        function setCopyId($new_copy_id)
        {
            $this->copy_id = (int) $new_copy_id;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        //GETTERS
        function getPatronId()
        {
            return $this->patron_id;
        }

        function getCopyId()
        {
            return $this->copy_id;
        }

        function getId()
        {
            return $this->id;
        }

        //SAVE
        function save()
        {
            $statement = $GLOBALS['DB']->exec("INSERT INTO checkout (patron_id, copy_id) VALUES ({$this->getPatronId()}, {$this->getCopyId()}) RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll()
        {
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM checkout;");
            $checkout = [];
            foreach ($returned_patrons as $patron) {
                $patron = $patron['patron_id'];
                $copies_id = $patron['copies_id'];
                $id = $patron['id'];
                $new_checkout = new CheckOut($patron_id, $copies_id, $id);
                array_push($checkout, $new_book);
            }
            return $checkout;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE * FROM checkout;");
        }

        static function findPatron($search_id)
        {
            $found_patron = null;
            $patrons = Checkout::getAll();
            foreach($patrons as $patron){
                $patron_id = $patron->getId();
                if ($patron_id == $search_id) {
                    $found_patron = $patron;
                }
            }
            return $found_patron;
        }
        function CheckOutCopy($total)
        {
        $GLOBALS['DB']->exec("SELECT * FROM copies WHERE id = {$total->getId()};");

        }
    }
















 ?>
