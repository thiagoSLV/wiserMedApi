<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PacientRepository;
use App\Models\Pacient;
use App\Validators\PacientValidator;
use App\Http\Resources\PacientResource;

/**
 * Class PacientRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PacientRepositoryEloquent extends BaseRepository implements PacientRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Pacient::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {
        return PacientValidator::class;
    }

/**
    * Specify Resource class name
    *
    * @return mixed
    */
    public function resource()
    {
        return PacientResource::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function getAll()
    {
        return PacientResource::collection(Pacient::all());
    }

    public function get($id)
    {
        return new PacientResource(Pacient::find($id));
    }

    public function save($request)
    {
        dd($request);
    }

}
