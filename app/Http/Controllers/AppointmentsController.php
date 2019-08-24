<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AppointmentCreateRequest;
use App\Http\Requests\AppointmentUpdateRequest;
use App\Repositories\AppointmentRepository;
use App\Validators\AppointmentValidator;

/**
 * Class AppointmentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class AppointmentsController extends Controller
{
    /**
     * @var AppointmentRepository
     */
    protected $repository;

    /**
     * @var AppointmentValidator
     */
    protected $validator;

    /**
     * AppointmentsController constructor.
     *
     * @param AppointmentRepository $repository
     * @param AppointmentValidator $validator
     */
    public function __construct(AppointmentRepository $repository, AppointmentValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $appointments = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $appointments,
            ]);
        }

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  AppointmentCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(AppointmentCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $appointment = $this->repository->create($request->all());

            $response = [
                'message' => 'Appointment created.',
                'data'    => $appointment->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appointment = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $appointment,
            ]);
        }

        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $appointment = $this->repository->find($id);

        return view('appointments.edit', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  AppointmentUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(AppointmentUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $appointment = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Appointment updated.',
                'data'    => $appointment->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'Appointment deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Appointment deleted.');
    }
}
