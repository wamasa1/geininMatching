<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AccessTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $response = $this->get('/register');
        $response->assertStatus(200);

        $response = $this->get('/show');
        $response->assertStatus(302);

        $response = $this->get('/login');
        $response->assertStatus(200);

        $response = $this->get('/logout');
        $response->assertStatus(302);

        $response = $this->get('/search');
        $response->assertStatus(200);

        $response = $this->get('/event');
        $response->assertStatus(200);

        $response = $this->get('/profile');
        $response->assertStatus(302);

        $response = $this->get('/profile/edit');
        $response->assertStatus(302);

        $response = $this->get('/message/{id}');
        $response->assertStatus(302);

        $response = $this->get('/messagebox');
        $response->assertStatus(302);

        $response = $this->get('/favorite');
        $response->assertStatus(302);

        $response = $this->get('/csv');
        $response->assertStatus(200);

        $response = $this->get('/csv/download');
        $response->assertStatus(200);
    }

    //認証済みのユーザー
    public function testAuth()
    {
        $response = $this->post('/show', [
            'user' => 'ikuta',
            'genre' => '漫才',
            'role' => 'ボケ',
            'creater' => '自分が作る',
            'target' => 'ゴールデンで冠番組を持つ',
            'self_introduce' => '',
            'email' => 'ikuta@gmail.com',
            'password' => 'ikuta',
        ]);
        $response->assertStatus(200);

        $response = $this->get('/show');
        $response->assertStatus(200);

        $response = $this->patch('/show', [
            'favoriteTo_id' => '1',
        ]);
        $response->assertStatus(302);

        $response = $this->delete('/show', [
            'favoriteTo_id' => '1',
        ]);
        $response->assertStatus(302);

        $response = $this->patch('/search', [
            'favoriteTo_id' => '1',
        ]);
        $response->assertStatus(302);

        $response = $this->delete('/search', [
            'favoriteTo_id' => '1',
        ]);
        $response->assertStatus(302);

        $response = $this->get('/profile');
        $response->assertStatus(200);

        $response = $this->get('/profile', [
            'image' => 'shaking-hands.jpg'
        ]);
        $response->assertStatus(200);

        $response = $this->get('/profile/edit');
        $response->assertStatus(200);

        $response = $this->post('/profile/edit', [
            'user' => 'ikuta',
            'genre' => '漫才',
            'role' => 'ボケ',
            'creater' => '自分が作る',
            'target' => 'ゴールデンで冠番組を持つ',
            'self_introduce' => '',
        ]);
        $response->assertStatus(302);

        $response = $this->get('/message/1');
        $response->assertStatus(200);

        $response = $this->get('/messagebox');
        $response->assertStatus(200);

        $response = $this->get('/favorite');
        $response->assertStatus(200);

        $response = $this->delete('/favorite', [
            'favoriteTo_id' => '1',
        ]);
        $response->assertStatus(302);
    }
}
