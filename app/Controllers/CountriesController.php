<?php

namespace App\Controllers;

use App\Controllers\Controller;
use Respect\Validation\Validator as v;
use App\Models\Country;

class CountriesController extends Controller
{
    
    /**
    * List all countries
    *
    * @return
    */
    public function index($request, $response, $args)
    {

        //find all countries
        $countries = Country::all();
        return $this->view->render($response, 'countries/index.twig', ['countries'=>$countries]);
    }



    /**
    * Display a country
    *
    * @return
    */
    public function view($request, $response, $args)
    {
        $country = Country::find($args['id']);
        
        return $this->view->render($response, 'countries/view.twig', ['country'=>$country]);
    }


    
    /**
    * Create A New country
    *
    * @return
    */
    public function add($request, $response, $args)
    {
        if ($request->isPost()) {
           
            /**
            * validate input before submission
            * @var
            *
            */
            $validation = $this->validator->validate($request, [
                'code' => v::notEmpty(),
                'name' => v::notEmpty(),
            ]);


            //redirect if validation fails
            if ($validation->failed()) {
                $this->flash->addMessage('error', 'Validation Failed!');
        
                return $response->withRedirect($this->router->pathFor('countries/add.twig'));
            }
        
            $country = Country::create([
                'code' => $request->getParam('code'),
                'name' => $request->getParam('name'),
            ]);

            $this->flash->addMessage('success', 'Country Added Successfully');
            //redirect to eg. countries/view/8
            return $response->withRedirect($this->router->pathFor('countries.view', ['id'=>$country->id]));
        }
        return $this->view->render($response, 'countries/add.twig');
    }

    
    
    /**
    * Edit country
    *
    * @return
    */
    public function edit($request, $response, $args)
    {
    
              //find the country
        $country = Country::find($args['id']);

        //only admin and the person that created the country can edit or delete it.
        if ($this->auth->user()->role_id > 2) {
            $this->flash->addMessage('error', 'You are not allowed to perform this action!');
            
            return $this->view->render($response, 'countries/edit.twig', ['country'=>$country]);
        }
                
        //if form was submitted
        if ($request->isPost()) {
            $validation = $this->validator->validate($request, [
                'code' => v::notEmpty(),
                'name' => v::notEmpty(),
            ]);
            //redirect if validation fails
            if ($validation->failed()) {
                $this->flash->addMessage('error', 'Validation Failed!');
        
                return $this->view->render($response, 'countries/edit.twig', ['country'=>$country]);
            }
        
            //save Data
            $country =  Country::where('id', $args['id'])
                            ->update([
                                'code' => $request->getParam('code'),
                                'name' => $request->getParam('name')
                                ]);
            
            if ($country) {
                $this->flash->addMessage('success', 'Country Updated Successfully');
                //redirect to eg. countries/view/8
                return $response->withRedirect($this->router->pathFor('countries.view', ['id'=>$args['id']]));
            }
        }
        
        
        return $this->view->render($response, 'countries/edit.twig', ['country'=>$country]);
    }


    /**
    * Delete a country
    *
    * @return
    */
    public function delete($request, $response, $args)
    {
        $country = Country::find($args['id']);
        if ($country->delete()) {
            $this->flash->addMessage('success', 'Country Deleted Successfully');
            return $response->withRedirect($this->router->pathFor('countries.index'));
        }
    }
}
