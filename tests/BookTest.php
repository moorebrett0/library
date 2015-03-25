<?php

        /**
        * @backupGlobals disabled
        * @backupStaticAttributes disabled
        */

        require_once "src/Author.php";
        require_once "src/Book.php";

        $DB = new PDO('pgsql:host=localhost;dbname=library_test');

        class BookTest extends PHPUnit_Framework_TestCase
        {

            protected function tearDown()
            {
                Book::deleteAll();
                Author::deleteAll();
            }

            function test_getId()
            {
                //Arrange
                $title = "Rainbow Six";
                $id = 1;
                $test_book = new Book($title, $id);

                //act
                $result = $test_book->getId();

                //assert
                $this->assertEquals(1, $result);
            }

            function test_save()
            {
                //Arrange
                $title = "Rainbow Six";
                $id = 1;
                $test_book = new Book($title, $id);
                $test_book->save();

                //Act
                $result = Book::getAll();

                //Assert
                $this->assertEquals($test_book, $result[0]);
            }

            function test_getAll()
            {
                //Arrange
                $title = "Curious George";
                $id = 1;
                $title2 = "Atlas Shrugged";
                $id2 = 2;
                $test_book = new Book($title, $id);
                $test_book->save();
                $test_book2 = new Book($title2, $id2);
                $test_book2->save();

                //Act

                $result = Book::getAll();

                //Assert
                $this->assertEquals([$test_book, $test_book2], $result);
            }

            function test_deleteAll()
            {

                //Arrange
                $title = "Curious George";
                $id = 1;
                $title2 = "Atlas Shrugged";
                $id2 = 2;
                $test_book = new Book($title, $id);
                $test_book->save();
                $test_book2 = new Book($title2, $id2);
                $test_book2->save();

                //Act
                Book::deleteAll();
                $result = Book::getAll();

                //Assert
                $this->assertEquals([], $result);
            }

            function test_find()
            {
                //Arrange
                $title = "Curious George";
                $id = 1;
                $title2 = "The Winds of Winter";
                $id2 = 2;
                $test_book = new Book($title, $id);
                $test_book->save();
                $test_book2 = new Book($title2, $id2);
                $test_book2->save();

                //Act
                $result = Book::find($test_book->getId());

                //Assert
                $this->assertEquals($test_book, $result);
            }

            function test_addAuthor()
            {
                //Arrange
                $name = "Jeff Lindsay";
                $id = 1;
                $test_author = new Author($name, $id);
                $test_author->save();

                $title = "Darkly Dreaming Dexter";
                $id2 = 2;
                $test_book = New Book($title, $id2);
                $test_book->save();

                //Act
                $test_book->addAuthor($test_author);

                //Assert
                $this->assertEquals($test_book->getAuthors(), [$test_author]);
            }

        }

?>
