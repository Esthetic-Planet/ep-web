<?

// User settings

$rater_ip_voting_restriction = true; // restrict ip address voting (true or false)
$rater_ip_vote_qty=1; // how many times an ip address can vote


$rater_already_rated_msg="You have already rated this video. You were allowed ".$rater_ip_vote_qty." vote(s).";
$rater_not_selected_msg="You have not selected a rating value.";
$rater_thankyou_msg="Thankyou for voting.";



$rater_rating=0;
$rater_stars="";
$rater_stars_txt="";
$rater_votes=0;
$rater_msg="";

// Rating action
if(isset($_REQUEST["rate".$rater_id]))
{
			 if(isset($_REQUEST["rating_".$rater_id]))
			 {
						  while(list($key,$val)=each($_REQUEST["rating_".$rater_id]))
						  {
								$rater_rating=$val;
						  }
						
						  $rater_ip = getenv("REMOTE_ADDR"); 
						  
						  $rate_arr=$sql->SqlSingleRecord("esthp_tblRating"," where vid_id='$rater_id' ");
						
						  if($rate_arr['count']>0) // if record exists
						  {
								$rate_data=$rate_arr['Data'];
							
								   if($rater_ip_voting_restriction)
								   {
								   
											$ip_add_arr=$sql->SqlRecordMisc("esthp_tblRating"," where ip_address='$rater_ip' ");
											
											$ip_add_count=$ip_add_arr['count'];
											
											$ip_add_data=$ip_add_arr['Data'];
											
					
											
											$rater_ip_vote_count=$ip_add_count;
											
											if($rater_ip_vote_count > ($rater_ip_vote_qty - 1))
											{
													$rater_msg=$rater_already_rated_msg;
											}
											else
											{
													$rate_insert_arr=array();
													$rate_insert_arr['vid_id']=$rater_id;
													$rate_insert_arr['rating']=$rater_rating;
													$rate_insert_arr['cat_id']=$_REQUEST['rate_cat_id'];
													$rate_insert_arr['ip_address']=$rater_ip;
													
													$inserted_rate_id = $sql->SqlInsert('esthp_tblRating',$rate_insert_arr);
													
													$rater_msg=$rater_thankyou_msg;
											}
								   }
								   else
								   {
										$rate_insert_arr=array();
										$rate_insert_arr['vid_id']=$rater_id;
										$rate_insert_arr['cat_id']=$_REQUEST['rate_cat_id'];
										$rate_insert_arr['rating']=$rater_rating;
										$rate_insert_arr['ip_address']=$rater_ip;
										
										$inserted_rate_id = $sql->SqlInsert('esthp_tblRating',$rate_insert_arr);
										
										$rater_msg=$rater_thankyou_msg;
								   }
						}
						else
						{
								$rate_insert_arr=array();
								$rate_insert_arr['vid_id']=$rater_id;
								$rate_insert_arr['cat_id']=$_REQUEST['rate_cat_id'];
								$rate_insert_arr['rating']=$rater_rating;
								$rate_insert_arr['ip_address']=$rater_ip;
								
								$inserted_rate_id = $sql->SqlInsert('esthp_tblRating',$rate_insert_arr);
										
								$rater_msg=$rater_thankyou_msg;
						}
			 }
			 else
			 {
				$rater_msg=$rater_not_selected_msg;
			 }
}

// Get current rating

$rate_arr=$sql->SqlRecordMisc("esthp_tblRating"," where vid_id='$rater_id' ");
						
$rate_count=$rate_arr['count'];

$rate_data=$rate_arr['Data'];

if($rate_count>0)
{
	$rater_votes=$rate_count;
	
	$rater_sum=0;
	
	foreach($rate_data as $rate_record)
	{
		$rater_sum+=$rate_record['rating'];
	}
	
	$rater_rating=number_format(($rater_sum/$rater_votes), 2, '.', '');
}


// Assign star image
if ($rater_rating <= 0  ){$rater_stars = _WWWROOT."rater/img/00star.gif";$rater_stars_txt="Not Rated";}
if ($rater_rating >= 0.5){$rater_stars = _WWWROOT."rater/img/05star.gif";$rater_stars_txt="0.5";}
if ($rater_rating >= 1  ){$rater_stars = _WWWROOT."rater/img/1star.gif";$rater_stars_txt="1";}
if ($rater_rating >= 1.5){$rater_stars = _WWWROOT."rater/img/15star.gif";$rater_stars_txt="1.5";}
if ($rater_rating >= 2  ){$rater_stars = _WWWROOT."rater/img/2star.gif";$rater_stars_txt="2";}
if ($rater_rating >= 2.5){$rater_stars = _WWWROOT."rater/img/25star.gif";$rater_stars_txt="2.5";}
if ($rater_rating >= 3  ){$rater_stars = _WWWROOT."rater/img/3star.gif";$rater_stars_txt="3";}
if ($rater_rating >= 3.5){$rater_stars = _WWWROOT."rater/img/35star.gif";$rater_stars_txt="3.5";}
if ($rater_rating >= 4  ){$rater_stars = _WWWROOT."rater/img/4star.gif";$rater_stars_txt="4";}
if ($rater_rating >= 4.5){$rater_stars = _WWWROOT."rater/img/45star.gif";$rater_stars_txt="4.5";}
if ($rater_rating >= 5  ){$rater_stars = _WWWROOT."rater/img/5star.gif";$rater_stars_txt="5";}


// Output

/* 
echo '<div >';

echo '<form name="rate_form" method="post" action="">';

echo 'Rate '.$rater_item_name.'';

echo '<div>';
echo '<img src="'.$rater_stars.'?x='.uniqid((double)microtime()*1000000,1).'" alt="'.$rater_stars_txt.' stars" /> Ave. rating: '.$rater_stars_txt.' from  '.$rater_votes.' votes.';
echo '</div>';

echo '<div>';
echo '<label for="rate5_'.$rater_id.'"><input type="radio" value="5" name="rating_'.$rater_id.'[]" id="rate5_'.$rater_id.'" />Excellent</label>';
echo '<label for="rate4_'.$rater_id.'"><input type="radio" value="4" name="rating_'.$rater_id.'[]" id="rate4_'.$rater_id.'" />Very Good</label>';
echo '<label for="rate3_'.$rater_id.'"><input type="radio" value="3" name="rating_'.$rater_id.'[]" id="rate3_'.$rater_id.'" />Good</label>';
echo '<label for="rate2_'.$rater_id.'"><input type="radio" value="2" name="rating_'.$rater_id.'[]" id="rate2_'.$rater_id.'" />Fair</label>';
echo '<label for="rate1_'.$rater_id.'"><input type="radio" value="1" name="rating_'.$rater_id.'[]" id="rate1_'.$rater_id.'" />Poor</label>';
echo '<input type="hidden" name="rs_id" value="'.$rater_id.'" />';
echo '<input type="submit" name="rate'.$rater_id.'" value="Rate" />';
echo '</div>';

if($rater_msg!="") echo "<div>".$rater_msg."</div>";

echo '</form>';

echo '</div>';
*/
?>


