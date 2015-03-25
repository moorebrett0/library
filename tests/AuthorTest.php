<?php

        /**
        * @backupGlobals disabled
        * @backupStaticAttributes disabled
        */

        require_once "src/Author.php";

        $DB = new PDO('pgsql:host=localhost;dbname=library_test');

        class AuthorTest extends PHPUnit_Framework_TestCase
        {

            protected function tearDown()
            {
                Author::deleteAll();
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





        }

?>
