<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%authors_books}}`.
 */
class m201110_141658_create_authors_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('authors_books', [
            'author_id' => $this->integer(),
            'book_id' => $this->integer(),
            'PRIMARY KEY(author_id, book_id)',
        ]);

        $this->createIndex(
            'idx-authors_books-author_id',
            'authors_books',
            'author_id'
        );

        $this->createIndex(
            'idx-authors_books-book_id',
            'authors_books',
            'book_id'
        );

        $this->addForeignKey(
            'fk-authors_books-author_id',
            'authors_books',
            'author_id',
            'authors',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-authors_books-book_id',
            'authors_books',
            'book_id',
            'books',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-authors_books-author_id',
            'authors_books'
        );

        $this->dropIndex(
            'idx-authors_books-author_id',
            'post_tag'
        );

        $this->dropForeignKey(
            'fk-authors_books-book_id',
            'authors_books'
        );

        $this->dropIndex(
            'idx-authors_books-book_id',
            'post_tag'
        );

        $this->dropTable('authors_books');
    }
}
