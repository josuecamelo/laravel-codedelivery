<?php

namespace CodeDelivery\Http\Controllers;

use CodeDelivery\Http\Requests;
use CodeDelivery\Repositories\ClientRepository;
use CodeDelivery\Services\ClientService;

/*class ClientsController extends Controller
{
    private $repository;

    public function __construct(ClientRepository $repository){
        $this->repository = $repository;
    }
    public function index(){
        $clients = $this->repository->paginate(10);
        return view('admin.clients.index', compact('clients'));
    }

    public function create(){
        return view('admin.clients.create');
    }

    public function store(Requests\AdminClientRequest $request){
        $data = $request->all();
        $this->repository->create($data);

        return redirect()->route('admin.clients.index');
    }

    public function edit($id){
        $client = $this->repository->find($id);
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Requests\AdminClientRequest $request, $id){
        $data = $request->all();
        $this->repository->update($data, $id);

        return redirect()->route('admin.clients.index');
    }

    public function destroy($id){
        $this->repository->delete($id);

        return redirect()->route('admin.clients.index');
    }
}*/

//Service
class ClientsController extends Controller
{
    /**
     * @var ClientRepository
     */
    private $repository;
    /**
     * @var ClientService
     */
    private $clientService;

    public function __construct(ClientRepository $repository, ClientService $clientService)
    {
        $this->repository = $repository;
        $this->clientService = $clientService;
    }

    public function index()
    {
        $clients = $this->repository->paginate();
        return view('admin.clients.index',compact('clients'));
    }

    public function create()
    {
        return view('admin.clients.create');
    }

    public function store(Requests\AdminClientRequest $request)
    {
        $data = $request->all();
        $this->clientService->create($data);

        return redirect()->route('admin.clients.index');
    }

    public function edit($id)
    {
        $client = $this->repository->find($id);
        
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Requests\AdminClientRequest $request, $id)
    {
        $data = $request->all();
        $this->clientService->update($data,$id);
        return redirect()->route('admin.clients.index');
    }
}
