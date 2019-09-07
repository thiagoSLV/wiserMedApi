<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Repositories\AppointmentRepository;
use App\Exceptions\AppointmentRegisterException;
use App\Http\Resources\AppointmentResource;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\DB;

/**
 * Class AppointmentRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AppointmentRepositoryEloquent extends BaseRepository implements AppointmentRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Appointment::class;
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
        return AppointmentResource::collection(Appointment::all());
    }

    public function getById($id)
    {
        return new AppointmentResource(Appointment::find($id));
    }

    public function save($request)
    {
        $table = Appointment::make()->getTable();
        $validate = DB::table($table)
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->first();

        if ($validate !== null)
            throw new AppointmentRegisterException();

        $appointment = $this->create($request->all());

        $response = [
            'message' => 'Appointment Registered.',
            'data'    => $appointment->toArray(),
        ];

        return response()->json($response);
    }
}
