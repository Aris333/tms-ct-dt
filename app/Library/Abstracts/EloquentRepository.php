<?php namespace TMS\Abstracts;

use Illuminate\Database\Eloquent\Model;

abstract class EloquentRepository implements RepositoryInterface {
	protected $model;

	public function all ($fields =[]) {
		$fields = count($fields) ? $fields : '*' ;
		return $this->model->all($fields);
	}


	public function getById ( $id, array $with = [] ) {
		return $this->model->find( $id );
	}


	public function delete ( Model $model ) {
		return $model->delete();
	}
}
