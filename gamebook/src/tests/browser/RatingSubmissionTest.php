<?php
require __DIR__. "/../../../vendor/autoload.php";

class RatingSubmissionTest extends PHPUnit_Extensions_Selenium2TestCase
{
    protected function setUp()
    {
        $this->setHost('localhost');
        $this->setPort(4444);
        $this->setBrowser('chrome');
        $this->setBrowserUrl('http://0.0.0.0:8000/');
    }

    
    public function tearDown()
    {
        $this->stop();
    }
    
    public function testHomePage()
    {
        $this->url('/');
        $content = $this->byCssSelector('li span.title')->text();
        $this->assertEquals("Game 1", $content);
    }

    public function testSubmitRating()
    {
        $this->timeouts()->implicitWait(2000);
        $this->url('/');
        $this->byLinkText('Rate')->click();

        $form = $this->byTag('form');
        $form->byName('score')->value(5);
        $image = $this->currentScreenshot();
        file_put_contents(__DIR__.'/screenshots/pre-submit-rating.jpg', $image);
        $form->submit();

        $this->assertEquals('http://0.0.0.0:8000/', $this->getBrowserUrl());
    }

}