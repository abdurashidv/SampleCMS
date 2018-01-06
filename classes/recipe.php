<?php

class Recipe {

    private $result;
    private $query;
    
    public function deleteRecipe(string $catalogID): boolean {
        $this->query = "DELETE FROM catalogs WHERE id = $catalogID";
		$this->result = pg_query($this->query);

        return $this->result != 'FALSE' ? true : false;
    }

    public function createRecipe(string $name, string $login, string $password): boolean {
        if( strlen($name) > 0 && strlen($recipe) > 0 ){
            $this->query = "INSERT INTO catalogs VALUES ('5', '$name','$recipe','$userID')";
            $this->result = pg_query($this->query);

            return $this->result != 'FALSE' ? true : false;
        }

        return false;
    }

    public function editRecipe(string $catalogID, string $name, string $recipe): boolean {
        $this->query = "UPDATE catalogs SET name = $name, recipe = $recipe WHERE id = $catalogID";
		$this->result = pg_query($this->query);

		return $result != 'FALSE' ? true : false;
    }
}

?>
