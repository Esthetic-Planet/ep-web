<table width="100%" border="0" cellspacing="0" cellpadding="0" >
<tr>
	<td valign="middle" class="left_headbg"><a href="home.php" class="white_link pad15">Home</a></td>
</tr>
<tr>
	<td valign="top">&nbsp;</td>
</tr>

<tr>
	<td valign="top">
		<table width="205" border="0" align="center" cellpadding="0" cellspacing="0">
		<?php
if($_SESSION['AdminInfo']['is_superadmin']==1)
{
?>
	 	<tr>
			<td height="20" align="left" valign="baseline"><img src="images/orange_bullets.gif" alt="" width="9" height="9"></td>
			<td align="left" valign="baseline"><a href="list-user-categories.php" class="left_link">Manage Clinic Categories</a></td>
		</tr>
		<tr>
			<td height="20" align="left" valign="baseline">&nbsp;</td>
			<td align="left" valign="baseline"><a href="add-user-category.php" class="grey_link">Add Clinic Category</a></td>
		</tr>
		<tr>
			<td height="20" align="left" valign="baseline">&nbsp;</td>
			<td align="left" valign="baseline"><a href="list-user-categories.php" class="grey_link">List Clinic Categories</a></td>
		</tr>
		<tr>
			<td height="20" colspan="2" align="left"><img src="images/spacer.gif" alt="" width="1" height="10"></td>
		</tr>
		<tr>
			<td height="20" align="left" valign="baseline"><img src="images/orange_bullets.gif" alt="" width="9" height="9"></td>
			<td align="left" valign="baseline"><a href="list-user.php" class="left_link">Manage Clinics</a></td>
		</tr>
		<tr>
			<td height="20" align="left" valign="baseline">&nbsp;</td>
			<td align="left" valign="baseline"><a href="add-user.php" class="grey_link">Register Clinic</a></td>
		</tr>
		<tr>
			<td height="20" align="left" valign="baseline">&nbsp;</td>
			<td align="left" valign="baseline"><a href="list-user.php" class="grey_link">List Clinics</a></td>
		</tr>
		<tr>
			<td height="20" colspan="2" align="left"><img src="images/spacer.gif" alt="" width="1" height="10"></td>
		</tr>
		<tr>
			<td height="20" align="left" valign="baseline"><img src="images/orange_bullets.gif" alt="" width="9" height="9"></td>
			<td align="left" valign="baseline"><a href="list-customers.php" class="left_link">Manage Users</a></td>
		</tr>
		<tr>
			<td height="20" align="left" valign="baseline">&nbsp;</td>
			<td align="left" valign="baseline"><a href="add-customer.php" class="grey_link">Register User</a></td>
		</tr>
		<tr>
			<td height="20" align="left" valign="baseline">&nbsp;</td>
			<td align="left" valign="baseline"><a href="list-customers.php" class="grey_link">List Users</a></td>
		</tr>
		<tr>
			<td height="20" colspan="2" align="left"><img src="images/spacer.gif" alt="" width="1" height="10"></td>
		</tr>
		<tr>
			<td height="20" align="left" valign="baseline"><img src="images/orange_bullets.gif" alt="" width="9" height="9"></td>
			<td align="left" valign="baseline"><a href="inbox.php" class="left_link">Message Center</a></td>
        </tr>
		<tr>
			<td height="20" align="left" valign="baseline">&nbsp;</td>
			<td align="left" valign="baseline"><a href="inbox.php" class="grey_link">Inbox</a></td>
        </tr>
		<tr>
			<td height="20" align="left" valign="baseline">&nbsp;</td>
			<td align="left" valign="baseline"><a href="outbox.php" class="grey_link">Sent Mails</a></td>
        </tr>
		<tr>
			<td height="20" align="left" valign="baseline">&nbsp;</td>
			<td align="left" valign="baseline"><a href="compose.php" class="grey_link">Compose</a></td>
        </tr>
<?php
}
else if($_SESSION['AdminInfo']['is_superadmin']==0)
{
?>
		<tr>
			<td height="20" align="left" valign="baseline"><img src="images/orange_bullets.gif" alt="" width="9" height="9"></td>
			<td align="left" valign="baseline"><a href="list-user.php" class="left_link">Manage Clinics</a></td>
		</tr>
		<tr>
			<td height="20" align="left" valign="baseline">&nbsp;</td>
			<td align="left" valign="baseline"><a href="list-user.php" class="grey_link">List Clinics</a></td>
		</tr>
		<tr>
			<td height="20" colspan="2" align="left"><img src="images/spacer.gif" alt="" width="1" height="10"></td>
		</tr>
		<tr>
			<td height="20" align="left" valign="baseline"><img src="images/orange_bullets.gif" alt="" width="9" height="9"></td>
			<td align="left" valign="baseline"><a href="list-customers.php" class="left_link">Manage Users</a></td>
		</tr>
		<tr>
			<td height="20" align="left" valign="baseline">&nbsp;</td>
			<td align="left" valign="baseline"><a href="list-customers.php" class="grey_link">List Users</a></td>
		</tr>
		<tr>
			<td height="20" colspan="2" align="left"><img src="images/spacer.gif" alt="" width="1" height="10"></td>
		</tr>
		<tr>
			<td height="20" align="left" valign="baseline"><img src="images/orange_bullets.gif" alt="" width="9" height="9"></td>
			<td align="left" valign="baseline"><a href="inbox.php" class="left_link">Message Center</a></td>
        </tr>
		<tr>
			<td height="20" align="left" valign="baseline">&nbsp;</td>
			<td align="left" valign="baseline"><a href="inbox.php" class="grey_link">Inbox</a></td>
        </tr>
		<tr>
			<td height="20" align="left" valign="baseline">&nbsp;</td>
			<td align="left" valign="baseline"><a href="outbox.php" class="grey_link">Sent Mails</a></td>
        </tr>
		<tr>
			<td height="20" align="left" valign="baseline">&nbsp;</td>
			<td align="left" valign="baseline"><a href="compose.php" class="grey_link">Compose</a></td>
        </tr>
		<tr>
			<td height="20" colspan="2" align="left"><img src="images/spacer.gif" alt="" width="1" height="10"></td>
		</tr>
<?php
	}
?>
         <tr><td height="20" colspan="2" align="left"><img src="images/spacer.gif" alt="" width="1" height="10"></td></tr>
       </table></td>
      </tr>
       <tr>       <td valign="top">&nbsp;</td>      </tr>
        </table>