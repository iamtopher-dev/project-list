<?php

namespace App\Controllers;

use App\Models\Project;
use CodeIgniter\RESTful\ResourceController;

class ProjectController extends ResourceController
{

    public function tester()
    {
        return view('index');
    }
    public function test()
    {
        echo 's';
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {

        $projectModel = new Project();

        $data['list'] = $projectModel->where('p_stats', 0)->findAll();

        $data['total'] = $projectModel->select('SUM(f_price) as tPrice')->first();

        $data['totalPaid'] = $projectModel->select('SUM(f_price) as tPrice')->WHERE("p_stats", 1)->first();
        // print_r($data);

        return view('welcome_message', $data);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        $projectModel = new Project();

        $data = array(
            'project_name' => $this->request->getVar('p_name'),
            'price' => $this->request->getVar('p_price'),
            'f_price' => $this->request->getVar('p_price'),
            'p_stats' => 0,
        );
        if ($projectModel->insert($data)) {
            return redirect()->to('/');
        } else {
            echo "Something went wrong!";
        }
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $projectModel = new Project();

        $projectModel->set('p_stats', 1);
        $projectModel->where('id', $id);
        if ($projectModel->update()) {
            return redirect()->to('/');
        } else {
            echo "Something went wrong!";
        }
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $projectModel = new Project();

        $projectModel->where('id', $id);
        if ($projectModel->delete()) {
            return redirect()->to('/');
        } else {
            echo "Something went wrong!";
        }
    }
}
