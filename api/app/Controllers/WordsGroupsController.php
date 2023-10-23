<?php

namespace app\Controllers;

use Exception;
use \RedBeanPHP\R as R;
use libs\Responses\MsgHandler as MsgH;
use libs\Exceptions\ExceptionHandlerFactory;
use libs\Exceptions\BaseExceptionCollection;
use app\Services\WordsGroupsService;
use app\Factories\WordsGroupsFactory;
use app\Factories\WordsGroupsDetailsFactory;
use app\Models\WordsGroups;
use app\Models\WordsGroupsDetails;

class WordsGroupsController
{ 
    public function find($request, $response, $args)
    {        
        $WordsGroupsDetails = new WordsGroupsDetails();

        try {
            $result = $WordsGroupsDetails->findByWgID($args['id']);
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }

    public function findAll($request, $response, $args)
    {
        $WordsGroupsModel = new WordsGroups();
        $WordsGroupsDetails = new WordsGroupsDetails();

        try {
            $result = $WordsGroupsModel->findAll();
            $i=0;
            if(count($result) > 0){
                foreach($result as $item){
                    $result[$i]['details'] = $WordsGroupsDetails->findByWgID($item['id']);
                    $i++;
                }
            }
            
        } catch (Exception $e) {
            return MsgH::ServerError($response);
        }

        return $response->withJson($result, 200);
    }
 
    public function add($request, $response, $args)
    {
        $data = $request->getParsedBody();
        $WordsGroupsService = new WordsGroupsService();
        $WordsGroupsFactory = new WordsGroupsFactory();      
        $WordsGroupsDetailsFactory = new WordsGroupsDetailsFactory();    
        $ExceptionHF = new ExceptionHandlerFactory();
        $WordsGroupsModel = new WordsGroups(); 
        $WordsGroupsDetailsModel = new WordsGroupsDetails();

        try {
            $dataRow = $WordsGroupsFactory->createFactory($data, null);
            $wgd_array = $WordsGroupsService->createService($data);
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
        $WordsGroupsService = new WordsGroupsService();     
        $WordsGroupsFactory = new WordsGroupsFactory();    
        $WordsGroupsDetailsFactory = new WordsGroupsDetailsFactory();       
        $ExceptionHF = new ExceptionHandlerFactory();
        $WordsGroupsModel = new WordsGroups();      
        $WordsGroupsDetailsModel = new WordsGroupsDetails();

        try {
            $dataRow = $WordsGroupsFactory->createFactory($data, $args['id']);
            $wgd_array = $WordsGroupsService->createService($data);
            R::begin();
            $WordsGroupsModel->edit($dataRow, $args['id']);
            $WordsGroupsDetailsModel->deleteByWgID($args['id']);
            if($wgd_array){
                foreach($wgd_array as $item){       
                    $new = array();
                    $new['wg_id'] = $args['id'];
                    $new['ws_id'] = $item;
                    $new = $WordsGroupsDetailsFactory->createFactory($new, null);                    
                    $WordsGroupsDetailsModel->add($new);
                }
            }
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
