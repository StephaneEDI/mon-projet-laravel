<?php

namespace Tests\Feature;

use Tests\TestCase;

class ContactLinksTest extends TestCase
{
    public function test_vitrine_displays_configured_email_and_whatsapp_links(): void
    {
        config([
            'contact.email' => 'contact@domaine.example',
            'contact.whatsapp' => '+225 07 00 00 00 00',
            'contact.whatsapp_message' => 'Bonjour, une question sur vos cépages ?',
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertSee('href="mailto:contact@domaine.example"', false)
            ->assertSee('href="https://wa.me/2250700000000?text=', false)
            ->assertSee('bi-whatsapp', false)
            ->assertSeeText('WhatsApp');
    }

    public function test_vitrine_hides_contact_links_when_no_public_details_are_configured(): void
    {
        config([
            'contact.email' => null,
            'contact.whatsapp' => null,
        ]);

        $this->get(route('home'))
            ->assertOk()
            ->assertDontSee('mailto:')
            ->assertDontSee('wa.me/')
            ->assertDontSee('id="contact"', false);
    }
}
