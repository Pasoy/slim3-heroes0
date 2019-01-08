<?php

class HeroMapper extends Mapper
{

    public function getHeroes()
    {
        $sql = "SELECT * FROM heroes";
        $stmt = $this->db->query($sql);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new HeroEntity($row);
        }
        return $results;
    }

    public function getHeroById($hero_id)
    {
        $sql = "SELECT * FROM heroes WHERE hero_id = :hero_id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute(["hero_id" => $hero_id]);
        if ($result) {
            return new HeroEntity($stmt->fetch());
        }
    }

    public function getHeroesByRole($hero_role)
    {
        $sql = "SELECT * FROM heroes WHERE hero_role = :hero_role";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "hero_role" => $hero_role
        ]);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new HeroEntity($row);
        }
        return $results;
    }

    public function getHeroesByAbilities($hero_abilities_from, $hero_abilities_to)
    {
        $sql = "SELECT * FROM heroes WHERE hero_abilities BETWEEN :hero_abilities_from AND :hero_abilities_to";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "hero_abilities_from" => $hero_abilities_from,
            "hero_abilities_to" => $hero_abilities_to
        ]);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new HeroEntity($row);
        }
        return $results;
    }

    public function getHeroesByDifficulty($hero_difficulty)
    {
        $sql = "SELECT * FROM heroes WHERE hero_difficulty = :hero_difficulty";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "hero_difficulty" => $hero_difficulty
        ]);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new HeroEntity($row);
        }
        return $results;
    }

    public function save(HeroEntity $hero)
    {
        $sql = "INSERT INTO heroes (hero_name, hero_role, hero_abilities, hero_difficulty) VALUES (:hero_name, :hero_role, :hero_abilities, :hero_difficulty)";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "hero_name" => $hero->getName(),
            "hero_role" => $hero->getRole(),
            "hero_abilities" => $hero->getAbilities(),
            "hero_difficulty" => $hero->getDifficulty(),
        ]);
        if (!$result) {
            throw new Exception("could not save record");
        }
    }

    public function edit(HeroEntity $hero, HeroEntity $new_hero)
    {
        $sql = "UPDATE heroes SET hero_name = :hero_name, hero_role = :hero_role, hero_abilities = :hero_abilities, hero_difficulty = :hero_difficulty WHERE heroes . hero_id = :hero_id";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "hero_id" => $hero->getId(),
            "hero_name" => $new_hero->getName(),
            "hero_role" => $new_hero->getRole(),
            "hero_abilities" => $new_hero->getAbilities(),
            "hero_difficulty" => $new_hero->getDifficulty(),
        ]);
        if (!$result) {
            throw new Exception("could not edit record");
        }
    }

    public function remove($hero_id)
    {
        $sql = "DELETE FROM heroes WHERE hero_id = :hero_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam("hero_id", $hero_id);
        $result = $stmt->execute();
        if (!$result) {
            throw new Exception("could not remove record");
        }
    }

    public function search($search)
    {
        $sql = "SELECT * FROM heroes WHERE hero_id LIKE :search OR hero_name LIKE :search OR hero_role LIKE :search OR hero_abilities LIKE :search OR hero_difficulty LIKE :search";

        $bind_search = "%" . $search . "%";

        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            ":search" => $bind_search,
        ]);
        if (!$result) {
            throw new Exception("could not search for any record");
        }

        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new HeroEntity($row);
        }
        return $results;
    }

}