<?php
 
if(!defined('BASE'))exit("direct access not allow");

class admin_table extends model{



     function __construct(){
          $this->load->database();

     }

     function insertData($add,$table)
     {
          $sql=$this->db->insert($table, $add);
          $this->db->query($sql);

     }
	 
	 function unversel_check($table, $column="*", $where=array(),$order="",$limit=0, $condition=""){
	    $query=$this->db->select($table,$column,$where,$order,$limit, $condition);
	    $count=$this->db->query($query);
	    return $count->num_rows();
	 }
	 
	 function unversel_selection($table, $column="*", $where=array(),$order="",$limit=0, $condition="",$offset=0){
	    $query=$this->db->select($table,$column,$where,$order,$limit, $condition,$offset);
	    $str=$this->db->query($query);
	    return $str->result_array();
	 }
      
      function deleteData($table,$id=""){
		if($id==""){
				$query=$this->db->query("DELETE FROM ".$table);
		}else{
			$query=$this->db->query("DELETE FROM ".$table." WHERE id='".$id."'");
		}
        return $query;
    }
    
    function updateData($table,$id,$boolean=array()){
      if(count($boolean)>0){
         foreach($boolean as $key => $value){
           $this->db->query("UPDATE ".$table." SET ".$key." = '".$value."' WHERE id='".$id."'");
         }
      }
  }
  function data_query($str){
      $query = $this->db->query($str);
      return $query->result_array();
  }

  function auto_table($table,$arr=array()){
      $tab = "CREATE TABLE IF NOT EXISTS ".$table."(id INT NOT NULL AUTO_INCREMENT,".implode(',',$arr).",Time_Add TIMESTAMP NOT NULL DEFAULT '2020-01-31 00:00:00',PRIMARY KEY(id))";
      $this->db->query($tab);
  }

  function del_table($table){
     $tab = "DROP TABLE IF EXISTS ".$table;
     $this->db->query($tab);
  }

   function table()
   {
  
		$page1="CREATE TABLE IF NOT EXISTS admin_tables(id INT NOT NULL AUTO_INCREMENT,Name VARCHAR(255) NOT NULL, Gender VARCHAR(100) NOT NULL,Username VARCHAR(255) NOT NULL,
			Password VARCHAR(255) NOT NULL, Email VARCHAR(255) NOT NULL,Pnumber VARCHAR(20) NOT NULL,Posi VARCHAR(10) NOT NULL,
            Time_Add TIMESTAMP NOT NULL DEFAULT '2020-01-31 00:00:00',PRIMARY KEY(id))";
        $page2="CREATE TABLE IF NOT EXISTS teachers_tables(id INT NOT NULL AUTO_INCREMENT,Fname VARCHAR(255) NOT NULL, Sex VARCHAR(50) NOT NULL,Password VARCHAR(255) NOT NULL, Email VARCHAR(255) NOT NULL, Pnumber VARCHAR(20) NOT NULL, Type VARCHAR(255) NOT NULL, ClassName VARCHAR(255), ClassNameEx VARCHAR(255), SubjectNameEx VARCHAR(225), Posi VARCHAR(255) NOT NULL,ImageName VARCHAR(255) NOT NULL,Time_Add TIMESTAMP NOT NULL DEFAULT '2020-01-31 00:00:00',PRIMARY KEY(id))";
        $page3 = "CREATE TABLE IF NOT EXISTS folder_tables(id INT NOT NULL AUTO_INCREMENT,Image VARCHAR(255) NOT NULL,Type VARCHAR(255) NOT NULL,Time_Add TIMESTAMP NOT NULL DEFAULT '2020-01-31 00:00:00',PRIMARY KEY(id))";
        $page4 = "CREATE TABLE IF NOT EXISTS classes_tables(id INT NOT NULL AUTO_INCREMENT,ClassName TEXT NOT NULL,Section VARCHAR(255) NOT NULL,Time_Add TIMESTAMP NOT NULL DEFAULT '2020-01-31 00:00:00',PRIMARY KEY(id))";
        $page5 = "CREATE TABLE IF NOT EXISTS subject_tables(id INT NOT NULL AUTO_INCREMENT,SubjectName TEXT NOT NULL,Section VARCHAR(255) NOT NULL,Time_Add TIMESTAMP NOT NULL DEFAULT '2020-01-31 00:00:00',PRIMARY KEY(id))";
        $page6="CREATE TABLE IF NOT EXISTS nursery_tables(id INT NOT NULL AUTO_INCREMENT,Fname VARCHAR(255) NOT NULL,Sex VARCHAR(50) NOT NULL,Session VARCHAR(50) NOT NULL,Term VARCHAR(50) NOT NULL,ClassName VARCHAR(50) NOT NULL,Subject TEXT NOT NULL,Password VARCHAR(255) NOT NULL, ParentName VARCHAR(255) NOT NULL, ParentPhone VARCHAR(20) NOT NULL, Address VARCHAR(255) NOT NULL,Religious VARCHAR(255) NOT NULL,Post VARCHAR(255) NOT NULL,ImageName VARCHAR(255) NOT NULL,Time_Add TIMESTAMP NOT NULL DEFAULT '2020-01-31 00:00:00',PRIMARY KEY(id))";
        $page7="CREATE TABLE IF NOT EXISTS primary_tables(id INT NOT NULL AUTO_INCREMENT,Fname VARCHAR(255) NOT NULL,Sex VARCHAR(50) NOT NULL,Session VARCHAR(50) NOT NULL,Term VARCHAR(50) NOT NULL,ClassName VARCHAR(50) NOT NULL,Subject TEXT NOT NULL,Password VARCHAR(255) NOT NULL, ParentName VARCHAR(255) NOT NULL, ParentPhone VARCHAR(20) NOT NULL, Address VARCHAR(255) NOT NULL,Religious VARCHAR(255) NOT NULL,Post VARCHAR(255) NOT NULL,ImageName VARCHAR(255) NOT NULL,Time_Add TIMESTAMP NOT NULL DEFAULT '2020-01-31 00:00:00',PRIMARY KEY(id))";
        $page8="CREATE TABLE IF NOT EXISTS secondary_tables(id INT NOT NULL AUTO_INCREMENT,Fname VARCHAR(255) NOT NULL,Sex VARCHAR(50) NOT NULL,Session VARCHAR(50) NOT NULL,Term VARCHAR(50) NOT NULL,ClassName VARCHAR(50) NOT NULL,Subject TEXT NOT NULL,Password VARCHAR(255) NOT NULL, ParentName VARCHAR(255) NOT NULL, ParentPhone VARCHAR(20) NOT NULL, Address VARCHAR(255) NOT NULL,Religious VARCHAR(255) NOT NULL,Post VARCHAR(255) NOT NULL,ImageName VARCHAR(255) NOT NULL,Time_Add TIMESTAMP NOT NULL DEFAULT '2020-01-31 00:00:00',PRIMARY KEY(id))";
        $page9="CREATE TABLE IF NOT EXISTS pins_table(id INT NOT NULL AUTO_INCREMENT,Fname VARCHAR(255) NOT NULL,Pins VARCHAR(50) NOT NULL,Session VARCHAR(50) NOT NULL,Term VARCHAR(50) NOT NULL,ClassName VARCHAR(50) NOT NULL,Time_Add TIMESTAMP NOT NULL DEFAULT '2020-01-31 00:00:00',PRIMARY KEY(id))";
        $this->db->query($page1);
        $this->db->query($page2);
        $this->db->query($page3);
        $this->db->query($page4);
        $this->db->query($page5);
        $this->db->query($page6);
        $this->db->query($page7);
        $this->db->query($page8);
        $this->db->query($page9);
   }
}

?>