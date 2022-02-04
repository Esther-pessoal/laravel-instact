<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class PostTest extends TestCase
{
    use DatabaseTransactions;
    use WithFaker;

    /**
     * Entrar na pag inicial e ver 
     * a frase 'Instact'
     * 
     * @return void
     */

     public function testOpenIndexAndSeeInstact()
     {
        $response = $this->get('/');

        $response->assertSee('Instact');
     }

     /**
      * Entrar na pag inicial e não ver
      * a palavra Dashboard
      *
      * @return void
      */

     public function testOpenIndexAndDontSeeDashboard()
     {
        $response = $this->get('/');

        $response->assertDontSee('Dashboard');
     }

     /**
      * Tentar acessar a rota /dashboard sem autenticação
      * e redirecionar para tela de login
      *
      * @return void
      */

      public function testNotOpenDashboardWithoutAuth()
      {
          $response = $this->get('/dashboard');

          $response->assertRedirect('/');
      }

      /**
      * Tentar acessar a rota /dashboard com autenticação
      * e permitir
      *
      * @return void
      */

      public function testOpenDashboardWithAuth()
      {

        $user = User::factory()->create();
        $this->actingAs($user);

          $response = $this->get('/dashboard');

          $response->assertOk();
          $response->assertSee('Dashboard');
      }

      /**
       * Acessar a rota /posts/store e criar um post
       * 
       * @return void
       */

      public function testCreatePost()
       {
        $user = User::factory()->create();
        $this->actingAs($user);

        $input = [
            'description' => $this->faker->sentence(4),
            'photo' => UploadedFile::fake()->image('img.png')
        ];

        $response = $this->post('/posts/store', $input);

        $this->assertDatabaseHas('posts', [
            'description' => $input['description'],
            'user_id' => $user->id
        ]);

      }
}
