<?php
/*
 * Huy write
 */

class AjaxPagination
{
	var $limit;
	var $total;
	var $page;
	var $url;
	var $limit_page = 0;
	
	function __construct($limit,$total,$page, $limit_page = 0){
		$this->limit = $limit;
		$this->total = $total;
		$this->page = $page;
		$this->limit_page = $limit_page;
	}
	
	/*
	 * maxpage is max page is show. But It is not last pageg.
	 * ex: 1,2,3,4..100.=> 4 is max page 
	 */
	function showPagination($maxpage = 5)
	{
//		$previous = "&lsaquo;";
		$previous = "<img src='images/page_previous.gif' alt='previous page'>";
//		$next = "&rsaquo;";
		$next = "<img src='images/page_next.gif' alt='previous page'>";
//		$first_page = "&#171; ";
		$first_page = "<img src='images/page_first.gif' alt='first page'> ";
		$last_page = "<img src='images/page_last.gif' alt='last page'>";
		
		$raw = FSInput::get('raw');
		if(!$raw)
			$current_page = 1;
		else 
			$current_page = FSInput::get('page',1,'int');
			
		if(!$current_page || $current_page < 0)
			$current_page = 1;
		$html  = "";
		if($this->limit < $this->total)
		{
			$num_of_page = ceil( $this->total / $this -> limit );
			
			// limit page
			if($this -> limit_page){
				if($this -> limit_page < $num_of_page  )
					$num_of_page = $this -> limit_page;
			}
			
			
			$start_page = $current_page - $maxpage;
			if($start_page <= 0)
				 $start_page = 1;
			
			$end_page = $current_page + $maxpage;
			
			if($end_page > $num_of_page) 
				$end_page = $num_of_page;
			
			//WRITE prefix on screen
			$html  .= "<div class='pagination'>";
//			$html .=  "<font class='title_pagination'>" . Text::_('Trang') . "</font> ";
			//Write Previous
//			if(($current_page > 1) && ($num_of_page > 1)){
//				$html .= "<a title='first_page' href='javascript:pagination(0);' title='".FSText::_('First page')."' >" . $first_page . "</a>";
//				$html .= "<a title='pre_page' href='javascript:pagination(".($current_page-1).");' title='".FSText::_('Previous')."' >" . $previous . "</a>";
//				if($start_page !=1)
//					 $html .= " <b>..</b> ";
//			}

			if(($current_page > 1) && ($num_of_page > 1) && $start_page > 1){
				$html .= "<a title='first_page' href='javascript:pagination(0);' title='".FSText::_('First page')."' >" . 1 . "</a>";
				if($start_page > 2 )
					 $html .= " <b>..</b> ";
			}

			
			for($i=$start_page; $i<=$end_page; $i++){
				if($i != $current_page){
					 $html .= "<a title='Page " . $i . "' href='javascript:pagination(".$i.");'   >" . $i . "</a>";
				}
				else{
					 $html .= "<font title='Page " . $i . "' class='current'>[" . $i . "]</font>";
				}
			}
			//Write Next
//			if(($current_page < $num_of_page) && ($num_of_page > 1)){
//				if($end_page < $num_of_page) 
//					$html .= " <b>..</b> ";
//				$html .= "<a title='Next page' href='javascript:pagination(".($current_page+1).");'  >" . $next . "</a>";
//				$html .= "<a title='Last page' href='javascript:pagination(".($num_of_page).");'  >" . $last_page . "</a>";
//			}

			if(($current_page < $num_of_page) && ($num_of_page > 1) && $end_page < $num_of_page){
				if($end_page < ($num_of_page -1)) 
					$html .= " <b>..</b> ";

				$html .= "<a title='Last page' href='javascript:pagination(".($num_of_page).");'  >" . $num_of_page . "</a>";
			}
			$html .= "</div>";
		}
		
		return $html;
	}
}