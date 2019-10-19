<?php

namespace App\Repositories;

use App\Models\Pacient;
use App\Repositories\PacientRepository;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Http\Resources\PacientResource;
use Illuminate\Support\Facades\Validator;
use Exception;

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
        try{
            return new PacientResource(Pacient::find($id));
        } catch (Exception $e) 
        {
            if ($e->getCode() == '22P02')
                return response()->json("Invalid argument for id: {$id}", 400);
        }
    }

    public function save($request)
    {
        // dd($request->input('password'));
        $pacient = $this->create($request->all());

        $response = [
            'message' => 'Pacient created.',
            'data'    => $pacient->toArray(),
        ];

        return response()->json($response);

    }

}
