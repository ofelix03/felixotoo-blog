<?php

class Paginate extends CI_Model{
    private $total_rows = 0;
    private $rows_per_page = 2;
    private $pages = 1;
    private $offset = 0;
    private $limit;
    private $tb_article = 'article';
    private $target_url;
    private $page_id = 1;
    public  $data =array();


    public $enclosing_open_tag = "<p class='enclose-tag'>";
    public $enclosing_close_tag = "</p>";
    public $inner_open_tag = "<span class='inner-tag'>";
    public $inner_close_tag = "</span>";


    public function __construct(){
        parent::__construct($config = array());
        $this->load->database();

        //set property values  if any data is passed 
        if(isset($config) && count($config) != 0)
          $this->initialize($config);
    }

    public function initialize($config)
    {
        if($config['rows_per_page'] && is_numeric($config['rows_per_page']))
            $this->rows_per_page = $config['rows_per_page'];

        if($config['total_rows'] && is_numeric($config['total_rows']))
            $this->total_rows = $config['total_rows'];
        
        if($config['target_url'])
            $this->target_url = $config['target_url'];

        if($config['page_id'] && is_numeric($config['page_id']) && $config['page_id'] >= 2)
           $this->page_id = $config['page_id'];

        $this->pages = ceil($this->total_rows / $this->rows_per_page);
        $this->limit = $this->rows_per_page;

    }


    public function get_limit(){
        return $this->limit; //limit is equal to rows per page
    }

    public function get_offset(){
        $this->offset = ($this->page_id - 1) * $this->rows_per_page;
          return $this->offset;
    }

    public  function getData($query_string)
    {
        if(isset($query_string))
        {
            $query_result = $this->db->query($query_result);
            if($query_result->num_rows() >= 1)
                return $query_result->result_array();
        }

        return false;
        
    }

    public function getTotalRows($table_name){
        $query_string = 'SELECT count(id) as total_rows from '.$table_name;
        $query_result = $this->db->query($query_string);
        $total_rows = $query_result->result_array()[0]['total_rows'];
        return $total_rows;
    }

    public function getRows($query_string, $alias = ""){
          $query_result = $this->db->query($query_string);
            $total_rows = !empty($alias)? $query_result->result_array()[0][$alias] : $query_result->result_array()[0][0];
            return $total_rows;
    }



    public function create_pagination(){
        $page_id = $this->page_id;
        $url = $this->target_url;
        $pages = $this->pages;
        $dots_state = FALSE;
        $first_links = 4;
        $last_link = 3;


       if($this->pages <= 1)
            return false;
        if($page_id < $pages-1) 
            $next = $page_id + 1;
        else
            $next = 0;

        if($page_id > 0)
            $prev = $page_id - 1 ;
        else
            $prev = 0 ;

        $markup = "<p class='enclose-tag'>";
        if($page_id != 0)
        {
            //create previous link 
            $markup .=  "<span class='inner-tag'><a  href='{$url}/".$prev."'><i class='fa fa-arrow-left'></i></a></span>";
        }

        for($i=0; $i < $pages; $i++)
        {

            $address = $url.'/'.$i;
            
            if($page_id >= ($first_links + 1) && $i == 0)
            {
                //show a dotted first link
                 $markup .=  "<span class='inner-tag'><a href='{$address}'>First</a></span>...";
            }

            if($page_id == $i && $page_id != $pages-1)
            {
                //show an active link
                $markup .=  "<span class='inner-tag'><a class='active' href='{$address}'>{$i}</a></span>";
            }


            if($page_id <= $first_links && $i <= $first_links && $page_id != $i)
            {
                //show as an inactive link
                $markup .=  "<span class='inner-tag'><a href='{$address}'>{$i}</a></span>";
            }


            if($page_id >= ($first_links + 1) &&  $i >= ($first_links + 1)  && $i < $pages-1 && $page_id != $i)
            {
                //if page_id >= first_link + 1 and not active link => show two links adjacent the active link
                if($page_id + 1 == $i || $page_id - 1 == $i ||  $page_id - 2 == $i ||  $page_id + 2 == $i)
                    $markup .=  "<span class='inner-tag'><a href='{$address}'>{$i}</a></span>";
            }
        }

        if($page_id >= ($pages-1)-$last_link && $page_id < $pages-1)
        {   
            //show the last n links
            $markup .=  "<span class='inner-tag'><a href='{$url}/".($pages-1)."'>Last</a></span>";
        }
        else if($page_id == $pages-1)
        {
            //show the last link as an active link
            $markup .=  "<span class='inner-tag'><a class='active' href='{$url}/".($pages-1)."'>Last</a></span>";

        }
        else
            $markup .=  "...<span class='inner-tag'><a href='{$url}/".($pages-1)."'>Last</a></span>";

        $markup .= "<span class='inner-tag'><a href='{$url}/".$next."'> <i class='fa fa-arrow-right'></i> </a></span>";
        $markup .= "</p><hr class='clear' style='border:none; margin: 0px; padding:0px;' />";
        return  $markup;
    }


    public function create_pagination2(){
       if($this->pages <= 1)
            return false;
        if($this->page_id > 1)
            $prev = $this->page_id - 1;
        else
            $prev = $this->pages;
        if($this->page_id < $this->pages )
            $next = $this->page_id + 1;
        else
            $next = 1;
         
        $url = $this->target_url;
        $breakpoint = 5;


     
        $markup = "<p class='enclose-tag'>";


        if($this->page_id >= 2)
            $markup .= "<span class='inner-tag' ><a href='{$url}".$prev."'><i class='fa fa-arrow-left'></i></a></span>";

        for($i = 1; $i <= $this->pages; $i++)
        {

           
            if($this->page_id == $i)
                $markup .= "<span class='inner-tag' ><a href='{$url}".$i."' class='active'>{$i}</a></span>";
            else if(( $i == $this->page_id - 1 || $i == $this->page_id  - 2 || $i == $this->page_id + 1 || $i == $this->page_id + 2))
            {
                if($i == $this->page_id + 2  && $this->page_id < $this->pages - 3 )
                    $markup .= "<span class='inner-tag'><a href='{$url}".$i."'>{$i}</a></span>...";
              
                else
                    $markup .= "<span class='inner-tag'><a href='{$url}".$i."'>{$i}</a></span>";
          
          
            }
            else if($i == $this->pages)
                $markup .= "<span class='inner-tag'><a href='{$url}".$i."'>{$i}</a></span>";

        }

         if($this->page_id < $this->pages)
            $markup .= "<span class='inner-tag' ><a href='{$url}".$next."'><i class='fa fa-arrow-right'></i></a></span>";


        $markup .= "</p><p class='clear'></p>";
        return $markup;
    }

    public function create_pagination3(){
       if($this->pages <= 1)
            return false;
        if($this->page_id > 1)
            $prev = $this->page_id - 1;
        else
            $prev = $this->pages;
        if($this->page_id < $this->pages )
            $next = $this->page_id + 1;
        else
            $next = 1;
         
        $url = $this->target_url.'/';
        $breakpoint = 5;


        $markup = "<p class='enclose-tag'>";


        if($this->page_id >= 2)
            $markup .= "<span class='inner-tag' ><a href='{$url}".$prev."'><i class='fa fa-arrow-left'></i></a></span>";

        for($i = 1; $i <= $this->pages; $i++)
        {

           
            if($this->page_id == $i)
                $markup .= "<span class='inner-tag' ><a href='{$url}".$i."' class='active'>{$i}</a></span>";
            else if(( $i == $this->page_id - 1 || $i == $this->page_id  - 2 || $i == $this->page_id + 1 || $i == $this->page_id + 2))
            {
                if($i == $this->page_id + 2  && $this->page_id < $this->pages - 3 )
                    $markup .= "<span class='inner-tag'><a href='{$url}".$i."'>{$i}</a></span>...";
              
                else
                    $markup .= "<span class='inner-tag'><a href='{$url}".$i."'>{$i}</a></span>";


          
            }
            else if($i == $this->pages)
                $markup .= "<span class='inner-tag'><a href='{$url}".$i."'>{$i}</a></span>";

        }

         if($this->page_id < $this->pages)
            $markup .= "<span class='inner-tag' ><a href='{$url}".$next."'><i class='fa fa-arrow-right'></i></a></span>";


        $markup .= "</p><hr class='clear' style='border:none; margin: 0px; padding:0px;' />";
        return $markup;

    }

    

}