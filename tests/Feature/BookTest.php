<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use RefreshDatabase;

     /** @test */
    public function guest_user_cannot_interact_with_books()
    {
        Book::factory()->create();
    
        $readBooks = $this->getJson('/api/books');
        $storeBooks = $this->postJson('/api/books');
        $updateBook = $this->patchJson('/api/books/1');
        $deleteBook = $this->deleteJson('/api/books/1');


        $readBooks->assertStatus(401);
        $storeBooks->assertStatus(401);
        $updateBook->assertStatus(401);
        $deleteBook->assertStatus(401);

    }

    /** @test */
    public function authenticated_user_can_get_all_books()
    {
        Book::factory()->count(3)->create();

        $response = $this->setHeaders()->getJson('/api/books');
     
        $response->assertStatus(200)
                 ->assertJsonStructure(['books']);
    }

    /** @test */
    public function authenticated_user_can_create_a_book()
    {
        $user = User::factory()->create();
        $bookData = Book::factory()->raw(['user_id' => $user->id]);

        $response = $this->setHeaders($user)
                         ->postJson('/api/books', $bookData);

        $response->assertStatus(200)
                 ->assertJson(['success' => 'Book created successfully.', 'book' => [...$bookData, 'user_id' => $user->id]]);
    }
     /** @test */
     public function title_and_author_are_required()
     {
         $bookData = Book::factory()->raw(['title' => '']);
     
         $response = $this->setHeaders()
                          ->postJson('/api/books', $bookData);
     
         $response->assertStatus(422)
                   ->assertJson([
                       'message' => 'The given data was invalid.',
                       'errors' => ['title' => ['The title field is required.']],
                   ]);
     
         $bookData = Book::factory()->raw(['author' => '']);
     
         $response = $this->setHeaders()
                          ->postJson('/api/books', $bookData);
     
         $response->assertStatus(422)
                   ->assertJson([
                       'message' => 'The given data was invalid.',
                       'errors' => ['author' => ['The author field is required.']],
                   ]);
     }

    /** @test */
    public function authenticated_user_can_update_a_book()
    {
        $book = Book::factory()->create()->toArray();
        $updatedData = ['title' => 'Updated Title', 'author' => 'Updated Title'];

        $response = $this->setHeaders()
                         ->patchJson("/api/books/{$book['id']}", $updatedData);

        $response->assertStatus(200)
                 ->assertJson(['success' => 'Book has been updated successfully.', 'book' => [...$book, ...$updatedData]]);
    }

    /** @test */
    public function authenticated_user_can_delete_a_book()
    {
        $book = Book::factory()->create();

        $response = $this->setHeaders()
                         ->deleteJson("/api/books/{$book->id}");
        $this->assertCount(0, Book::all());
         
        $response->assertStatus(200)
                 ->assertJson(['success' => 'Book has been deleted successfully.']);
    }
    
   
}
