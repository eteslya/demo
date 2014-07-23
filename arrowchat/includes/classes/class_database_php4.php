<?php

	/*
	|| #################################################################### ||
	|| #                             ArrowChat                            # ||
	|| # ---------------------------------------------------------------- # ||
	|| #    Copyright ©2010-2012 ArrowSuites LLC. All Rights Reserved.    # ||
	|| # This file may not be redistributed in whole or significant part. # ||
	|| # ---------------- ARROWCHAT IS NOT FREE SOFTWARE ---------------- # ||
	|| #   http://www.arrowchat.com | http://www.arrowchat.com/license/   # ||
	|| #################################################################### ||
	*/
	
	function stripos($haystack, $needle) 
	{ 
		$offset=0; 
		return strpos(strtoupper($haystack), strtoupper($needle), $offset); 
	} 

	//***************** MYSQL CLASS **********************
	class QuickDB
	{
		var $con = true;		// for db connection
		var $dbselect = true;		// for db selection
		var $result;		// for mysql result resource id
		var $row;		// for fetched row
		var $rows;		// for number of rows fetched
		var $affected;		// for number of rows affected
		var $insert_id;		// for last inserted id
		var $query;		// for the last run query
		var $show_errors;		// for knowing whether to display errors
		var $emsg;		// for mysql error description
		var $eno;		// for mysql error number
		
		function QuickDB()
		{
		 //destructor
		 register_shutdown_function(array(&$this, '__destruct'));

		 //constructor
		 $argcv = func_get_args();
		 call_user_func_array(array(&$this, '__construct'), $argcv);
		}		
		
		// Intialize the class with connection to db
		function __construct($host, $user, $password, $db, $persistent = false, $show_errors = false)
		{
			if ($show_errors == true)
			{
				$this->show_errors = true;
			}
			
			if ($persistent == true)
			{
				$this->con = @mysql_pconnect($host, $user, $password);
			}
			else
			{
				$this->con = @mysql_connect($host, $user, $password);
			}
			
			if ($this->con)
			{
				$this->dbselect = $result = mysql_select_db($db, $this->con);
				mysql_query("SET NAMES utf8");
				mysql_query("SET CHARACTER SET utf8");
				mysql_query("SET COLLATION_CONNECTION = 'utf8_general_ci'");
				return $result;
			}
			else
			{

			}
		}
		
		// Close the connection to database
		function __destruct()
		{
			$this->close();
		}

		// Close the connection to database
		function close()
		{
			$result = @mysql_close($this->con);
			return $result;
		}
	
		// stores mysql errors
		function setError($msg, $no)
		{
			$this->emsg = $msg;
			$this->eno = $no;
			
			if ($this->show_errors == true)
			{
				print '	<div style="margin-top:5px;margin-bottom:5px;background:#f6f6f6; padding:5px; font-size:13px; font-family:verdana; border:1px solid #cccccc;">
						<span style="color:#ff0000;">MySQL Error Number</span> : ' . $no . '<br />
						<span style="color:#ff0000;">MySQL Error Message</span> : ' . $msg . '</div>';
			}
		}
		
	
		#################################################
		#				General Functions				#
		#################################################
	
		// Runs the SQL query (general execute query function)
		function execute($command)
		{
			
			
			# Params:
			# 		$command = query command
			
			if (!$command)
			{
				exit("No Query Command Specified !!");
			}
			
			$this->query = $command;
			
			// For Operational query
			if 	(
				(stripos($command, "insert ") !== false) ||
				(stripos($command, "update ") !== false) ||
				(stripos($command, "delete ") !== false) ||
				(stripos($command, "replace ") !== false)
				)
			{
				$this->result = mysql_query($command) or $this->setError(mysql_error(), mysql_errno());

				if (stripos($command, "insert ") !== false)
				{
					if ($this->result)
					{
						$this->insert_id = intval(mysql_insert_id());
					}
				}

				if ($this->result)
				{
					$this->affected = intval(mysql_affected_rows());
					// return the number of rows affected
					return $this->result;
				}
			}
			else
			{
				// For Selection query
				$this->result = mysql_query($command) or $this->setError(mysql_error(), mysql_errno());
				if ($this->result)
				{
					$this->rows = @intval(mysql_num_rows($this->result));
					// return the query resource for later processing
					return $this->result;
				}
			}
		}	

		// Gets records from table
		function select($table, $rows = "*", $condition = null, $order = null)
		{
			
			# Params:
			# 		$table = the name of the table
			#		$rows = rows to be selected
			# 		$condition = example: where id = 99
			#		$order = ordering field name

			if (!$table)
			{
				exit("No Table Specified !!");
			}
			
			$sql = "select $rows from $table";

			if($condition)
			{
				$sql .= ' where ' . $condition;
			}
			else if($order)
			{
				$sql .= ' order by ' . $order;
			}

			$this->query = $sql;
			$this->result = mysql_query($sql) or $this->setError(mysql_error(), mysql_errno());

			if ($this->result)
			{
				$this->rows = intval(mysql_num_rows($this->result));
				// return the query resource for later processing
				return $this->result;
			}
		}	


		// Inserts records
		function insert($table, $data)
		{
			
			# Params:
			# 		$table = the name of the table
			# 		$data = field/value pairs to be inserted
			
			if ($table)
			{
				if ($data)
				{
					$this->result = mysql_query("insert into $table set $data") or $this->setError(mysql_error(), mysql_errno());
					$this->query = "insert into $table set $data";

					if ($this->result)
					{
						$this->affected = intval(mysql_affected_rows());
						$this->insert_id = intval(mysql_insert_id());
						// return the number of rows affected
						return $this->affected;
					}
				}
				else
				{
					print "No Data Specified !!";
				}
			}
			else
			{
				print "No Table Specified !!";
			}
		}

		// Updates records
		function update($table, $data, $condition)
		{
			
			# Params:
			# 		$table = the name of the table
			# 		$data = field/value pairs to be updated
			# 		$condition = example: where id = 99

			if ($table)
			{
				if ($data)
				{
					if ($condition)
					{
						$this->result = mysql_query("update $table set $data where $condition") or $this->setError(mysql_error(), mysql_errno());
						$this->query = "update $table set $data where $condition";

						if ($this->result)
						{
							$this->affected = intval(mysql_affected_rows());
							// return the number of rows affected
							return $this->affected;
						}
					}
					else
					{
						print "No Condition Specified !!";
					}
				}
				else
				{
					print "No Data Specified !!";
				}
			}
			else
			{
				print "No Table Specified !!";
			}
		}

		// Deletes records
		function delete($table, $condition)
		{
			
			# Params:
			# 		$table = the name of the table
			# 		$condition = example: where id = 99

			if ($table)
			{
				if ($condition)
				{
					$this->result = mysql_query("delete from $table where $condition") or $this->setError(mysql_error(), mysql_errno());
					$this->query = "delete from $table where $condition";

					if ($this->result)
					{
						$this->affected = intval(mysql_affected_rows());
						// return the number of rows affected
						return $this->affected;
					}
				}
				else
				{
					print "No Condition Specified !!";
				}
			}
			else
			{
				print "No Table Specified !!";
			}
		}

		// returns table data in array
		function load_array()
		{
			$arr = array();
			
			while ($row = mysql_fetch_object($this->result))
			{
				$arr[] = $row;
			}

			return $arr;
		}


		// print a complete table from the specified table
		function get_html($command, $display_field_headers = true, $table_attribs = 'border="0" cellpadding="3" cellspacing="2" style="padding-bottom:5px; border:1px solid #cccccc; font-size:13px; font-family:verdana;"')
		{
			if (!$command)
			{
				exit("No Query Command Specified !!");
			}

			$this->query = $command;
			$this->result = mysql_query($command) or $this->setError(mysql_error(), mysql_errno());
			
			if ($this->result)
			{
				$this->rows = intval(mysql_num_rows($this->result));
				
				$num_fields = mysql_num_fields($this->result);

				print '<br /><br /><div>
						<table ' . $table_attribs . '>'
						. "\n" . '<tr>';

				if ($display_field_headers == true)
				{
					// printing table headers
					for($i = 0; $i < $num_fields; $i++)
					{
						$field = mysql_fetch_field($this->result);
						print "<td bgcolor='#f6f6f6' style=' border:1px solid #cccccc;'><strong style='color:#666666;'>" . ucwords($field->name) . "</strong></td>\n";
					}
					print "</tr>\n";
				}
				
				// printing table rows
				while($row = mysql_fetch_row($this->result))
				{
					print "<tr>";
				
					foreach($row as $td)
					{
						print "<td bgcolor='#f6f6f6'>$td</td>\n";
					}
				
					print "</tr>\n";
				}
				print "</table></div><br /><br />";
			}
		}
		
		
		function last_insert_id()
		{
			if ($this->insert_id)
			{
				return $this->insert_id;
			}
		}
		
		// Counts all records from a table
		function count_all($table)
		{
			if (!$table)
			{
				exit("No Table Specified !!");
			}
			
			$this->result = mysql_query("select count(*) as total from $table") or $this->setError(mysql_error(), mysql_errno());
			$this->query = "select count(*) as total from $table";

			if ($this->result)
			{
				$this->row = mysql_fetch_array($this->result);
				return intval($this->row["total"]);
			}
		}
		
		// Counts records based on specified criteria
		function count_rows($command)
		{
			# Params:
			# 		$command = query command

			if (!$command)
			{
				exit("No Query Command Specified !!");
			}
		
			$this->query = $command;
			$this->result = mysql_query($command) or $this->setError(mysql_error(), mysql_errno());

			if ($this->result)
			{
				return intval(mysql_num_rows($this->result));
			}
		}

		// Updates a row if it exists or adds if it doesn't already exist.
		function insert_update($table, $data, $condition)
		{
			# Params:
			# 		$table = the name of the table
			# 		$data = field/value pairs to be added/updated
			# 		$condition = example: where id = 99

			if ($table)
			{
				if ($data)
				{
					if ($condition)
					{
						if ($this->row_exists("select * from $table where $condition"))
						{
							$this->result = mysql_query("update $table set $data where $condition") or $this->setError(mysql_error(), mysql_errno());
							$this->query = "update $table set $data where $condition";

							if ($this->result)
							{
								$this->affected = intval(mysql_affected_rows());
								// return the number of rows affected
								return $this->affected;
							}
						}
						else
						{
							$this->result = mysql_query("insert into $table set $data") or $this->setError(mysql_error(), mysql_errno());
							$this->query = "insert into $table set $data";

							if ($this->result)
							{
								$this->insert_id = intval(mysql_insert_id());
								$this->affected = intval(mysql_affected_rows());
								// return the number of rows affected
								return $this->affected;
							}
						}
					}
					else
					{
						print "No Condition Specified !!";
					}
				}
				else
				{
					print "No Data Specified !!";
				}
			}
			else
			{
				print "No Table Specified !!";
			}
		}


		// Runs the sql query with claus "limit x, x"
		function select_limited($table, $start, $return_count, $condition = null, $order = null)
		{
			# Params:
			# 		$start = starting row for limit clause
			# 		$return_count = number of records to fetch
			# 		$condition = example: where id = 99
			# 		$order = ordering field name
			
			if ($table && $start >= 0 && $return_count)
			{
				if ($condition)
				{
					if ($order)
					{
						$this->result = mysql_query("select * from $table where $condition order by $order limit $start, $return_count") or $this->setError(mysql_error(), mysql_errno());
						$this->query = "select * from $table where $condition order by $order limit $start, $return_count";
					}
					else
					{
						$this->result = mysql_query("select * from $table where $condition limit $start, $return_count") or $this->setError(mysql_error(), mysql_errno());
						$this->query = "select * from $table where $condition limit $start, $return_count";
					}
				}
				else
				{
					if ($order)
					{
						$this->result = mysql_query("select * from $table order by $order limit $start, $return_count") or $this->setError(mysql_error(), mysql_errno());
						$this->query = "select * from $table order by $order limit $start, $return_count";
					}
					else
					{
						$this->result = mysql_query("select * from $table limit $start, $return_count") or $this->setError(mysql_error(), mysql_errno());
						$this->query = "select * from $table limit $start, $return_count";
					}
				}

				if ($this->result)
				{
					$this->rows = intval(mysql_num_rows($this->result));
					// return the query resource for later processing
					return $this->result;
				}
			}
			else
			{
				print "Parameter Missing !!";
			}
		}	

		
		#################################################
		#				Utility Functions				#
		#################################################
		
		// Fetchs array
		function fetch_array($result)
		{
			return mysql_fetch_array($result);
		}
		
		// Gets table name
		function table_name($result, $i)
		{
			return mysql_tablename($result, $i);
		}

		// Counts rows from last Select query
		function count_select()
		{
			if ($this->rows)
			{
				return $this->rows;
			}
		}

		// Gets the number of affected rows after Operational query has executed
		function count_affected()
		{
			if ($this->affected)
			{
				return $this->affected;
			}
		}

		// Checks whether a table has records		
		function has_rows($table)
		{
			$rows = $this->count_all($table);
			
			if ($rows)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		// Checks whether or not a row exists with specified criteria
		function row_exists($command)
		{
			# Params:
			# 		$command = query command

			if (!$command)
			{
				exit("No Query Command Specified !!");
			}
		
			$this->query = $command;
			$this->result = mysql_query($command) or $this->setError(mysql_error(), mysql_errno());

			if ($this->result)
			{
				if (mysql_num_rows($this->result))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}

		// Returns single fetched row
		function fetch_row($command)
		{

			if (!$command)
			{
				exit("No Query Command Specified !!");
			}

			$this->query = $command;
			$this->result = mysql_query($command) or $this->setError(mysql_error(), mysql_errno());

			if ($this->result)
			{
				$this->rows = intval(mysql_num_rows($this->result));
				$this->row = mysql_fetch_object($this->result);
				return $this->row;
			}
		}
		
		
		// Returns single field value
		function fetch_value($table, $field, $condition = null)
		{

			if (!$table || !$field)
			{
				exit("Arguments Missing !!");
			}

			$query = "select $field from $table";
			
			if ($condition != null)
			{
				$query = "select $field from $table where $condition";
			}
			
			$this->query = $query;
			$this->result = mysql_query($query) or $this->setError(mysql_error(), mysql_errno());

			if ($this->result)
			{
				$this->rows = intval(mysql_num_rows($this->result));
				$this->row = mysql_fetch_object($this->result);
				return $this->row->$field;
			}
		}
		
		
		// Returns the last run query
		function last_query()
		{
			if ($this->query)
			{
				return $this->alert_msg($this->query);
			}
		}
		
		
		// Gets today's date
		function get_date($format = null)
		{
			# Params:
			#		$format = date format like Y-m-d
			
			if ($format)
			{
				$today = date($format);
			}
			else
			{
				$today = date("Y-m-d");
			}
			
			return $today;
		}
		
		// Gets currents time
		function get_time($format = null)
		{
			# Params:
			#		$format = date format like H:m:s
			
			if ($format)
			{
				$time = date($format);
			}
			else
			{
				$time = date("H:m:s");
			}
			
			return $time;
		}

		// Adds slash to the string irrespective of the setting of getmagicquotesgpc
		function escape_string($value)
		{
			if (is_string($value))
			{
				if (get_magic_quotes_gpc())
				{
						$value = stripslashes($value);
				}

				if (!is_numeric($value))
				{
					$value = mysql_real_escape_string($value);
				}
			}
			
			return $value;
		} 
		
		// This function can be used to discard any characters that can be used to manipulate the SQL queries or SQL injection

		/* EXAMPLE USE:
		
			if (is_valid($_REQUEST["username"]) === true && is_valid($_REQUEST["pass"]) === true)
			{
				//login now
			}
		*/
		
		function is_valid($input)
		{
			$input = strtolower($input);
			
			if (str_word_count($input) > 1)
			{
				$loop = "true";
				$input = explode(" ",$input);
			}
			
			$bad_strings = array("'","--","select","union","insert","update","like","delete","1=1","or");
		
			if ($loop)
			{
				foreach($input as $value)
				{
					if (in_array($value, $bad_strings))
					{
					  return false;
					}
					else
					{
					  return true;
					}
				}
			}
			else
			{
				if (in_array($input, $bad_strings))
				{
				  return false;
				}
				else
				{
				  return true;
				}
			}
		}
	
		// lists tables of database
		function list_tables()
		{
			$this->result = mysql_query("show tables");
			$this->query = "show tables";
			
			if ($this->result)
			{
				$tables = array();
				while($row = mysql_fetch_array($this->result))
				{
					$tables[] = $row[0];
				}
				
				foreach ($tables as $table)
				{
					print $table . "<br />";
				}
			}
		}


		// provides info about given table
		function table_info($table)
		{
			if ($table)
			{
				$this->result = mysql_query("select * from $table");
				$this->query = "select * from $table";

				$fields = mysql_num_fields($this->result);
				$rows   = mysql_num_rows($this->result);
				$table = mysql_field_table($this->result, 0);

				print "	The '<strong>" . $table . "</strong>' table has <strong>" . $fields . "</strong> fields and <strong>" . $rows . "</strong>
						record(s) with following fields.\n<br /><ul>";

				for ($i=0; $i < $fields; $i++)
				{
					$type  = mysql_field_type($this->result, $i);
					$name  = mysql_field_name($this->result, $i);
					$len   = mysql_field_len($this->result, $i);
					$flags = mysql_field_flags($this->result, $i);
					
					print "<strong><li>" . $type . " " . $name . " " . $len . " " . $flags . "</strong></li>\n";
				}
				print "</ul>";
				
			}
			else
			{
				print "The table not specified !!";
			}
		}


		// displays any mysql errors generated
		function display_errors()
		{
			if ($this->show_errors == false)
			{
				if ($this->emsg)
				{
					return '<div style="background:#f6f6f6; margin-top:5px;margin-bottom:5px;padding:5px; font-size:13px; font-family:verdana; border:1px solid #cccccc;">
							<span style="color:#ff0000;">MySQL Error Number</span> : ' . $this->eno . '<br />
							<span style="color:#ff0000;">MySQL Error Message</span> : ' . $this->emsg . '</div>';
				}
				else
				{
					return '	<br /><br /><div style="background:#f6f6f6; padding:5px; font-size:13px; font-family:verdana; border:1px solid #cccccc;">
							<strong>No Erros Found !!</strong>
							</div>';
				}
			}
		}

		// to display success message
		function success_msg($msg)
		{
			print '	<br /><br /><div align="center" style="background:#EEFDD7; padding:5px; font-size:13px; font-family:verdana; border:1px solid #8DD607;">
					' . $msg . '
					</div><br />';
		}
	
		// to display failure message
		function failure_msg($msg)
		{
			print '	<br /><br /><div align="center" style="background:#FFF2F2; padding:5px; font-size:13px; font-family:verdana; border:1px solid #FF8080;">
					' . $msg . '
					</div><br />';
		}

		// to display general alert message
		function alert_msg($msg)
		{
			print '	<br /><br /><div align="center" style="background:#FFFFCC; padding:5px; font-size:13px; font-family:verdana; border:1px solid #CCCC33;">
					' . $msg . '
					</div><br />';
		}

	////////////////////////////////////////////////////////
	}
	
	
	//************* MSSQL CLASS **********************
	class QuickMSDB
	{
		var $con 			= null;		// for db connection
		var $dbselect		= null;		// for db selection
		var $result 		= null;		// for mssql result resource id
		var $row 			= null;		// for fetched row
		var $rows 			= null;		// for number of rows fetched
		var $affected 		= null;		// for number of rows affected
		var $insert_id 		= null;		// for last inserted id
		var $query 			= null;		// for the last run query
		var $show_errors 	= null;		// for knowing whether to display errors
		var $emsg 			= null;		// for mssql error description
		var $eno 			= null;		// for mssql error number
		
		
		// Intialize the class with connection to db
		function __construct($host, $user, $password, $db, $persistent = false, $show_errors = false)
		{
			if ($show_errors == true)
			{
				$this->show_errors = true;
			}
			
			if ($persistent == true)
			{
				$this->con = @mssql_pconnect($host, $user, $password);
			}
			else
			{
				$this->con = @mssql_connect($host, $user, $password);
			}
			
			if ($this->con)
			{
				$this->dbselect = $result = mssql_select_db($db, $this->con);
				mssql_query("SET NAMES utf8");
				mssql_query("SET CHARACTER SET utf8");
				mssql_query("SET COLLATION_CONNECTION = 'utf8_general_ci'");
				return $result;
			}
			else
			{
				
			}
		}
		
		// Close the connection to database
		function __destruct()
		{
			$this->close();
		}

		// Close the connection to database
		function close()
		{
			$result = @mssql_close($this->con);
			return $result;
		}
	
		// stores mssql errors
		function setError($msg, $no)
		{
			$this->emsg = $msg;
			$this->eno = $no;
			
			if ($this->show_errors == true)
			{
				print '	<div style="margin-top:5px;margin-bottom:5px;background:#f6f6f6; padding:5px; font-size:13px; font-family:verdana; border:1px solid #cccccc;">
						<span style="color:#ff0000;">MSSQL Error Number</span> : ' . $no . '<br />
						<span style="color:#ff0000;">MSSQL Error Message</span> : ' . $msg . '</div>';
			}
		}
		
	
		#################################################
		#				General Functions				#
		#################################################
	
		// Runs the SQL query (general execute query function)
		function execute($command)
		{
			# Params:
			# 		$command = query command
			
			if (!$command)
			{
				exit("No Query Command Specified !!");
			}
			
			$this->query = $command;
			
			// For Operational query
			if 	(
				(stripos($command, "insert ") !== false) ||
				(stripos($command, "update ") !== false) ||
				(stripos($command, "delete ") !== false) ||
				(stripos($command, "replace ") !== false)
				)
			{
				$this->result = mssql_query($command) or $this->setError(mssql_error(), mssql_errno());

				if (stripos($command, "insert ") !== false)
				{
					if ($this->result)
					{
						$this->insert_id = intval(mssql_insert_id());
					}
				}

				if ($this->result)
				{
					$this->affected = intval(mssql_affected_rows());
					// return the number of rows affected
					return $this->result;
				}
			}
			else
			{
				// For Selection query
				$this->result = mssql_query($command) or $this->setError(mssql_error(), mssql_errno());
				if ($this->result)
				{
					$this->rows = @intval(mssql_num_rows($this->result));
					// return the query resource for later processing
					return $this->result;
				}
			}
		}	

		// Gets records from table
		function select($table, $rows = "*", $condition = null, $order = null)
		{
			# Params:
			# 		$table = the name of the table
			#		$rows = rows to be selected
			# 		$condition = example: where id = 99
			#		$order = ordering field name

			if (!$table)
			{
				exit("No Table Specified !!");
			}
			
			$sql = "select $rows from $table";

			if($condition)
			{
				$sql .= ' where ' . $condition;
			}
			else if($order)
			{
				$sql .= ' order by ' . $order;
			}

			$this->query = $sql;
			$this->result = mssql_query($sql) or $this->setError(mssql_error(), mssql_errno());

			if ($this->result)
			{
				$this->rows = intval(mssql_num_rows($this->result));
				// return the query resource for later processing
				return $this->result;
			}
		}	


		// Inserts records
		function insert($table, $data)
		{
			# Params:
			# 		$table = the name of the table
			# 		$data = field/value pairs to be inserted
			
			if ($table)
			{
				if ($data)
				{
					$this->result = mssql_query("insert into $table set $data") or $this->setError(mssql_error(), mssql_errno());
					$this->query = "insert into $table set $data";

					if ($this->result)
					{
						$this->affected = intval(mssql_affected_rows());
						$this->insert_id = intval(mssql_insert_id());
						// return the number of rows affected
						return $this->affected;
					}
				}
				else
				{
					print "No Data Specified !!";
				}
			}
			else
			{
				print "No Table Specified !!";
			}
		}

		// Updates records
		function update($table, $data, $condition)
		{
			# Params:
			# 		$table = the name of the table
			# 		$data = field/value pairs to be updated
			# 		$condition = example: where id = 99

			if ($table)
			{
				if ($data)
				{
					if ($condition)
					{
						$this->result = mssql_query("update $table set $data where $condition") or $this->setError(mssql_error(), mssql_errno());
						$this->query = "update $table set $data where $condition";

						if ($this->result)
						{
							$this->affected = intval(mssql_affected_rows());
							// return the number of rows affected
							return $this->affected;
						}
					}
					else
					{
						print "No Condition Specified !!";
					}
				}
				else
				{
					print "No Data Specified !!";
				}
			}
			else
			{
				print "No Table Specified !!";
			}
		}

		// Deletes records
		function delete($table, $condition)
		{
			# Params:
			# 		$table = the name of the table
			# 		$condition = example: where id = 99

			if ($table)
			{
				if ($condition)
				{
					$this->result = mssql_query("delete from $table where $condition") or $this->setError(mssql_error(), mssql_errno());
					$this->query = "delete from $table where $condition";

					if ($this->result)
					{
						$this->affected = intval(mssql_affected_rows());
						// return the number of rows affected
						return $this->affected;
					}
				}
				else
				{
					print "No Condition Specified !!";
				}
			}
			else
			{
				print "No Table Specified !!";
			}
		}

		// returns table data in array
		function load_array()
		{
			$arr = array();
			
			while ($row = mssql_fetch_object($this->result))
			{
				$arr[] = $row;
			}

			return $arr;
		}


		// print a complete table from the specified table
		function get_html($command, $display_field_headers = true, $table_attribs = 'border="0" cellpadding="3" cellspacing="2" style="padding-bottom:5px; border:1px solid #cccccc; font-size:13px; font-family:verdana;"')
		{
			if (!$command)
			{
				exit("No Query Command Specified !!");
			}

			$this->query = $command;
			$this->result = mssql_query($command) or $this->setError(mssql_error(), mssql_errno());
			
			if ($this->result)
			{
				$this->rows = intval(mssql_num_rows($this->result));
				
				$num_fields = mssql_num_fields($this->result);

				print '<br /><br /><div>
						<table ' . $table_attribs . '>'
						. "\n" . '<tr>';

				if ($display_field_headers == true)
				{
					// printing table headers
					for($i = 0; $i < $num_fields; $i++)
					{
						$field = mssql_fetch_field($this->result);
						print "<td bgcolor='#f6f6f6' style=' border:1px solid #cccccc;'><strong style='color:#666666;'>" . ucwords($field->name) . "</strong></td>\n";
					}
					print "</tr>\n";
				}
				
				// printing table rows
				while($row = mssql_fetch_row($this->result))
				{
					print "<tr>";
				
					foreach($row as $td)
					{
						print "<td bgcolor='#f6f6f6'>$td</td>\n";
					}
				
					print "</tr>\n";
				}
				print "</table></div><br /><br />";
			}
		}
		
		
		function last_insert_id()
		{
			if ($this->insert_id)
			{
				return $this->insert_id;
			}
		}
		
		// Counts all records from a table
		function count_all($table)
		{
			if (!$table)
			{
				exit("No Table Specified !!");
			}
			
			$this->result = mssql_query("select count(*) as total from $table") or $this->setError(mssql_error(), mssql_errno());
			$this->query = "select count(*) as total from $table";

			if ($this->result)
			{
				$this->row = mssql_fetch_array($this->result);
				return intval($this->row["total"]);
			}
		}
		
		// Counts records based on specified criteria
		function count_rows($command)
		{
			# Params:
			# 		$command = query command

			if (!$command)
			{
				exit("No Query Command Specified !!");
			}
		
			$this->query = $command;
			$this->result = mssql_query($command) or $this->setError(mssql_error(), mssql_errno());

			if ($this->result)
			{
				return intval(mssql_num_rows($this->result));
			}
		}

		// Updates a row if it exists or adds if it doesn't already exist.
		function insert_update($table, $data, $condition)
		{
			# Params:
			# 		$table = the name of the table
			# 		$data = field/value pairs to be added/updated
			# 		$condition = example: where id = 99

			if ($table)
			{
				if ($data)
				{
					if ($condition)
					{
						if ($this->row_exists("select * from $table where $condition"))
						{
							$this->result = mssql_query("update $table set $data where $condition") or $this->setError(mssql_error(), mssql_errno());
							$this->query = "update $table set $data where $condition";

							if ($this->result)
							{
								$this->affected = intval(mssql_affected_rows());
								// return the number of rows affected
								return $this->affected;
							}
						}
						else
						{
							$this->result = mssql_query("insert into $table set $data") or $this->setError(mssql_error(), mssql_errno());
							$this->query = "insert into $table set $data";

							if ($this->result)
							{
								$this->insert_id = intval(mssql_insert_id());
								$this->affected = intval(mssql_affected_rows());
								// return the number of rows affected
								return $this->affected;
							}
						}
					}
					else
					{
						print "No Condition Specified !!";
					}
				}
				else
				{
					print "No Data Specified !!";
				}
			}
			else
			{
				print "No Table Specified !!";
			}
		}


		// Runs the sql query with claus "limit x, x"
		function select_limited($table, $start, $return_count, $condition = null, $order = null)
		{
			# Params:
			# 		$start = starting row for limit clause
			# 		$return_count = number of records to fetch
			# 		$condition = example: where id = 99
			# 		$order = ordering field name
			
			if ($table && $start >= 0 && $return_count)
			{
				if ($condition)
				{
					if ($order)
					{
						$this->result = mssql_query("select * from $table where $condition order by $order limit $start, $return_count") or $this->setError(mssql_error(), mssql_errno());
						$this->query = "select * from $table where $condition order by $order limit $start, $return_count";
					}
					else
					{
						$this->result = mssql_query("select * from $table where $condition limit $start, $return_count") or $this->setError(mssql_error(), mssql_errno());
						$this->query = "select * from $table where $condition limit $start, $return_count";
					}
				}
				else
				{
					if ($order)
					{
						$this->result = mssql_query("select * from $table order by $order limit $start, $return_count") or $this->setError(mssql_error(), mssql_errno());
						$this->query = "select * from $table order by $order limit $start, $return_count";
					}
					else
					{
						$this->result = mssql_query("select * from $table limit $start, $return_count") or $this->setError(mssql_error(), mssql_errno());
						$this->query = "select * from $table limit $start, $return_count";
					}
				}

				if ($this->result)
				{
					$this->rows = intval(mssql_num_rows($this->result));
					// return the query resource for later processing
					return $this->result;
				}
			}
			else
			{
				print "Parameter Missing !!";
			}
		}	

		
		#################################################
		#				Utility Functions				#
		#################################################
		
		// Fetchs array
		function fetch_array($result)
		{
			return mssql_fetch_array($result);
		}
		
		// Gets table name
		function table_name($result, $i)
		{
			return mssql_tablename($result, $i);
		}

		// Counts rows from last Select query
		function count_select()
		{
			if ($this->rows)
			{
				return $this->rows;
			}
		}

		// Gets the number of affected rows after Operational query has executed
		function count_affected()
		{
			if ($this->affected)
			{
				return $this->affected;
			}
		}

		// Checks whether a table has records		
		function has_rows($table)
		{
			$rows = $this->count_all($table);
			
			if ($rows)
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		
		// Checks whether or not a row exists with specified criteria
		function row_exists($command)
		{
			# Params:
			# 		$command = query command

			if (!$command)
			{
				exit("No Query Command Specified !!");
			}
		
			$this->query = $command;
			$this->result = mssql_query($command) or $this->setError(mssql_error(), mssql_errno());

			if ($this->result)
			{
				if (mssql_num_rows($this->result))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
		}

		// Returns single fetched row
		function fetch_row($command)
		{

			if (!$command)
			{
				exit("No Query Command Specified !!");
			}

			$this->query = $command;
			$this->result = mssql_query($command) or $this->setError(mssql_error(), mssql_errno());

			if ($this->result)
			{
				$this->rows = intval(mssql_num_rows($this->result));
				$this->row = mssql_fetch_object($this->result);
				return $this->row;
			}
		}
		
		
		// Returns single field value
		function fetch_value($table, $field, $condition = null)
		{

			if (!$table || !$field)
			{
				exit("Arguments Missing !!");
			}

			$query = "select $field from $table";
			
			if ($condition != null)
			{
				$query = "select $field from $table where $condition";
			}
			
			$this->query = $query;
			$this->result = mssql_query($query) or $this->setError(mssql_error(), mssql_errno());

			if ($this->result)
			{
				$this->rows = intval(mssql_num_rows($this->result));
				$this->row = mssql_fetch_object($this->result);
				return $this->row->$field;
			}
		}
		
		
		// Returns the last run query
		function last_query()
		{
			if ($this->query)
			{
				return $this->alert_msg($this->query);
			}
		}
		
		
		// Gets today's date
		function get_date($format = null)
		{
			# Params:
			#		$format = date format like Y-m-d
			
			if ($format)
			{
				$today = date($format);
			}
			else
			{
				$today = date("Y-m-d");
			}
			
			return $today;
		}
		
		// Gets currents time
		function get_time($format = null)
		{
			# Params:
			#		$format = date format like H:m:s
			
			if ($format)
			{
				$time = date($format);
			}
			else
			{
				$time = date("H:m:s");
			}
			
			return $time;
		}

		// Adds slash to the string irrespective of the setting of getmagicquotesgpc
		function escape_string($value)
		{
			if (is_string($value))
			{
				if(get_magic_quotes_gpc()) 
				{
					$value = stripslashes($value);
				}
				
				$value = str_replace("'", "''", $value);
			}
			
			return $value;
		} 
		
		// This function can be used to discard any characters that can be used to manipulate the SQL queries or SQL injection

		/* EXAMPLE USE:
		
			if (is_valid($_REQUEST["username"]) === true && is_valid($_REQUEST["pass"]) === true)
			{
				//login now
			}
		*/
		
		function is_valid($input)
		{
			$input = strtolower($input);
			
			if (str_word_count($input) > 1)
			{
				$loop = "true";
				$input = explode(" ",$input);
			}
			
			$bad_strings = array("'","--","select","union","insert","update","like","delete","1=1","or");
		
			if ($loop)
			{
				foreach($input as $value)
				{
					if (in_array($value, $bad_strings))
					{
					  return false;
					}
					else
					{
					  return true;
					}
				}
			}
			else
			{
				if (in_array($input, $bad_strings))
				{
				  return false;
				}
				else
				{
				  return true;
				}
			}
		}
	
		// lists tables of database
		function list_tables()
		{
			$this->result = mssql_query("show tables");
			$this->query = "show tables";
			
			if ($this->result)
			{
				$tables = array();
				while($row = mssql_fetch_array($this->result))
				{
					$tables[] = $row[0];
				}
				
				foreach ($tables as $table)
				{
					print $table . "<br />";
				}
			}
		}


		// provides info about given table
		function table_info($table)
		{
			if ($table)
			{
				$this->result = mssql_query("select * from $table");
				$this->query = "select * from $table";

				$fields = mssql_num_fields($this->result);
				$rows   = mssql_num_rows($this->result);
				$table = mssql_field_table($this->result, 0);

				print "	The '<strong>" . $table . "</strong>' table has <strong>" . $fields . "</strong> fields and <strong>" . $rows . "</strong>
						record(s) with following fields.\n<br /><ul>";

				for ($i=0; $i < $fields; $i++)
				{
					$type  = mssql_field_type($this->result, $i);
					$name  = mssql_field_name($this->result, $i);
					$len   = mssql_field_len($this->result, $i);
					$flags = mssql_field_flags($this->result, $i);
					
					print "<strong><li>" . $type . " " . $name . " " . $len . " " . $flags . "</strong></li>\n";
				}
				print "</ul>";
				
			}
			else
			{
				print "The table not specified !!";
			}
		}


		// displays any mssql errors generated
		function display_errors()
		{
			if ($this->show_errors == false)
			{
				if ($this->emsg)
				{
					return '<div style="background:#f6f6f6; margin-top:5px;margin-bottom:5px;padding:5px; font-size:13px; font-family:verdana; border:1px solid #cccccc;">
							<span style="color:#ff0000;">MSSQL Error Number</span> : ' . $this->eno . '<br />
							<span style="color:#ff0000;">MSSQL Error Message</span> : ' . $this->emsg . '</div>';
				}
				else
				{
					return '	<br /><br /><div style="background:#f6f6f6; padding:5px; font-size:13px; font-family:verdana; border:1px solid #cccccc;">
							<strong>No Erros Found !!</strong>
							</div>';
				}
			}
		}

		// to display success message
		function success_msg($msg)
		{
			print '	<br /><br /><div align="center" style="background:#EEFDD7; padding:5px; font-size:13px; font-family:verdana; border:1px solid #8DD607;">
					' . $msg . '
					</div><br />';
		}
	
		// to display failure message
		function failure_msg($msg)
		{
			print '	<br /><br /><div align="center" style="background:#FFF2F2; padding:5px; font-size:13px; font-family:verdana; border:1px solid #FF8080;">
					' . $msg . '
					</div><br />';
		}

		// to display general alert message
		function alert_msg($msg)
		{
			print '	<br /><br /><div align="center" style="background:#FFFFCC; padding:5px; font-size:13px; font-family:verdana; border:1px solid #CCCC33;">
					' . $msg . '
					</div><br />';
		}

	////////////////////////////////////////////////////////
	}

?>