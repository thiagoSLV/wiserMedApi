<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PacientCreateRequest;
use App\Http\Requests\PacientUpdateRequest;
use App\Repositories\PacientRepositoryEloquent;
use App\Validators\PacientValidator;
use App\Models\Pacient;

/**
 * Class PacientsController.
 *
 * @package namespace App\Http\Controllers;
 */
class PacientsController extends Controller
{
    /**
     * @var PacientRepository
     */
    protected $repository;

    /**
     * @var PacientValidator
     */
    protected $validator;

    /**
     * PacientsController constructor.
     *
     * @param PacientRepository $repository
     * @param PacientValidator $validator
     * @param PacientResource $resource
     */
    public function __construct(PacientRepositoryEloquent $repository, PacientValidator $validator)
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
        $pacients = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $pacients,
            ]);
        }

        return view('pacients.index', compact('pacients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PacientCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PacientCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $pacient = $this->repository->create($request->all());

            $response = [
                'message' => 'Pacient created.',
                'data'    => $pacient->toArray(),
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
        $pacient = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $pacient,
            ]);
        }

        return view('pacients.show', compact('pacient'));
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
        $pacient = $this->repository->find($id);

        return view('pacients.edit', compact('pacient'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PacientUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PacientUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $pacient = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'Pacient updated.',
                'data'    => $pacient->toArray(),
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
                'message' => 'Pacient deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'Pacient deleted.');
    }

    public function getAllPacients()
    {
        return $this->repository->getAll();
    }

    public function getPacient($id)
    {
        return $this->repository->getPacient($id);
    }
}
