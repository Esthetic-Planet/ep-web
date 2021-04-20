<?php
     class DatabaseConnection
     {
          var $_hostname;
          var $_username;
          var $_password;
          var $_database;
          var $_resultType;    // 1-array , 2-object, 0-row
          var $_link;
          var $_query;
          var $_result;
          var $_errorstr;
          var $_success;

          function DatabaseConnection($hostname="", $username="", $password="", $database="",$return_result_type=1) {
               $this->_hostname = $hostname;
               $this->_username = $username;
               $this->_password = $password;
               $this->_database = $database;
               if($return_result_type < 0 || $return_result_type > 2 )
                  $this->_resultType = 1;
               else
                  $this->_resultType = $return_result_type;
               $this->_success = false;
          }

          function destroy() {
               unset($this->_hostname);
               unset($this->_username);
               unset($this->_password);
               unset($this->_database);

               unset($this->_resultType);
               unset($this->_query);
               unset($this->_result);
               unset($this->_errorstr);
               unset($this->_success);


          }
		  		function checkDB() 
		 {             
               $link = @mysql_connect( $this->_hostname, $this->_username, $this->_password);
			   if(!$link)
			   		die("<p><b>This site is under maintenance. Please try again after some time or contact administrator of the site.</b></p>");
			  	$db=@mysql_select_db($this->_database,$link);
               if(!$db)			  
			   	 die("<p><b>This site is under maintenance. Please try again after some time or contact administrator of the site.</b></p>");
          }


          function connectDB() {
               $ret = true;
               $this->_link = mysql_pconnect( $this->_hostname, $this->_username, $this->_password);
               if( ! $this->_link ) {
                   $this->_errorstr = "Couldn't connect to database server :".mysql_error($this->_link) ;
                   $ret = false;
               }
               else
               {
                   if(!empty($this->_database)){
                      if( ! mysql_select_db($this->_database, $this->_link) ) {
                         $this->_errorstr = "Couldn't connect database: ".$this->_database." My-SQL Error ".mysql_error($this->_link);
                         $ret = false;
                      }
                   }
               }
               return $ret;
          }

###################################################

 function insert_query($tablename,$valuearray) //inserts records
{

	$this->_link = mysql_connect( $this->_hostname, $this->_username, $this->_password);

   $sql="insert into $tablename (";
   foreach($valuearray as $name => $value)
   {
	 $fieldsname[]=$name;
	 $fieldsval[]=$value;
   }

   $sqlfield =$fieldsname[0];
   for($i=1;$i<count($fieldsname);$i++)
   {
	 $sqlfield .=",".$fieldsname[$i];
   }

	$sqlval ="'".$fieldsval[0]."'";
 for($i=1;$i<count($fieldsval);$i++)
 {
   $sqlval .=",'".$fieldsval[$i]."'";
   }

   $sql.=$sqlfield.") values (".$sqlval.")";


   return $this->execute_query($sql);

}

function update_query($tablename,$valuearray,$condition) //inserts records
{

   $sql_db="update $tablename set ";
   foreach($valuearray as $name => $value)
   {
	 $fieldsname[]=$name;
	 $fieldsval[]=$value;

   }

   $sql_db.="$fieldsname[0]='$fieldsval[0]'";
   for($i=1;$i<count($fieldsname);$i++)
   {
	  $sql_db.=", $fieldsname[$i]='$fieldsval[$i]'";
   }

	$sql_db .=" $condition";	
	//echo "===".$sql_db;
//	die("AAAAAAAAAAAAAA");
   return $this->execute_query($sql_db);

}



          function changeDatabase($dbname="")
          {
              $ret = true;
              if(!empty($dbname)){
                 if( ! mysql_select_db($dbname, $this->_link) ) {
                     $this->_errorstr = "Couldn't change database: ".$this->_database." My-SQL Error ".mysql_error($this->_link);
                     $ret = false;
                 }
                 else
                   $this->_database = $dbname;
              }
              return $ret;
          }

          function changeReturnResultType($return_result_type=1)
          {
              if($return_result_type < 0 || $return_result_type > 2 )
                  $this->_resultType = 1;
               else
                  $this->_resultType = $return_result_type;
          }

          function changeUser( $user="", $passwd="", $database="" )
          {
              if(@mysql_change_user($user,$passwd,$database,$this->_link)){
                 $this->_username = $user;
                 $this->_password = $passwd;
                 $this->_database = $database;
                 return true;
              }
              else
                 return false;
          }

          function getActiveUser()
          {
              return $this->_username;
          }

          function getActiveDatabase()
          {
              return $this->_database;
          }

          function showLastQuery()
          {
              echo "<BR>Last Executed Query = ".$this->_query;
              echo "<BR>Execution Status = ".$this->_success."<BR>";

          }

          function show_error()
          {
                     echo $this->_errorstr;					
          }

          function disconnectDB()
          {
               if($this->_link)
                   @mysql_close( $this->_link );
          }

          function execute_query( $query )
          {
               if(!empty($this->_database)){
                  if(!mysql_select_db($this->_database, $this->_link) ) {
                     $this->_errorstr = "Couldn't change database: ".$this->_database." My-SQL Error ".mysql_error($this->_link);
                  }
               }
               $this->_errorstr = "";
               $this->_query = $query;
               $this->_result = mysql_query( $this->_query, $this->_link );
               if ( ! $this->_result )
               {
                    $this->_errorstr = "Error : ".mysql_error( $this->_link );
                    $this->_success = false;
               }
               else
                   $this->_success = true;
               return $this->_success;
          }

          function inserted_id()
          {
               return @mysql_insert_id($this->_link);
          }
          function affected_rows()
          {
               return @mysql_affected_rows($this->_link);
          }
          function free_result()
          {
                   @mysql_free_result( $this->_result );
          }

          function fetch_records()
          {
               $records = false;
               if( $this->count_records() != 0 )
               {
                  if($this->_resultType == 2){
                    while ( $rec = mysql_fetch_object( $this->_result ) )
                    {
                           $records[] = $rec;
                    }
                  }
                  elseif($this->_resultType == 1 ){
                    while ( $rec = mysql_fetch_array( $this->_result ) )
                    {
                           $records[] = $rec;
                    }
                  }
                  elseif($this->_resultType == 0 ){
                    while ( $rec = mysql_fetch_row( $this->_result ) )
                    {
                           $records[] = $rec;
                    }
                  }
               }
               else
                   $this->_errorstr = "Error: Empty Result Set ";
               unset( $rec );
               return $records;
          }

         function fetch_one_record()
         {
               $records = false;
               if( $this->count_records() > 0 ){
                    if($this->_resultType == 2 )
                       $records =  mysql_fetch_object( $this->_result );
                    elseif($this->_resultType == 1 )
                       $records =  mysql_fetch_array( $this->_result );
                    elseif($this->_resultType == 0 )
                       $records =  mysql_fetch_row( $this->_result );
               }
               else
                   $this->_errorstr = "Error: Empty Result Set ";
               return $records;
         }


###################################################
         function count_records()
         {
               if( $this->_result )
                   return @mysql_num_rows( $this->_result );
               else
                   return 0;
         }

         function objectDestroy() {
            if( $this->count_records() !=0 )
              $this->free_result();
              $this->disconnectDB();
              $this->destroy();
          }
     } // Class Ends

     //register_shutdown_function( "objectDestroy" );
////////////////////////////////////////////////////////////////////////////////

?>
