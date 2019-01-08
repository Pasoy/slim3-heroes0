<?php

class HeroEntity
{
    protected $id;
    protected $name;
    protected $role;
    protected $abilities;
    protected $difficulty;

    public function __construct(array $data)
    {
        if (isset($data['hero_id'])) {
            $this->id = $data['hero_id'];
        }
        $this->name = $data['hero_name'];
        $this->role = $data['hero_role'];
        $this->abilities = $data['hero_abilities'];
        $this->difficulty = $data['hero_difficulty'];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function getAbilities()
    {
        return $this->abilities;
    }

    public function getDifficulty()
    {
        return $this->difficulty;
    }
}