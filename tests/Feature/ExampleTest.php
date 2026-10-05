<?php

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    public function test_halaman_utama_mengarah_ke_katalog(): void
    {
        $this->get('/')->assertRedirect(route('costumes.index'));
    }
}
