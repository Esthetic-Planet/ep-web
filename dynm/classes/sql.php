<?php
class sql
{
	function sql()
	{	
	}
	
	// Core Functions begin
	function SqlInsert($tblName,$arrData)			
	{
		$ArrData = array();			
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$db->insert_query($tblName,$arrData);
		$last_inserted_id = $db->inserted_id();
		return $last_inserted_id;
	}

	function SqlUpdate($tblName,$arrData,$arrCond)
	{			
		$ArrData = array();			
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$db->update_query($tblName,$arrData,$arrCond);
		$_CNT = $db->affected_rows();			
		$ArrData['count'] = $_CNT;		 
		$db->objectDestroy();
		return $ArrData['count'];
	}
	
	function SqlDelete($tblName,$cond)
	{			
		$ArrData = array();			
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$query = "delete from ".$tblName ." WHERE " . $cond;			
		$db->execute_query($query);				
		$_CNT = $db->affected_rows();			
		$ArrData['count'] = $_CNT;		 
		$db->objectDestroy();
		return $ArrData;
	}
	// core functions end.

	function SqlSingleRecord($tbl,$cond)
	{
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$query = "select * from $tbl $cond";
		$db->execute_query($query);
		$_CNT = $db->count_records();
		$_REC = $db->fetch_one_record();
		$ArrData['count'] = $_CNT;
		$ArrData['Data'] = $_REC; 
		$db->objectDestroy();
		return $ArrData;
	}
	
	function SqlRecords($tbl,$cond,$orderby="",$OffSet=0,$Limit=50)
	{
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$query = "select * from $tbl $cond $orderby";
		$db->execute_query($query);
		$_T_CNT = $db->count_records();		
		$query = "select * from $tbl $cond $orderby LIMIT $OffSet,$Limit";
		$db->execute_query($query);			
		$_REC = $db->fetch_records();
		$_CNT = $db->count_records();

		$ArrData['TotalCount'] = $_T_CNT;
		$ArrData['count'] = $_CNT;
		$ArrData['Data'] = $_REC; 
		$db->objectDestroy();
		return $ArrData;
	}

	function SqlRecordMisc($tbl,$cond)
	{
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		 $query = "select * from $tbl $cond";
		$db->execute_query($query);			
		$_REC = $db->fetch_records();
			
		////////////////
		if(!is_array($_REC))
		{
			$_REC=array();
		}
		//////////////////
		$_CNT = $db->count_records();			
		$ArrData['count'] = $_CNT;
		$ArrData['Data'] = $_REC; 
		$db->objectDestroy();
		return $ArrData;
	}
	
	function SqlCheckAdminLogin($userid,$pass)
	{			
		$ArrData = array();			
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$query = "select * from esthp_tblUsers where LoginEmail = '$userid' and binary Password='$pass' and IsActive='t'";

		$db->execute_query($query);
		$_REC = $db->fetch_records();
		$_CNT = $db->count_records();
		$ArrData['count'] = $_CNT;
		$ArrData['Data'] = $_REC; 
		$db->objectDestroy();
		return $ArrData;
	}
		
	function SqlCheckUserLogin($userid,$pass)
	{			
		$ArrData = array();			
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$query = "select * from esthp_tblCustomers where cust_email = '$userid' and binary cust_password='$pass' and cust_status='active'";

		$db->execute_query($query);
		$_REC = $db->fetch_records();
		$_CNT = $db->count_records();
		$ArrData['count'] = $_CNT;
		$ArrData['Data'] = $_REC; 
		$db->objectDestroy();
		return $ArrData;
	}

	function SqlGetAdminPasswd($email)
	{			
		$ArrData = array();			
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$query = "select * from esthp_tblUsers where LoginEmail = '$email'";
		$db->execute_query($query);
		$_REC = $db->fetch_records();
		$_CNT = $db->count_records();
		$ArrData['count'] = $_CNT;
		$ArrData['Data'] = $_REC; 
		$db->objectDestroy();
		return $ArrData;
	}
		
	function SqlGetUserPasswd($email)
	{			
		$ArrData = array();			
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$query = "select * from esthp_tblCustomers where cust_email = '$email'";
		$db->execute_query($query);
		$_REC = $db->fetch_records();
		$_CNT = $db->count_records();
		$ArrData['count'] = $_CNT;
		$ArrData['Data'] = $_REC; 
		$db->objectDestroy();
		return $ArrData;
	}
		
	function SqlSuperAdmin()
	{			
		$ArrData = array();			
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$query = "select * from esthp_tblUsers where UserId = '1'";
		$db->execute_query($query);
		$_REC = $db->fetch_records();
		$_CNT = $db->count_records();
		$ArrData['count'] = $_CNT;
		$ArrData['Data'] = $_REC; 
		$db->objectDestroy();
		return $ArrData;
	}
		
	function SqlFranchise($franchiseID)
	{			
		$ArrData = array();			
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$query = "select * from esthp_tblUsers where UserId = '".$franchiseID."'";
		$db->execute_query($query);
		$_REC = $db->fetch_records();
		$_CNT = $db->count_records();
		$ArrData['count'] = $_CNT;
		$ArrData['Data'] = $_REC; 
		$db->objectDestroy();
		return $ArrData;
	}

	//check user existance on add user
	function checkUserExists($LoginEmail)
	{
		$strReturn=FALSE;
		$ArrData = array();			
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$query = "select * from esthp_tblUsers where LoginEmail = '$LoginEmail' ";
		$db->execute_query($query);
		$_REC = $db->fetch_records();
		$_CNT = $db->count_records();
		if($_CNT>0)
		{
			$strReturn=TRUE;
		}
		$db->objectDestroy();
		return $strReturn;
	}

	//check user existance on update user
	function checkUserExistsonUpdate($LoginEmail,$UserId)
	{
		$strReturn=FALSE;
		$ArrData = array();			
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$query = "select * from esthp_tblUsers where LoginEmail = '$LoginEmail'  AND UserId !='$UserId'";
		$db->execute_query($query);
		$_REC = $db->fetch_records();
		$_CNT = $db->count_records();
		if($_CNT>0)
		{
			$strReturn=TRUE;
		}
		$db->objectDestroy();
		return $strReturn;
	}		
	
	//check customer email exists on insert
	function checkCustExistsInsert($LoginEmail)
	{
		$strReturn=FALSE;
		$ArrData = array();			
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$query = "select * from esthp_tblCustomers where cust_email = '$LoginEmail' ";
		$db->execute_query($query);
		$_REC = $db->fetch_records();
		$_CNT = $db->count_records();
		if($_CNT>0)
		{
			$strReturn=TRUE;
		}
		$db->objectDestroy();
		return $strReturn;
	}

	//check customer email exists on update
	function checkCustExistsUpdate($LoginEmail,$custID)
	{
		$strReturn=FALSE;
		$ArrData = array();			
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$query = "select * from esthp_tblCustomers where cust_email = '$LoginEmail'  AND cust_id !='$custID'";
		$db->execute_query($query);
		$_REC = $db->fetch_records();
		$_CNT = $db->count_records();
		if($_CNT>0)
		{
			$strReturn=TRUE;
		}
		$db->objectDestroy();
		return $strReturn;
	}		
	
	function cartProductExists($prodID,$sessionID,$cartStatus)
	{
		$strReturn=FALSE;
		$ArrData = array();			
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$query = "select * from esthp_tblCart where cart_session_id= '".$sessionID."'  and cart_prod_id='".$prodID."' and cart_status='".$cartStatus."'";
		$db->execute_query($query);
		$_REC = $db->fetch_records();
		$_CNT = $db->count_records();
		if($_CNT>0)
		{
			$strReturn=TRUE;
		}
		$db->objectDestroy();
		return $strReturn;
	}	
		
	function cartProductsCount($sessionID,$cartStatus,$franchiseID)
	{
		$totProds=0;
		$ArrData = array();			
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$query = "select * from esthp_tblCart where cart_session_id= '".$sessionID."'  and cart_status='".$cartStatus."' and cart_franchise_id='".$franchiseID."'";
		$db->execute_query($query);
		$_REC = $db->fetch_records();
		$_CNT = $db->count_records();
		if($_CNT>0)
		{
			foreach($_REC as $_REC_ARR)
			{
				$totProds+= $_REC_ARR['cart_prod_quantity'];
			}
		}
		$db->objectDestroy();
		return $totProds;
	}	
	
	function cartTotalPrice($sessionID,$cartStatus,$franchiseID)
	{
		$totPrice=0;
	
		$ArrData = array();			
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$query = "select * from esthp_tblCart where cart_session_id= '".$sessionID."'  and cart_status='".$cartStatus."' and cart_franchise_id='".$franchiseID."'";
		$db->execute_query($query);
		$_REC = $db->fetch_records();
		$_CNT = $db->count_records();
		if($_CNT>0)
		{
			foreach($_REC as $_REC_ARR)
			{
				$totPrice=$totPrice+($_REC_ARR['cart_prod_price']*$_REC_ARR['cart_prod_quantity']);
			}
		}
		$db->objectDestroy();
		return $totPrice;
	}	
	
	function SqlExecuteQuery ($query)
	{
		//echo "====".$query;
		$db = new DatabaseConnection(_HOST,_USER,_PASS,_DB);
		$db->connectDB();
		$db->execute_query($query) or die(mysql_error());			
		$_REC = $db->fetch_records();
		$_CNT = $db->count_records();			
		$ArrData['count'] = $_CNT;
		$ArrData['Data'] = $_REC; 
		$db->objectDestroy();
		return $ArrData;
	}		
}
$sql = new sql();
?>