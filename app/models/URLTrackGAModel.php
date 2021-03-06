<?php

class URLTrackGAModel extends Eloquent {

	/**
	 *     Table name of model used
	 *     @var string
	 */
	public $timestamps = false;
	protected $table = 'url_track_3rd';

	public static function getRules() {
		return [
			"url"	=> "required",
			"amount"=> "required|numeric",
		];
	}

	public static function getLangs(){
		return array(
			"url.required"		=>	"Url field is required.",
			"amount.required"	=>	"Amount field is required",
			"amount.numeric"	=>  "Amount must be a number",
		);
	}

	public function store($inputs){
		$value = array();
		$urlTrackGA = new URLTrackGAModel;
		$urlTrackGA->url = $inputs['url'];
		$urlTrackGA->active = $inputs['active'];
		$urlTrackGA->run = $inputs['run'];
		$urlTrackGA->amount = $inputs['amount'];
		$urlTrackGA->website = $inputs['website'];
		$urlTrackGA->save();
		
		$this->storeRedis();
	}

	/*
	 * Update info
	*/
	public function updateInfo($inputs, $id){
		$options = [
			'url'		=> $inputs['url'],
			'active'	=> $inputs['active'],
			'run'		=> $inputs['run'],
			'website' 	=> $inputs['website'],
			'amount'	=> $inputs['amount']
		];
		$this->where('id', $id)->update($options);
		$this->storeRedis();
	}

	/*
	* delete info
	*/
	public function deleteItem($id){
		URLTrackGAModel::find($id)->delete();
		$this->storeRedis();
	}

	/*
	* Get All function
	* @return array
	*/
	public function getAll(){
		$results = URLTrackGAModel::all();
		return $results;
	}

	public function getListActive(){
		return $this->select('id', 'url', 'website', 'amount','run')->where('active', 1)->where('amount', '>', 0)->get();
	}

	public function storeRedis(){
		$redis = new RedisBaseModel(Config::get('redis.redis_3.host'), Config::get('redis.redis_3.port'), false);
		$cacheKey = "URLTrack3rd";
		$value = $this->getListActive();					
	    $retval = $redis->set($cacheKey, $value);
	}

	/*
	* get sum
	*/
	public static function sum($id){
		$result = 0;
		$redis = new RedisBaseModel(Config::get('redis.redis_3.host'), Config::get('redis.redis_3.port'), false);
		$cacheKey = "URLTrack3rd.".$id;
		$result = $redis->get($cacheKey);
		return $result;
	}

	/*
	* getListTrackURL
	*/
	public function getListTrackURL($id, $inputs=''){
		$redis = new RedisBaseModel(Config::get('redis.redis_3.host'), Config::get('redis.redis_3.port'), false);
		$cacheKey = "URLTrack3rd.".$id;
		
		$data = array();
		$end = date('Y-m-d');
		$start = strtotime('-7 days', strtotime($end));

		if(isset($inputs['start'])  && isset($inputs['end']) && $inputs['start']!='' && $inputs['end']!=''){
			$start = strtotime($inputs['start']);
			$end = $inputs['end'];
		}

		if(URLTrackGAModel::sum($id)>0){
			while(strtotime($end) >= $start){
				$total = $redis->get($cacheKey.".".date('Ymd', strtotime($end)));
				if($total > 0){
					$item['date'] = $end;
					$item['total'] = $total;	
					$data[] = $item;
				}
				$end = date('Y-m-d', strtotime("-1 day" .$end));
			}
		}
		return $data;
	}

}