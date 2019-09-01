<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Repositories\DoctorRepository;
use App\Http\Resources\DoctorResource;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\RegisterException;

/**
 * Class DoctorRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class DoctorRepositoryEloquent extends BaseRepository implements DoctorRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Doctor::class;
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
        return DoctorResource::collection(Doctor::all());
    }

    public function getById($id)
    {
        return new DoctorResource(Doctor::find($id));
    }

    public function save($request)
    {
        try
        {
            if($request->get('cpf') === null && $request->get('cnpj') === null)
                throw new RegisterException($request->get('name'), 400);
             
            $request->validate();
            
            $doctor = $this->create($request->all());
    
            $response = [
                'message' => 'Doctor created.',
                'data'    => $doctor->toArray(),
            ];
    
            return response()->json($response);
        } catch (\RegisterException $e)
        {
           return ($e);
        }
    }
}
