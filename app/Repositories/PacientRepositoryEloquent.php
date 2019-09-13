<?php

namespace App\Repositories;

use App\Models\Pacient;
use App\Repositories\PacientRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Http\Resources\PacientResource;
use Illuminate\Support\Facades\Validator;


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

    public function getById($id)
    {
        return new PacientResource(Pacient::find($id));
    }

    public function save($request)
    {

        $pacient = $this->create($request->all());

        $response = [
            'message' => 'Pacient created.',
            'data'    => $pacient->toArray(),
        ];

        return response()->json($response);

    }

}
