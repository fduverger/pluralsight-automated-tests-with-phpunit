<?php

class Game {
    protected $title;
    protected $imagePath;
    protected $ratings;
    protected $id;

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    public function isRecommended($user) 
    {
        $compatibility = $user->getGenreCompatibility($this->getGenreCode());
        return $this->getAverageScore()/ 10 * $compatibility >= 3;
    }

    public function getAverageScore() 
    {
        $ratings = $this->getRatings();

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

    public function toArray()
    {
        $array = array(
            'title' => $this->getTitle(),
            'imagePath' => $this->getImagePath(),
            'ratings' => []
        );

        foreach ($this->getRatings() as $rating) {
            $array['ratings'][] = $rating->toArray();
        }

        return $array;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of imagePath
     */ 
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * Set the value of imagePath
     *
     * @return  self
     */ 
    public function setImagePath($imagePath)
    {
        $imagePath = $imagePath ?? "/images/placeholder.jpg";

        $this->imagePath = "$imagePath";

        return $this;
    }

    /**
     * Get the value of rating
     */ 
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * Set the value of rating
     *
     * @return  self
     */ 
    public function setRatings($ratings)
    {
        $this->ratings = $ratings;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }
}