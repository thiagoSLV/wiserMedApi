<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Repositories\DoctorRepository;
use App\Http\Resources\DoctorResource;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\DoctorRegisterException;

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

            if($request->get('cpf') === null && $request->get('cnpj') === null)
                throw new DoctorRegisterException();

            $doctor = $this->create($request->all());
    
            $response = [
                'message' => 'Doctor created.',
                'data'    => $doctor->toArray(),
            ];
    
            return response()->json($response);
    }
}
