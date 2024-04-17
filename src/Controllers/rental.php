<?php 

use Slim\Http\Request; //namespace 
use Slim\Http\Response; //namespace 

//include adminProc.php file 
include __DIR__ .'/function/rentalProc.php';


$app->add(function ($request, $handler) {
    $response = $handler->handle($request);
    return $response
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
        ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

// Handle CORS Pre-Flight
$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});
//end

// FOR RENTAL

//read table rental 
$app->get('/rental', function (Request $request, Response $response, array $arg){

    return $this->response->withJson(array('data' => 'success'), 200); });  
 
// read all data from table rental 
$app->get('/allrental',function (Request $request, Response $response,  array $arg) { 

    $data = getAllrental($this->db); 
    if (is_null($data)) { 

        return $this->response->withHeader('Access-Control-Allow-Origin', '*')->withJson(array('error' => 'no data'), 404); 
} 
    return $this->response->withJson(array('data' => $data), 200); }); 

//request table order by condition (rental id) 
$app->get('/rental/[{id}]', function ($request, $response, $args){   
    $rentalId = $args['id']; 
    if (!is_numeric($rentalId)) { 

        return $this->response->withJson(array('error' => 'numeric paremeter required'), 500);  
} 
    $data = getrental($this->db, $rentalId); 
    if (empty($data)) { 

        return $this->response->withJson(array('error' => 'no data'), 500); 
} 

return $this->response->withJson(array('data' => $data), 200);});

//post method order
$app->post('/rental/add', function ($request, $response, $args) { 

    $form_data = $request->getParsedBody(); 
    $data = createrental($this->db, $form_data); 
    if (is_null($data)) { 

        return $this->response->withHeader('Access-Control-Allow-Origin', '*')->withJson(array('error' => 'no data'), 404); 
} 
    return $this->response->withJson(array('data' => $data), 200); }); 


//delete row Order
$app->delete('/rental/del/[{id}]', function ($request, $response, $args){   
    $rentalId = $args['id']; 
    
   if (!is_numeric($rentalId)) { 

       return $this->response->withJson(array('error' => 'numeric paremeter required'), 422); } 
       $data = deleterental($this->db,$rentalId); 
       if (empty($data)) { 

           return $this->response->withJson(array($rentalId=> 'is successfully deleted'), 202);}; }); 
 

   
//put table order 
$app->put('/rental/put/[{id}]', function ($request, $response, $args){
    $rentalId = $args['id']; 
    
    if (!is_numeric($rentalId)) { 
        
        return $this->response->withJson(array('error' => 'numeric paremeter required'), 422); } 
        $form_dat=$request->getParsedBody(); 
        $data=updaterental($this->db,$form_dat,$rentalId); 
        if ($data <=0)
        return $this->response->withJson(array('data' => 'successfully updated'), 200); 
});

// FOR BUY

//read table buy 
$app->get('/buy', function (Request $request, Response $response, array $arg){

    return $this->response->withJson(array('data' => 'yahoo'), 200); });  
 
// read all data from table buy 
$app->get('/allbuy',function (Request $request, Response $response,  array $arg) { 

    $data = getAllbuy($this->db); 
    if (is_null($data)) { 

        return $this->response->withHeader('Access-Control-Allow-Origin', '*')->withJson(array('error' => 'no data'), 404); 
} 
    return $this->response->withJson(array('data' => $data), 200); }); 

//request table order by condition (rental id) 
$app->get('/buy/[{id}]', function ($request, $response, $args){   
    $buyId = $args['id']; 
    if (!is_numeric($buyId)) { 

        return $this->response->withJson(array('error' => 'numeric paremeter required'), 500);  
} 
    $data = getbuy($this->db, $buyId); 
    if (empty($data)) { 

        return $this->response->withJson(array('error' => 'no data'), 500); 
} 

return $this->response->withJson(array('data' => $data), 200);});

//post method order
$app->post('/buy/add', function (Request $request, Response $response, array $args) {
    $this->get('logger')->info("Post request to /buy/add");
    try {
        $form_data = $request->getParsedBody();
        $data = createbuy($this->db, $form_data);
        if (!$data) {
            return $response->withHeader('Access-Control-Allow-Origin', '')
                            ->withJson(['error' => 'Failed to create record'], 500);
        }
        return $response->withHeader('Access-Control-Allow-Origin', '')
                        ->withJson(['data' => $data], 201);
    } catch (Exception $e) {
        return $response->withHeader('Access-Control-Allow-Origin', '*')
                        ->withJson(['error' => 'Server Error: ' . $e->getMessage()], 500);
    }
});
$app->get('/ping', function ($request, $response, $args) {
    return $response->withJson(['message' => 'pong']);
});
//delete row Order
$app->delete('/buy/del/[{id}]', function ($request, $response, $args){   
    $buyId = $args['id']; 
    
   if (!is_numeric($buyId)) { 

       return $this->response->withJson(array('error' => 'numeric paremeter required'), 422); } 
       $data = deletebuy($this->db,$buyId); 
       if (empty($data)) { 

           return $this->response->withJson(array($buyId=> 'is successfully deleted'), 202);}; }); 
 

   
//put table order 
$app->put('/buy/put/[{id}]', function ($request, $response, $args){
    $buyId = $args['id']; 
    
    if (!is_numeric($buyId)) { 
        
        return $this->response->withJson(array('error' => 'numeric paremeter required'), 422); } 
        $form_dat=$request->getParsedBody(); 
        $data=updatebuy($this->db,$form_dat,$buyId); 
        if ($data <=0)
        return $this->response->withJson(array('data' => 'successfully updated'), 200); 
});