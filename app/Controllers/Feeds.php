<?php

namespace App\Controllers;

use App\Models\FeedsModel;
use CodeIgniter\RESTful\ResourceController;

class Feeds extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    public function index()
    {
        $product        = new FeedsModel();
        $records['products'] = $product->select('*')
                                    -> orderBy('id','DESC')
                                    -> findAll();
        $records['message'] = "Success";
        $records['status'] = 200;  
        return $this->respond($records);
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        $product        = new FeedsModel();
        $record['feeds']        = $product->select('*')
                                    ->where('owner', $id)->findAll();
        $record['message']  = "Success";
        $record['size']  = sizeof($record['feeds']);
        $record['status'] = 200; 
        return $this->respond($record);
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
        $data       = $this->request->getJSON();
        $product    = new FeedsModel();
        $record      = $product->save($data);

        if($product->errors()){
            return $this->fail($product->errors());
        }
        return $this->respondCreated($record);
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
        $newVal                 = $this->request->getJSON();
        $product                = new FeedsModel();
        $isExist                = $product->find($id);
        $update  = false;
        $data = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Record Updated'
            ]
            ];
            
        if($isExist){
            try {
                $update             = $product->update($id,$newVal);
                if($update){
                    return $this->respondUpdated($data);
                }
            } catch (\Exception $e) {
                return $this->fail('Failed to Update');
            }
        }

        return $this->failNotFound('ID does not exist');
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $data = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Data Deleted'
            ]
            ];
        $product        = new FeedsModel();
        if($id == null){
            return $this->fail('Ivalid ID');
        }
        if(!$product->find($id)){
            return $this->failNotFound('ID Not Found');
        }else{
            $record       = $product->where('id',$id)->delete($id);
            return $this->respondDeleted($data);
        }
    }
}
