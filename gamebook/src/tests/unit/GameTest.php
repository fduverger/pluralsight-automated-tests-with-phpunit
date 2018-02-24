<?php
use PHPUnit\Framework\TestCase;

class GameTest extends TestCase {
    
    public function testImagePathShouldBeSetToPlaceholderWhenNull() {
        $game = new Game();
        $game->setImagePath(null);

        $this->assertEquals("/images/placeholder.jpg", $game->getImagePath());
    }
    
    public function testImagePathShouldBeSetToValueWhenNotNull() {
        $game = new Game();
        $game->setImagePath("/images/path.jpg");

        $this->assertEquals("/images/path.jpg", $game->getImagePath());
    }
    
    public function testAverageScoreReturnsNullWhenNoRatings()
    {
        $game = new Game();
        $game->setRatings([]);

        $this->assertNull($game->getAverageScore());
    }

    public function testAverageScoreWith6And8Return7()
    {
        $rating1 = $this->getMockBuilder('Rating')
                        ->setMethods(array('getScore'))
                        ->getMock(); 
                        
        $rating1->method('getScore')
                ->will($this->returnValue(6));
                                 
        $rating2 = $this->getMockBuilder('Rating')
                        ->setMethods(array('getScore'))
                        ->getMock();    
                
        $rating2->method('getScore')
                ->will($this->returnValue(8));
        
        $game = $this->getMockBuilder(Game::class)
                     ->setMethods(array('getRatings'))
                     ->getMock();
        
        $game->method('getRatings')
             ->will($this->returnValue([$rating1, $rating2]));
        
        
        // assertions
        $this->assertEquals(7, $game->getAverageScore());
    }
    
    public function testAverageScoreWithNullAnd5Return5()
    {
        $rating1 = $this->getMockBuilder('Rating')
                        ->setMethods(array('getScore'))
                        ->getMock(); 
                        
        $rating1->method('getScore')
                ->will($this->returnValue(null));
                                 
        $rating2 = $this->getMockBuilder('Rating')
                        ->setMethods(array('getScore'))
                        ->getMock();    
                
        $rating2->method('getScore')
                ->will($this->returnValue(5));
        
        $game = $this->getMockBuilder(Game::class)
                     ->setMethods(array('getRatings'))
                     ->getMock();
        
        $game->method('getRatings')
             ->will($this->returnValue([$rating1, $rating2]));
        
        
        // assertions
        $this->assertEquals(5, $game->getAverageScore());
    }
    
    public function testIsRecommendedWithCompatibility2AndScore10ReturnsFalse()
    {
        $game = $this->getMockBuilder(Game::class)
                     ->setMethods(array('getAverageScore', 'getGenreCode'))
                     ->getMock();
        $game->method('getAverageScore')
             ->will($this->returnValue(10));

        $user = $this->getMockBuilder(User::class)
                     ->setMethods(array('getGenreCompatibility'))
                     ->getMock();
        $user->method('getGenreCompatibility')
             ->will($this->returnValue(2));

        // assertions
        $this->assertFalse($game->isRecommended($user));
    }
    
    public function testIsRecommendedWithCompatibility10AndScore10ReturnsFalse()
    {
        $game = $this->getMockBuilder(Game::class)
                     ->setMethods(array('getAverageScore', 'getGenreCode'))
                     ->getMock();
        $game->method('getAverageScore')
             ->will($this->returnValue(10));

        $user = $this->getMockBuilder(User::class)
                     ->setMethods(array('getGenreCompatibility'))
                     ->getMock();
        $user->method('getGenreCompatibility')
             ->will($this->returnValue(10));

        // assertions
        $this->assertTrue($game->isRecommended($user));
    }
    
}