<?php

class User 
{
    protected $ratings;

    public function getRatings()
    {
        return $this->ratings;
    }

    public function findRatingsByGenre($genreCode)
    {
        $filteredRatings = [];
        foreach ($this->getRatings() as $rating) 
        {
            if($rating->getGame()->getGenreCode() == $genreCode)
            {
                $filteredRatings[] = $rating;
            }
        }

        return $filteredRatings;
    }

    public function getGenreCompatibility($genreCode) 
    {
        $ratings = $this->findRatingsByGenre($genreCode);

        $totalRatings = count($ratings);
        if($totalRatings == 0) 
        {
            return null;
        }
        $sum = 0;
        foreach ($ratings as $rating) {
            if($rating->getScore() != null)
            {
                $sum += $rating->getScore();
            }
            else 
            {
                $totalRatings--;
            }
        }
        return $sum / $totalRatings;
    }

}