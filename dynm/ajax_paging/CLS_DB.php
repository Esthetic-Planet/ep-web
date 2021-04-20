<?php
/*
GPL Distribution
*/

class CLS_PAGING  {
	var $limitpp = 0;
	var $totalrec = 0;
	var $linkertype = '';
	var $jsspanid = '';
	var $jsurl = '';
	var $jskv = ''; var $addkv = '';
	var $jsmethod = '';
	var $totalrows = '';
	var $orderby = '';
	var $fullquery = '';
	var $paginglinks = array();
	var $defaultlinkerPretag = "<a style='cursor:pointer; text-decoration:none;' ";
	var $defaultlinkerEndtag = "</a>";
	var $lastpage = 0;
	
	
	function __construct($fullquery, $orderby, $limitpp, $addkv){
		global $db;
		$this->linkertype = 'href';  //by default
		$this->limitpp = $limitpp;
		$this->fullquery = $fullquery;
		$this->orderby = $orderby;
		$this->addkv = $addkv;
		
		//echo $fullquery;
		
		$res = $db->execute($fullquery);
		$this->totalrows= $db->numRows();
		$this->lastpage = ceil($this->totalrows/$limitpp); 
		$this->lastpage ;
		return;
	}	
	
	function linkAsAjax($method, $containerid, $url, $addkv){
	
	//echo  $containerid;
	
		$this->jsspanid = $containerid;
		$this->jskv = $addkv;
		$this->jsurl = $url;
		$this->jsmethod = $method;
		$this->linkertype = 'ajax';
	}
	
	function showPageRecs($startat){	
		global $db;
		$res = $db->execute($this->fullquery.$this->orderby." LIMIT $startat, ".$this->limitpp);
		return $res;
	}
	
	function getRecNum($ctr, $pagenum){
		return (($ctr+1)+($this->limitpp*$pagenum));
	}
	
	function getLinkType($linklabel, $startat, $limitpp, $x, $addkv){
	
		$addkv= $this->addkv;
		
		$keyvalues = "$addkv&amp;startat=$startat&amp;limitpp=$limitpp&amp;mul=$x";
		
		if ($this->linkertype=='href') $full_link = "href='".$_SERVER['PHP_SELF']."$keyvalues'>";
		else { 
			
			
			$jsspanid = $this->jsspanid;
			$jskv = $this->jskv;
			$jsurl = $this->jsurl;
			$jsmethod = $this->jsmethod;
			
			$full_link = "onmousedown='xmlhttprequest2(\"$jsspanid\", \"$jsurl\", \"$jsmethod\", \"$jskv&amp;$keyvalues\")'>";
		}
		
		return $this->defaultlinkerPretag.$full_link.$linklabel.$this->defaultlinkerEndtag;
	}
	
	function setPaging($spacer, $mul){ 
		$remainder = $this->totalrows%$this->limitpp;
		$jsspanid = $this->jsspanid;
		$jsurl = $this->jsurl;
		$jskv = $this->jskv;
		$addkv= $this->addkv;
		
		//echo $addkv;
		//die;
		
		$jsmethod = $this->jsmethod;
		$limitpp = $this->limitpp;
		
		for($x=0; $x<$this->lastpage;$x++){ 
			$startat = ($x*$this->limitpp);
			if ($mul==$x) $linklabel = "<span class='current'>".($x+1)."</span>";
			else $linklabel =  ($x+1);
			$this->paginglinks[$x] = $this->getLinkType($linklabel, $startat, $limitpp, $x, $addkv).$spacer;
		}
		return $this->paginglinks;
	}
	
	function showPages($spacer, $limitpergroup, $mul){
		$getpages = $this->setPaging($spacer, $mul);
		$group = floor(($mul)/$limitpergroup);
		
		$startat = ($group*$limitpergroup);
		for($x=($startat); $x<($limitpergroup*($group+1)); $x++){
		
			$showlinks .= $getpages[$x];
		}
		
		return $showlinks;
	}
	
	function showNext($linkname, $currpage){
		$mul = ($currpage==($this->lastpage-1))?0:($currpage+1);
		$startat = (($this->limitpp*$mul));
		return $this->getLinkType($linkname,$startat, $this->limitpp, $mul, $this->jskv);
	}
	
	function showPrev($linkname,$currpage){
		$mul = ($currpage==0)?($this->lastpage-1):($currpage-1);
		$startat = (($this->limitpp*$mul));
		return $this->getLinkType($linkname,$startat, $this->limitpp, $mul, $this->jskv);
	}
	
	function showFirst($linkname){
		return $this->getLinkType($linkname, 0, $this->limitpp, 0, $this->jskv);
	}
		
	function showLast($linkname){
		return $this->getLinkType($linkname, ((($this->lastpage-1)*$this->limitpp)), $this->limitpp, ($this->lastpage-1), $this->jskv);	
	}
}

?>