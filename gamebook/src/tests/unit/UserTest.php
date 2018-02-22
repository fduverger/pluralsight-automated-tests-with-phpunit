<?php
require __DIR__. "/../../entity/User.php";

use PHPUnit\Framework\TestCase;


class UserTest extends TestCase
{
    public function testGenreCompatibilityWith8And6Returns7()
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

        $user = $this->getMockBuilder(User::class)
                     ->setMethods(array('findRatingsByGenre'))
                     ->getMock();

        $user->method('findRatingsByGenre')
             ->will($this->returnValue([$rating1, $rating2]));

        $this->assertEquals(7, $user->getGenreCompatibility('zombies'));
    }

    public function testRatingsByGenreWith1ZombieAnd1ShooterReturns1Zombie()
    {
        $zombiesGame = $this->getMockBuilder(Game::class)
                            ->setMethods(array('getGenreCode'))
                            ->getMock();
        $zombiesGame->method('getGenreCode')
                    ->will($this->returnValue('zombies'));
    
        $shooterGame = $this->getMockBuilder(Game::class)
                            ->setMethods(array('getGenreCode'))
                            ->getMock();
        $shooterGame->method('getGenreCode')
                    ->will($this->returnValue('shooter'));

        $rating1 = $this->getMockBuilder('Rating')
        ->setMethods(array('getGame'))
        ->getMock(); 
                
        $rating1->method('getGame')
                ->will($this->returnValue($zombiesGame));
                        
        $rating2 = $this->getMockBuilder('Rating')
                        ->setMethods(array('getGame'))
                        ->getMock();    

        $rating2->method('getGame')
                ->will($this->returnValue($shooterGame));

        $user = $this->getMockBuilder(User::class)
                     ->setMethods(array('getRatings'))
                     ->getMock();
        $user->method('getRatings')
             ->will($this->returnValue([$rating1, $rating2]));

        $ratings = $user->findRatingsByGenre('zombies');
        $this->assertCount(1, $ratings);

        foreach($ratings as $rating)
        {
            $this->assertEquals('zombies', $rating->getGame()->getGenreCode());
        }
    }
}