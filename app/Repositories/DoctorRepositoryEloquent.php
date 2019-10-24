<?php

namespace App\Repositories;

use App\Models\Doctor;
use App\Repositories\DoctorRepository;
use App\Http\Resources\DoctorResource;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\DoctorRegisterException;
use Illuminate\Support\Facades\Hash;
use Exception;

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
        try{
            return new DoctorResource(Doctor::find($id));
        } catch (Exception $e) 
        {
            if ($e->getCode() == '22P02')
                return response()->json("Invalid argument for id: {$id}", 400);
        }
    }

    public function getBySpecialty($specialty)
    {
        return  DoctorResource::collection(Doctor::where('specialty', 'LIKE', "{$specialty}%")->get());
    }

    public static function getByEmail($email)
    {
        return  DoctorResource::collection(Doctor::where('email', 'LIKE', "{$email}")->get());
    }

    public function save($request)
    {
        $request->merge([
            'password' => Hash::make($request->input('password'))
        ]);

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
