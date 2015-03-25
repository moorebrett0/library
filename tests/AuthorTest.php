<?php

        /**
        * @backupGlobals disabled
        * @backupStaticAttributes disabled
        */

        require_once "src/Author.php";
        require_once "src/Book.php";

        $DB = new PDO('pgsql:host=localhost;dbname=library_test');

        class AuthorTest extends PHPUnit_Framework_TestCase
        {

            protected function tearDown()
            {
                Author::deleteAll();
                Book::deleteAll();
            }

            function test_getId()
            {
                //Arrange
                $name = "Tom Clancy";
                $id = 1;
                $test_author = new Author($name, $id);

                //act
                $result = $test_author->getId();

                //assert
                $this->assertEquals(1, $result);
            }

            function test_save()
            {
                //Arrange
                $name = "Oscar Wilde";
                $id = 1;
                $test_author = new Author($name, $id);
                $test_author->save();

                //Act
                $result = Author::getAll();

                //Assert
                $this->assertEquals($test_author, $result[0]);
            }

            function test_getAll()
            {
                //Arrange
                $name = "JK Rawling";
                $id = 1;
                $name2 = "George RR Martin";
                $id2 = 2;
                $test_author = new Author($name, $id);
                $test_author->save();
                $test_author2 = new Author($name2, $id2);
                $test_author2->save();

                //Act

                $result = Author::getAll();

                //Assert
                $this->assertEquals([$test_author, $test_author2], $result);
            }

            function test_deleteAll()
            {

                //Arrange
                $name = "JK Rawling";
                $id = 1;
                $name2 = "George RR Martin";
                $id2 = 2;
                $test_author = new Author($name, $id);
                $test_author->save();
                $test_author2 = new Author($name2, $id2);
                $test_author2->save();

                //Act
                Author::deleteAll();
                $result = Author::getAll();

                //Assert
                $this->assertEquals([], $result);
            }

            function test_find()
            {
                //Arrange
                $name = "JK Rawling";
                $id = 1;
                $name2 = "George RR Martin";
                $id2 = 2;
                $test_author = new Author($name, $id);
                $test_author->save();
                $test_author2 = new Author($name2, $id2);
                $test_author2->save();

                //Act
                $result = Author::find($test_author->getId());

                //Assert
                $this->assertEquals($test_author, $result);
            }

            function test_delete()
            {
                //Arrange
                $name = "JK Rawling";
                $id = 1;
                $test_author = new Author($name, $id);
                $test_author->save();

                $title = "Harry Potter and the Philosophers Stone";
                $id2 = 2;
                $test_book = new Book($title, $id2);
                $test_book->save();

                //Act
                $test_author->addBook($test_book);
                $test_author->delete();

                //Assert
                $this->assertEquals([], $test_book->getAuthors());

            }

            function test_update()
            {
                //Arrange
                $name = "JK Rawling";
                $id = 1;
                $test_author = new Author($name, $id);
                $test_author->save();

                $new_name = "CS Lewis";

                //Act
                $test_author->update($new_name);

                //Assert
                $this->assertEquals("CS Lewis", $test_author->getName());
            }

        }

?>
