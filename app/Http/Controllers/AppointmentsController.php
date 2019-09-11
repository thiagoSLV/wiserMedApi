<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\AppointmentCreateRequest;
use App\Http\Requests\AppointmentUpdateRequest;
use App\Repositories\AppointmentRepositoryEloquent;
use App\Validators\AppointmentValidator;

/**
 * Class AppointmentsController.
 *
 * @package namespace App\Http\Controllers;
 */
class AppointmentsController extends Controller
{
    /**
     * @var AppointmentRepositoryEloquent
     */
    protected $repository;

    /**
     * AppointmentsController constructor.
     *
     * @param AppointmentRepositoryEloquent $repository
     * @param AppointmentValidator $validator
     */
    public function __construct(AppointmentRepositoryEloquent $repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function get($id)
    {
        return $this->repository->getById($id);
    }

    public function getByRange($init, $fin)
    {
        return $this->repository->getByRange($init, $fin);
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
        return $this->repository->save($request);
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
