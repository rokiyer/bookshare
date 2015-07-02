<?php
class Pagination_model extends CI_Model 
{
	function __construct() {
		parent::__construct();
	}

	private $total;
	private $offset;
	private $search_data;
	private $pre_url;

	private $num_page;
	private $limit;

	public function create_link($config)
	{
		$this->initialize($config);
		$total_page = ceil($this->total/$this->limit);
		$current_page = $this->offset/$this->limit + 1;
		$links = array();

		if($total_page > 1)
		{
			if($current_page != 1)
			{
				$links['First'] = '<li>'.anchor($this->url_maker(0),'First').'</li>';
				$links['Prev'] = '<li>'.anchor($this->url_maker($this->offset - $this->limit),'Prev').'</li>';
			}

			$i = (($current_page - $this->num_page) < 0)?0:($current_page - $this->num_page);
			$end = 	(($current_page + $this->num_page) > $total_page)?$total_page:($current_page + $this->num_page);
			for(;$i < $end;++$i)
			{
				if(($i+1) == $current_page)
				{
					$links[$i+1] = '<li class="active">'.anchor($this->url_maker($this->limit*$i),$i+1).'</li>';
				}
				else
				{
					$links[$i+1] = '<li>'.anchor($this->url_maker($this->limit*$i),$i+1).'</li>';
				}
			}
			if($current_page != $total_page)
			{
				$links['Last'] = '<li>'.anchor($this->url_maker($this->limit*($total_page-1)),'Last').'</li>';
				$links['Next'] = '<li>'.anchor($this->url_maker($this->offset+$this->limit),'Next').'</li>';
			}
		}
		return $links;
	}

	private function initialize($config) {
		$this->total = $config['total'];
		$this->offset = isset($config['offset'])?$config['offset']:0;
		$this->search_data = $config['search_data'];
		$this->pre_url = $config['pre_url'];
		$this->limit = isset($config['limit'])?$config['limit']:10;
		$this->num_page = isset($config['limit'])?$config['limit']:4;

	}

	private function url_maker($offset)
	{
		$data = $this->search_data ;
		foreach ($data as $key => $value) {
			if(empty($value))
				unset($data[$key]);
		}
		$data['offset']=$offset;
		return $this->pre_url.'?'.http_build_query($data);
	}
}