<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\DoctorCreateRequest;
use App\Http\Requests\DoctorUpdateRequest;
use App\Repositories\DoctorRepositoryEloquent;
use App\Validators\DoctorsValidator;

/**
 * Class DoctorsController.
 *
 * @package namespace App\Http\Controllers;
 */
class DoctorsController extends Controller
{
    /**
     * @var DoctorRepositoryEloquent
     */
    protected $repository;

    /**
     * DoctorsController constructor.
     *
     * @param DoctorRepositoryEloquent $repository

     */
    public function __construct(DoctorRepositoryEloquent $repository)
    {
        // $this->middleware('auth:doctor');
        $this->repository = $repository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  DoctorCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(DoctorCreateRequest $request)
    {
        return $this->repository->save($request);
    }
    
    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function get($id)
    {
        return $this->repository->getById($id);
    }
    
    public function getBySpecialty($especialty)
    {
        return $this->repository->getBySpecialty($especialty);
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
        $doctor = $this->repository->find($id);

        return view('doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  DoctorUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(DoctorUpdateRequest $request, $id)
    {
        try {

            $doctor = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Doctor updated.',
                'data'    => $doctor->toArray(),
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
                'message' => 'Doctor deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Doctor deleted.');
    }
}
