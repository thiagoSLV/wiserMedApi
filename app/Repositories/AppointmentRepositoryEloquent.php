<?php

namespace App\Repositories;

use App\Models\Appointment;
use App\Repositories\AppointmentRepository;
use App\Exceptions\AppointmentRegisterException;
use App\Http\Resources\AppointmentResource;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\DB;
use Exception;

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

    // public function validator(array $data)
    // {
    //     // $data would be an associative array like ['date_value' => '15.15.2015']
    //     $message = [
    //         'date_value.date' => 'invalid date'
    //     ];
    //     return Validator::make($data, [
    //         'date_value' => 'date',
    //     ],$message);
    // }

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

    public function getDoctorAppointments($id)
    {
        try
        {
            return AppointmentResource::collection(
                Appointment::
                    where('doctor_id', $id)
                    ->orderBy('date')
                    ->orderBy('time')
                    ->get()
            );
        } catch (Exception $e) 
        {
            if ($e->getCode() == '22P02')
                return response()->json("Invalid argument for id: {$id}", 400);
        }
    }

    public function getPacientAppointments($id)
    {
        try
        {
            return AppointmentResource::collection(
                Appointment::
                    where('pacient_id', $id)
                    ->orderBy('date')
                    ->orderBy('time')
                    ->get()
            );
        } catch (Exception $e) 
        {
            if ($e->getCode() == '22P02')
                return response()->json("Invalid argument for id: {$id}", 400);
        }
    }

    public function getDoctorAppointmentsByDateRange($id, $init, $fin)
    {
        try {
            return AppointmentResource::collection(
                Appointment::
                    where('doctor_id', $id)
                    ->whereBetween('date', array($init, $fin))
                    ->orderBy('date')
                    ->orderBy('time')
                    ->get()
            );
        } catch (Exception $e)
        {
            if($e->getCode() == 22007);
                return response()->json("Invalid Date argument on request, inicial date: {$init}, final date: {$fin}", 400);

            if ($e->getCode() == '22P02')
                return response()->json("Invalid argument for id: {$id}", 400);
            
        }
    }

    public function getPacientAppointmentsByDateRange($id, $init, $fin)
    {
        try {
            return AppointmentResource::collection(
                Appointment::
                    where('pacient_id', $id)
                    ->whereBetween('date', array($init, $fin))
                    ->orderBy('date')
                    ->orderBy('time')
                    ->get()
            );
        } catch (Exception $e)
        {
            if($e->getCode() == 22007);
                return response()->json("Invalid Date argument on request, inicial date: {$init}, final date: {$fin}", 400);

            if ($e->getCode() == '22P02')
                return response()->json("Invalid argument for id: {$id}", 400);

        }
    }

    public function getById($id)
    {
        try{
            return new AppointmentResource(Appointment::find($id));
        } catch (Exception $e) 
        {
            if ($e->getCode() == '22P02')
                return response()->json("Invalid argument for id: {$id}", 400);
        }
    }

    public function getByDateRange($init, $fin)
    {
        try
        {
            return AppointmentResource::collection(Appointment::whereBetween('date', array($init, $fin))->get());
        } catch (Exception $e)
        {
            if($e->getCode() == 22007);
                return response()->json("Invalid Date argument on request, inicial date: {$init}, final date: {$fin}", 400);
        }
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
