<?php
	class mysqlDbClass {
		public $con;
		function __construct() {
			$this->con = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);
			if (mysqli_connect_errno()){
			  return false;
			} else {
				mysqli_query($this->con,'SET NAMES utf8;');
				return $this->con;
			}
		}
		/*
		*	executeMysqlQuery function made by jas on 2 August 2014 for queries consisting of joins
		*	$completeQuery will be complete query including tables name, order by, group by and limit etc
		*/

		public function execute_mysql_query($completeQuery) {
			if(trim($completeQuery)	!=	'') {
				$query = mysqli_query($this->con,$completeQuery);
				return $query;
			}
		}
		public function select_multiple_query($arr,$tablename){
			return $this->select_query_multiple_where_args($arr,$tablename);
		}
		public function select_multiple($arr,$tablename){
			return $this->select_multiple_where($arr,$tablename,array());
		}
		public function select_multiple_where($arr,$tablename,$arr_where)	{
			$str = '';
			$end_of_arr =  end($arr);
			if(count($arr)>0) {
				$str .= 'SELECT ' ;
				foreach($arr as $row=>$val) {
				$str .= $val;
					if( $val != $end_of_arr){
						$str .= " ,";
					}
				}
				$str .= ' from '.$tablename;
				if(count($arr_where)>0) {
					$str = $str.' where ';
					$arr_key=array_keys($arr_where);
					$arr_key_last=end($arr_key); // getting the end value of array so that "AND" would not be added with last value
					foreach($arr_where as $row=>$val) {
						$str .= $row.' = "'.$val.'" ';
						if( $row != $arr_key_last){
							$str .= ' AND ';
						}
					}
				}
			}
			$query = mysqli_query($this->con,$str);
			$result_array = mysqli_fetch_assoc($query);
			return $result_array;
		}
		public function select_query_multiple_where($arr,$tablename,$arr_where)	{
			//	inline array, table name constant, assoc array where
			return $this->select_query_multiple_where_args($arr,$tablename,$arr_where);
		}

		public function select_query_multiple_where_args($arr,$tablename,$arr_where=array(),$arg='') {
			// $arg: here we can use order by, group by etc. This is the only difference from above function
			$str = '';
			$end_of_arr =  end($arr);

			if(count($arr)>0) {
				$str .= 'SELECT ' ;
				foreach($arr as $row=>$val) {
					$str .= $val;
					if($val != $end_of_arr){
						$str .= " ,";
					}
				}
				$str .= ' from '.$tablename;
				$whereStr	=	'';
				foreach($arr_where as $row=>$val) {
					if($whereStr !=''){
						$whereStr .= ' and ';
					}
					$whereStr .= $row.' = "'.$val.'" ';
				}
			}

			if($whereStr!='') {
				$str .= ' where '.$whereStr.' ';
			}

			if($arg != ''){
				$str .= $arg ;
			}

			$query = mysqli_query($this->con,$str);
			return $query;
		}

		public function InsertInDatabase($arr,$tablename){
			$cols = '';
			$vals = '';
			$str  = '';
			if(count($arr)>0) {
				foreach($arr as $row=>$val) {
						$cols .= $row.', ';
						$vals .= ' "'.$val.'", ';
				}
				$str .= 'insert into '.$tablename.' ('.$cols = substr($cols,0,strlen($cols)-2).') values('.$vals = substr($vals,0,strlen($vals)-2).')';
			}

			mysqli_query($this->con,$str);
			return mysqli_insert_id($this->con);
		}

		public function update_database($arr,$tablename,$id_col,$id)	{
			return $this->update_database_multiple_where($arr,$tablename,array($id_col=>$id));
		}
		public function update_database_multiple_where($arr,$tablename,$arr_where) {
			$str = '';
			if(count($arr)>0) {
				$str .= 'update '.$tablename.' set ';
				foreach($arr as $row=>$val) {
					$str .= $row.' = "'.$val.'", ';
				}
				$str = substr($str,0,strlen($str)-2);
				$str = $str.' where ';
				$arr_key = array_keys($arr_where);
				$arr_key_last = end($arr_key); // getting the end value of array so that "AND" would not be added with last value
				foreach($arr_where as $row=>$val) {
					$str .= $row.' = "'.$val.'" ';
					if( $row != $arr_key_last){
						$str .= ' AND ';
					}
				}
			}
			$query = mysqli_query($this->con,$str);
			if(mysqli_affected_rows($this->con)>0) {
				return true;
			} else {
				return false;
			}
		}
		public function delete_database($tablename , $arr_where){	// Assosiative array
			$str = '';
			if(count($arr_where)>0) {
				$str .= 'DELETE FROM '.$tablename;
				$str  = $str.' where ';
				$end_of_arr_where = end($arr_where); /// getting the end value of array so that "AND" would not be added with last value
				foreach($arr_where as $row=>$val) {
					$str .= $row.' = "'.$val.'" ';
					if($val != $end_of_arr_where){
						$str .= ' AND ';
					}
				}
			}
			$query	=	mysqli_query($this->con,$str);
			if(mysqli_affected_rows($this->con)>0) {
				return true;
			} else {
				return false;
			}
		}

		/*
		 * Function to completly drop the table
		 * @param name of table
		 */

		public function truncate_table($tablename)	{
			$str = "TRUNCATE TABLE ".$tablename;
			mysqli_query($this->con,$str);
		}

		public function get_from_table($tablename,$fetchcolumnname,$cond_col,$cond_col_val)	{
			return $this->get_from_table_multiple_where($tablename,$fetchcolumnname,array($cond_col=>$cond_col_val));
		}

		public function get_from_table_multiple_where($tablename,$fetchcolumnname,$arr_where) {
			$str ='select '.$fetchcolumnname.' from '.$tablename;
			$str 			= $str.' where ';
			$cond			=	'';
			foreach($arr_where as $row=>$val) {
				if($cond!=''){
					$cond .= ' AND ';
				}
				$cond .= $row.' = "'.$val.'" ';
			}
			$str	=	$str.' '.$cond;
			$res = mysqli_query($this->con,$str);
			$row = mysqli_fetch_assoc($res);
			return $row[$fetchcolumnname];
		}

		public function countRecords($tablename,$fetchcolumnname,$whereCond) {
			$query = 'select '.$fetchcolumnname.' from '.$tablename;
			if(trim($whereCond)!='') {
				$query .=  ' '.$whereCond;
			}		//echo $query;

			$res = mysqli_query($this->con,$query);
			return mysqli_num_rows($res);
	   }
	}
?>