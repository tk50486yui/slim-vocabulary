<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;
use app\Servies\WordsGroupsServie;
use app\Factories\WordsGroupsFactory;
use app\Factories\WordsGroupsDetailsFactory;
use app\Models\WordsGroups;
use app\Models\WordsGroupsDetails;

class WordsGroupsController
{ 
    public function find($request, $response, $args)
    {
        $WordsGroupsModel = new WordsGroups();

        try {
            $result = $WordsGroupsModel->find($args['id']);
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    public function findAll($request, $response, $args)
    {
        $WordsGroupsModel = new WordsGroups();

        try {
            $result = $WordsGroupsModel->findAll();
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }
 
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsGroupsServie = new WordsGroupsServie();
        $WordsGroupsFactory = new WordsGroupsFactory();      
        $WordsGroupsDetailsFactory = new WordsGroupsDetailsFactory();    
        $ExceptionHF = new ExceptionHandlerFactory();
        $WordsGroupsModel = new WordsGroups(); 
        $WordsGroupsDetailsModel = new WordsGroupsDetails();

        try {
            $dataRow = $WordsGroupsFactory->createFactory($data, null);
            $wgd_array = $WordsGroupsServie->createServie($data);
            R::begin();            
            $wg_id = $WordsGroupsModel->add($dataRow);
            if($wgd_array){
                foreach($wgd_array as $item){       
                    $new = array();
                    $new['wg_id'] = $wg_id;
                    $new['ws_id'] = $item;
                    $new = $WordsGroupsDetailsFactory->createFactory($new, null);                    
                    $WordsGroupsDetailsModel->add($new);
                }
            }
            R::commit();          
        } catch (BaseExceptionCollection $e) {  
            R::rollback();
            return $ExceptionHF->createChain()->handle($e, $response);
        } catch (Exception $e) {
            R::rollback();         
            return $ExceptionHF->createDefault()->handle($e, $response);
        }

        return MsgH::Success($response);
    }

    public function edit($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsGroupsFactory = new WordsGroupsFactory();        
        $ExceptionHF = new ExceptionHandlerFactory();
        $WordsGroupsModel = new WordsGroups();      

        try {
            $data = $WordsGroupsFactory->createFactory($data, $args['id']); 
            R::begin();
            $WordsGroupsModel->edit($data, $args['id']);
            R::commit();          
        } catch (BaseExceptionCollection $e) {  
            return $ExceptionHF->createChain()->handle($e, $response);
        } catch (Exception $e) {
            R::rollback();         
            return $ExceptionHF->createDefault()->handle($e, $response);
        }

        return MsgH::Success($response);
    }
}
