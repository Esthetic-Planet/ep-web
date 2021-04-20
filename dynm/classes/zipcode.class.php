<?php
/*******************************************************************************
 *                ZIP Code and Mileage Claculation Class
 *******************************************************************************
 *      Author:     Micah Carrick
 *      Email:      email@micahcarrick.com
 *      Website:    http://www.micahcarrick.com
 *
 *      File:       zipcode.class.php
 *      Version:    1.1.0
 *      Copyright:  (c) 2005 - Micah Carrick
 *                  You are free to use, distribute, and modify this software
 *                  under the terms of the GNU General Public License.  See the
 *                  included license.txt file.
 *
 *******************************************************************************
 *  VERION HISTORY:
 *
 *      v1.1.0 [04.30.2005] - Added Jeff Bearer's code to make it MUCH faster!
 *      v1.0.1 [04.22.2005] - Fixed a typo :)
 *      v1.0.0 [04.12.2005] - Initial Version
 *
 *******************************************************************************
 *  DESCRIPTION:
 *
 *      This is a class used to do various zipcode calculations such as distance
 *      and finding the zip codes within range of another zip code.  It uses
 *      a mySQL database based on the text file found for free on the internet
 *      at http://www.cfdynamics.com/cfdynamics/zipbase/index.cfm. Visit that
 *      page for additional information on that data.
 *
 *      You should have downloaded zipcode-1.0.0.zip which contains the sql
 *      code to generate the tables aswell as demo.php, an example of using
 *      this class.  If you did not download the zip, you can from this
 *      URL: http://www.micahcarrick.com/files/zipcode-1.0.0.zip
 *
 *******************************************************************************
*/

class zipcode_class {

   var $last_error = "";            // last error message set by this class
   var $last_time = 0;              // last function execution time (debug info)
   var $units = "m";                // m = miles, k = kilometers
   var $decimals = 2;               // decimal places for returned distance

   function get_distance($zip1, $zip2) {

      // returns the distance between to zip codes.  If there is an error, the
      // function will return -1 and set the $last_error variable.

      $this->chronometer();         // start the clock

      if ($zip1 == $zip2) return 0; // same zip code means 0 miles between. :)


      // get details from database about each zip and exit if there is an error

      $details1 = $this->get_zip_point($zip1);
      $details2 = $this->get_zip_point($zip2);
      if (empty($details1)) {
         $this->last_error = "No details found for zip code: $zip1";
         return -1;
      }
      if (empty($details2)) {
         $this->last_error = "No details found for zip code: $zip2";
         return -1;
      }


      // calculate the distance between the two points based on the lattitude
      // and longitude pulled out of the database.

      $miles = $this->calculate_mileage($details1[0], $details2[0], $details1[1], $details2[1]);

      $this->last_time = $this->chronometer();

      if ($this->units == 'k') return round($miles * 1.609344, $this->decimals);
      else return round($miles, $this->decimals);       // assumed $units = 'm'

   }

   function get_zip_details($zip) {

      // This function pulls the details from the database for a
      // given zip code.

      $sql = "SELECT lattitude, longitude, city, state.state_prefix, state_name, zip_class from zip_code, state  WHERE zip_code='$zip'         AND zip_code.state_prefix=state.state_prefix";
	  $r = mysql_query($sql);
      if (!$r) {
         $this->last_error = mysql_error();
         return;
      } else {
         $row = mysql_fetch_array($r, MYSQL_ASSOC);
         mysql_free_result($r);
         return $row;
      }
   }

   function get_zip_point($zip) {

      // This function pulls just the lattitude and longitude from the
      // database for a given zip code.

      $sql = "SELECT lattitude, longitude from zip_code WHERE zip_code=$zip";
      $r = mysql_query($sql);
      if (!$r) {
         $this->last_error = mysql_error();
         return;
      } else {
         $row = mysql_fetch_array($r);
         mysql_free_result($r);
         return $row;
      }
   }

   function calculate_mileageA($lat1, $lat2, $lon1, $lon2) {

      // This function is not used right now.  This is based on code found
      // all over the internet such as 4guysfromrolla.com.  It's not clear
      // who the original author was.

      $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2));
      $dist = $dist+cos(deg2rad($lat1))*cos(deg2rad($lat2))*cos(deg2rad($lon1 - $lon2));
      $dist = acos($dist);
      $dist = rad2deg($dist);
      return $dist * 60 * 1.1515;
   }

   function calculate_mileage($lat1, $lat2, $lon1, $lon2) {

      // used internally, this function actually performs that calculation to
      // determine the mileage between 2 points defined by lattitude and
      // longitude coordinates.  This calculation is based on the code found
      // at http://www.cryptnet.net/fsp/zipdy/

      // Convert lattitude/longitude (degrees) to radians for calculations
      $lat1 = deg2rad($lat1);
      $lon1 = deg2rad($lon1);
      $lat2 = deg2rad($lat2);
      $lon2 = deg2rad($lon2);

      // Find the deltas
      $delta_lat = $lat2 - $lat1;
      $delta_lon = $lon2 - $lon1;

      // Find the Great Circle distance
      $temp = pow(sin($delta_lat/2.0),2) + cos($lat1) * cos($lat2) * pow(sin($delta_lon/2.0),2);
      $distance = 3956 * 2 * atan2(sqrt($temp),sqrt(1-$temp));

      return $distance;
   }

   function get_zips_in_range($zip, $range) {

      // returns an array of the zip codes within $range of $zip. Returns
      // an array with keys as zip codes and values as the distance from
      // the zipcode defined in $zip.

      $this->chronometer();                     // start the clock

      $details = $this->get_zip_point($zip);  // base zip details
      if (empty($details)) return;

      // This portion of the routine  calculates the minimum and maximum lat and
      // long within a given range.  This portion of the code was written
      // by Jeff Bearer (http://www.jeffbearer.com). This significanly decreases
      // the time it takes to execute a query.  My demo took 3.2 seconds in
      // v1.0.0 and now executes in 0.4 seconds!  Greate job Jeff!

      // Find Max - Min Lat / Long for Radius and zero point and query
      // only zips in that range.
      $lat_range = $range/69.172;
      $lon_range = abs($range/(cos($details[0]) * 69.172));
      $min_lat = number_format($details[0] - $lat_range, "4", ".", "");
      $max_lat = number_format($details[0] + $lat_range, "4", ".", "");
      $min_lon = number_format($details[1] - $lon_range, "4", ".", "");
      $max_lon = number_format($details[1] + $lon_range, "4", ".", "");

      $return = array();    // declared here for scope

      $sql = "SELECT zip_code, lattitude, longitude FROM zip_code
              WHERE zip_code <> $zip AND lattitude BETWEEN '$min_lat' AND
             '$max_lat' AND longitude BETWEEN '$min_lon' AND '$max_lon'";

      $r = mysql_query($sql);

      if (!$r) {    // sql error

         $this->last_error = mysql_error();
         return;

      } else {

         while ($row = mysql_fetch_row($r)) {

            // loop through all 40 some thousand zip codes and determine whether
            // or not it's within the specified range.

            $dist = $this->calculate_mileage($details[0],$row[1],$details[1],$row[2]);
            if ($this->units == 'k') $dist = $dist * 1.609344;
            if ($dist <= $range) {
               $return[str_pad($row[0], 5, "0", STR_PAD_LEFT)] = round($dist, $this->decimals);
            }
         }
         mysql_free_result($r);
      }

      $this->last_time = $this->chronometer();

      return $return;
   }

   function chronometer()  {

   // chronometer function taken from the php manual.  This is used primarily
   // for debugging and anlyzing the functions while developing this class.

   $now = microtime(TRUE);  // float, in _seconds_
   $now = $now + time();
   $malt = 1;
   $round = 7;

   if ($this->last_time > 0) {
       /* Stop the chronometer : return the amount of time since it was started,
       in ms with a precision of 3 decimal places, and reset the start time.
       We could factor the multiplication by 1000 (which converts seconds
       into milliseconds) to save memory, but considering that floats can
       reach e+308 but only carry 14 decimals, this is certainly more precise */

       $retElapsed = round($now * $malt - $this->last_time * $malt, $round);

       $this->last_time = $now;

       return $retElapsed;
   } else {
       // Start the chronometer : save the starting time

       $this->last_time = $now;

       return 0;
   }
}

}