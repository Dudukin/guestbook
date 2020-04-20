<?php
namespace App\Tests\Controller;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
class ConferenceControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Give your feedback');
    }

    public function testCommentSubmission()
    {
        $client = static::createClient();
        $client->request('GET', '/conference/paris-2013');
        $client->submitForm('Submit', [
                'comment_form[author]' => 'Fabien',
                'comment_form[text]' => 'Some feedback from an automated functional test',
                'comment_form[email]' => 'me@automat.ed',
                'comment_form[photo]' => dirname(__DIR__, 2).'/public/images/under-construction.gif',
            ]);
//        $this->assertResponseRedirects();
//        $client->followRedirect();
        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('div:contains("There are 6 comments")');
    }

    public function testConferencePage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertCount(3, $crawler->filter('h4'));
        $client->clickLink('View');
        $this->assertPageTitleContains('Paris');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Paris 2013');
        $this->assertSelectorExists('div:contains("There are 6 comments")');
    }
}