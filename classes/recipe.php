<?php

class Recipe {

    private $result;
    private $query;
    
    public function deleteRecipe(string $catalogID): boolean {
        $this->query = "DELETE FROM catalogs WHERE id = $catalogID";
		$this->result = pg_query($this->query);

        return $this->result != 'FALSE' ? true : false;
    }

    public function createRecipe(string $name, string $recipe, string $userID): boolean {
        $this->query = "INSERT INTO catalogs(name, recipe, userid) VALUES ($name','$recipe','$userID')";
        $this->result = pg_query($this->query);

        return $this->result != 'FALSE' ? true : false;
    }

    public function editRecipe(string $catalogID, string $name, string $recipe): boolean {
        $this->query = "UPDATE catalogs SET name = $name, recipe = $recipe WHERE id = $catalogID";
		$this->result = pg_query($this->query);

		return $result != 'FALSE' ? true : false;
    }
}

?>
