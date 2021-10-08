<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Exception;

class Product extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
    {
        $product        = new ProductModel();
        $records['products'] = $product->select('*, TIMESTAMPDIFF(DAY, bday, CURDATE()) as days')
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
            $product        = new ProductModel();
            $record        = $product->select('*, TIMESTAMPDIFF(DAY, bday, CURDATE()) as days')
                                    ->where('id',$id)->first();
            if(!$record){
                return $this->failNotFound('ID Not Found');
            }
            return $this->respond($record);
    }

    function wordtoNumber($data,$key){
        $key = strtolower($key);
        $count  = 0;
        foreach ($data as $item){
            if($key == $item){
                return $count;
            }
            $count++;
        }
        return $key;
    }
    public function showBatch($key = null){
        $type_word       = $this->wordtoNumber(["pig","cow"],$key);
        $pre_word        = $this->wordtoNumber(["yes","no"],$key);
        $product        = new ProductModel();
        $record['products'] = [];
        if($key != "" && isset($key)){
            $record['products']     = $product->select('*, TIMESTAMPDIFF(DAY, bday, CURDATE()) as days')
            ->like('id', $key)
            ->orLike('type',$type_word,'after')
            ->orLike('bday',$key, 'after')
            ->orLike('weight',$key, 'after')
            ->orLike('pregnant',$pre_word)
            ->findAll();
        }
        
        $record['message']  = "Success";
        $record['size']  = sizeof($record['products']);
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
        $product    = new ProductModel();
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
       
    }
    public function setSold($action = null,$id  = null){
        $param          = [];
        if($action == "sold"){
            $param                  = ['sold' => 1];
        }
        if($action == "unsold"){
            $param                  = ['sold' => 0];
        }
        if(sizeof($param) == 0){
            return $this->respond('Failed to perform action');
        }
        $product                = new ProductModel();
        $isExist                = $product->find($id);
        $update                 = false;
        $data = [
            'status' => 200,
            'error' => null,
            'messages' => [
                'success' => 'Record Updated'
            ]
            ];

        if($isExist){
            try {
                $update             = $product->update($id,$param);
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
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        $newVal                 = $this->request->getJSON();
        if($newVal->pregnant == 0){
            $newVal->due = "";
        }
        $product                = new ProductModel();
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
        $product        = new ProductModel();
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
