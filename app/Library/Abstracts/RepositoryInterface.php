<?php namespace TMS\Abstracts;

use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface {

	public function all ( $fields = [] );

	public function getById ( $id, array $with = [] );

	// public function delete ( Model $model );
}
