<?php

class PDOLayer{
	
    protected $_connection;
    protected $_className;
    protected $_classProps;
    protected $_insert;
    protected $_update;
    protected $_delete;
    protected $_selectOne;
    protected $_selectAll;
    protected $_DBName = 'catmazon';
    protected $_additions = ['id'];
    protected $_exclusions = ['_connection','_className','_classProps','_exclusions','_additions','_DBName','_insert','_update','_delete','_selectOne','_selectAll'];//list PDOLayer properties here
    
    public function __construct(PDO $connection = null)
    {
        $this->_connection = $connection;
        if ($this->_connection === null) {
            $this->_connection = new PDO('mysql:host=localhost;dbname=' . $this->_DBName, 'root', '');
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        $this->getInfo();
    }

    public function find($id)
    {
        $stmt = $this->_connection->prepare($this->_selectOne);
        $stmt->execute(array($id));
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->_className);
        return $stmt->fetch();
    }

    public function where($assocArray)
    {
        $SQL = $this->_selectAll . ' WHERE ';
        $first = true;
        foreach($assocArray as $key => $value){
            if(!$first)
                $SQL .= 'AND ';
            else
                $first = false;
            $SQL .= "$key=:$key ";
        }
        $stmt = $this->_connection->prepare($SQL);
        $stmt->execute($assocArray);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->_className);
        $returnVal = [];
        while($rec = $stmt->fetch()){
            $returnVal[] = $rec;
        }
        return $returnVal;
    }
    
    //added function to search for a string in a record
    public function whereLike($assocArray)
    {
        $SQL = $this->_selectAll . ' WHERE ';
        $first = true;
        foreach($assocArray as $key => $value){
            if(!$first)
                $SQL .= 'OR ';
            else
                $first = false;
            $SQL .= "$key LIKE $key ";
        }
        $stmt = $this->_connection->prepare($SQL);
        $stmt->execute($assocArray);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->_className);
        $returnVal = [];
        while($rec = $stmt->fetch()){
            $returnVal[] = $rec;
        }
        return $returnVal;
    }

    // //added function to search for a string in a record AND order by another value
    // public function whereOrderBy ($assocArray)
    // {
    //     $asc = array_pop($assocArray);
    //     $orderBy = array_pop($assocArray);
    //     $SQL = $this->_selectAll . ' WHERE ';
    //     $first = true;
    //     foreach($assocArray as $key => $value){
    //         if(!$first)
    //             $SQL .= 'OR ';
    //         else
    //             $first = false;
    //         $SQL .= "$key LIKE $key ";
    //     }
    //     $SQL .= "ORDER BY ".$orderBy. ' ' .$asc;
    //     $stmt = $this->_connection->prepare($SQL);
    //     $stmt->execute($assocArray);
    //     $stmt->setFetchMode(PDO::FETCH_CLASS, $this->_className);
    //     $returnVal = [];
    //     while($rec = $stmt->fetch()){
    //         $returnVal[] = $rec;
    //     }
    //     return $returnVal;
    // }

    public function findAll()
    {
        $stmt = $this->_connection->prepare($this->_selectAll);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->_className);
        $returnVal = [];
        while($rec = $stmt->fetch()){
        	$returnVal[] = $rec;
        }
        return $returnVal;
    }

	public function toArray(){
        $data = [];
        foreach($this->_classProps as $prop)
            $data[$prop] = $this->$prop;
        return $data;
    }

    public function insert(){
        $stmt = $this->_connection->prepare($this->_insert);
        $stmt->execute($this->toArray());
	}

	public function update(){
        $stmt = $this->_connection->prepare($this->_update);
        $stmt->execute($this->toArray());
	}

	public function delete(){
        $stmt = $this->_connection->prepare($this->_delete);
        $stmt->execute(array($this->id));
	}

	public function getInfo(){
		//extract the deriving class name
        $this->_className = get_class($this);
        
        //extract the deriving class properties
        $this->_classProps = [];
		$array = get_object_vars($this);
		foreach ($array as $key => $value) {
			if(!in_array($key, $this->_exclusions))
				$this->_classProps[] = $key;
		}
        
        //count the deriving class properties, and prepare CRUD operations as appropriate
		$num = count($this->_classProps);
		if ($num  > 0){
			$this->_insert 	= 'INSERT INTO ' . $this->_className . '(' . implode(',', $this->_classProps) . ') VALUES (:'. implode(',:', $this->_classProps) . ')';

    // Set up the update string    
            // Special case for update, need place holders instead of '?'
            $setClause = [];
            foreach($this->_classProps as $item)
                $setClause[] = sprintf('%s = :%s', $item, $item);
            $setClause = implode(', ', $setClause);
            $this->_update  = 'UPDATE ' . $this->_className . ' SET ' . $setClause . ' WHERE id = :id';

        }

        $this->_delete      = "DELETE FROM $this->_className WHERE id = ?";
        $this->_selectOne   = "SELECT * FROM $this->_className WHERE id = ?";
        $this->_selectAll   = "SELECT * FROM $this->_className";
    }


    public function preparedStmt ($where, $array){
        $this->_selectAll .= $where;
        $stmt = $this->_connection->prepare($this->_selectAll);
        $stmt->execute($array);
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->_className);
        $returnVal = [];
        while($rec = $stmt->fetch()){
            $returnVal[] = $rec;
        }
        return $returnVal;
    }

    public function select($query){
        $stmt = $this->_connection->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_CLASS, $this->_className);
        return $stmt->fetch();
    }

}

?>