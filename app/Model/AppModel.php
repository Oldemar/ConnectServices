<?php
/**
 * Application model for Cake.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');

/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model {

    /**
     * Include a Model, create an empty object and return the instance.
     * @param string $modelClassName -> Name of the model that you want to load
     * @return Model
     */
    protected function &loadModel($modelClassName){
    	ClassRegistry::removeObject($modelClassName);
		
        if(ClassRegistry::getObject($modelClassName)){
            return ClassRegistry::getObject($modelClassName);
        }else{
        	unset($this->$modelClassName);
            if(is_object($this->$modelClassName)){
                return $this->$modelClassName;
            }
			$x = ClassRegistry::init($modelClassName);
			$this->$modelClassName = $x;
			
            return $x;
        }
    }
    
    /**
     * Return an array with objects populated with the data provided on the parameter
     * 
     * @param array $data -> Data fetched using $this->find
     * @param int $buildBelongingObjects Defines if associated models(belongsTo) have to be instanciated as well.
     *          (
     *              0 => It is not instanciated any related model
     *              1 => The direct related models are instanciated
     *              2 => The related models of related models are instanciate 
     *          )
     * 
     * @return Model
     */
    protected function buildObjectList($data, $buildBelongingObjects = 0){
        if(is_array($data)){
            $arrReturn = array();
            foreach($data as $key => $value){
                $arrReturn[] = $this->buildObject($value,$buildBelongingObjects);
            }
        }else{
            return true;
        }
        
        return $arrReturn;
    }
    
    /**
     * Return a populated object with the data provided on the parameter
     *
     * @param array $data -> Data fetched using $this->find
     * @param int $buildBelongingObjects Defines if associated models(belongsTo) have to be instanciated as well.
     *          (
     *              0 => It is not instanciated any related model
     *              1 => The direct related models are instanciated
     *              2 => The related models of related models are instanciate
     *          )
     *
     * @return Model
     */
    protected function buildObject($data, $buildBelongingObjects = 0, $className = null){
        $tmpObject                       = clone $this;
        if($className && count($data[$className]) > 0){
        	$tmpObject->data[$this->alias]   = $data[$className];
			$tmpObject->id					 = $data[$className][$tmpObject->primaryKey];
        }else{
        	$tmpObject->data[$this->alias]   = $data[$this->alias];
			$tmpObject->id					 = $data[$this->alias][$tmpObject->primaryKey];	
        }
         
        
		
        if($buildBelongingObjects > 0){
            if($buildBelongingObjects > 0){
	            $buildBelongingObjects--;
	        }
            foreach($this->belongsTo as $key => $value){
                
                if(isset($data[$key])){
                    $belongObj = $this->loadModel($value['className']);
                    $tmpObject->$key = $belongObj->buildObject($data,$buildBelongingObjects,$key);
                }   
                
            }
            
            foreach($this->hasOne as $key => $value){
            	if(isset($data[$key])){
            		$hasOneObj = $this->loadModel($value['className']);
            		$tmpObject->$key = $hasOneObj->buildObject($data,$buildBelongingObjects,$key);
            	}
            
            }
            
        }
        
        return $tmpObject;
    }
    
    function findObjects($type='first', $query=array(),$buildBelongingObjects=1){
        if($buildBelongingObjects == 0){
            $query['recursive'] = -1;
        }
        if(!isset($query['recursive'])){
            $query['recursive'] = 0;
        }
        
        if($buildBelongingObjects >= 1){
            $query['recursive'] = 0;
        }
        
        if($query['recursive'] == -1){
            $buildBelongingObjects = 0;
        }
       
	    
        if($type == 'first'){
            return $this->buildObject($this->find($type,$query),$buildBelongingObjects);
        }else{
            return $this->buildObjectList($this->find($type,$query),$buildBelongingObjects);
        }
    } 
    
    function findById($id,$query=array(),$buildBelongingObjects=1){
        if(!$query){
            $query = array();
        }
        
        $query['conditions'][$this->alias.'.id'] = $id;
        
        return $this->findObjects('first',$query,$buildBelongingObjects);
    }
    
    function findBy($fieldName,$fieldValue, $type='first', $query=array(),$buildBelongingObjects=1){
        if(!$query){
            $query = array();
        }
    
        $query['conditions'][$this->alias.'.'.$fieldName] = $fieldValue;
    
        return $this->findObjects($type,$query,$buildBelongingObjects);
    }
    
    /**
    * Build one belongsTo relation
    * @param: $modelName Model Name
    **/
    function buildBelong($modelName){
    	if(!isset($this->belongsTo[$modelName])){
    		throw new Exception("Model ".$modelName.' doesn\'t belong to '.get_class($this), 1);
    	}
    	$fkName = $this->belongsTo[$modelName]['foreignKey'];
        if($this->getAttr($fkName) !== null){
        	if(!is_object($this->$modelName)){
            	$this->$modelName = $this->loadModel($modelName);
			}
            $this->$modelName = $this->$modelName->findById($this->getAttr($fkName),array(),0);
        }   
    }
    
    function buildHasMany($hasManyModelName,$query=array(),$buildBelongingObjects=0){    
        if(!array_key_exists($hasManyModelName,$this->hasMany)){
            exit('Model name '.$hasManyModelName.'  doesn\'t exists in hasMany');
        }
        
        
        $finalQuery = array();
        $finalQuery['recursive'] = -1;
        $finalQuery['conditions'] = array($hasManyModelName.'.'.$this->hasMany[$hasManyModelName]['foreignKey'] => $this->getID());
        
        if(isset($query['conditions'])){
        	foreach($query['conditions'] as $key => $value){
        		$finalQuery['conditions'][] = $value;
        	}
        }
        
        foreach($query as $key => $value){
        	if(!isset($finalQuery[$key])){
        		$finalQuery[$key] = $value;
        	}
        }
        
        
        $this->loadModel($hasManyModelName);
        
        $this->$hasManyModelName = $this->$hasManyModelName->findObjects('all',$finalQuery,$buildBelongingObjects);
        
        
    }
    
    function buildHasManyAll(){
        foreach($this->hasMany as $key => $value){
            $this->loadModel($key);
            $this->$key = $this->$key->findObjects('all',array('recursive'=>-1,array('conditions'=>$key.'.'.$value['foreignKey'])),0);
        }
    }
    
    /**
     * Returns the value of $this->data[ModelName][$attrName]
     */
    function getAttr($attrName){
        if(isset($this->data[$this->alias][$attrName])){
            return $this->data[$this->alias][$attrName];
        }else{
            return null;
        }
    }
	
	/**
	 * Returns the ID of current object
	 */
	function getPrimaryId(){
		if(is_numeric($this->getID()) && $this->getID()){
			return $this->getID();
		}else{
			if(isset($this->data[$this->alias]['id'])){
				return $this->data[$this->alias]['id'];
			}
		}
	}

    function iterate(){
        $arrParamsGiven = func_get_args();
        $array = $arrParamsGiven[0];
        $method = $arrParamsGiven[1];
        
        if(!is_array($array)){
            return false;
        }
        
        
        array_shift($arrParamsGiven);
        array_shift($arrParamsGiven);
        
        
        foreach($array as $key => $value){
            if(is_object($value)){                
                call_user_func_array(array($value, $method), $arrParamsGiven);
            }    
        }       
    } 
	
	/**
	*	Returns the instance of the objectRequested. If it doesn't exists the methods tries to load
	*   @param: $modelName
	*   Example of usage:
		*	on the controller:
		*		$objUser = $this->User->findById('123',array(),0); //Doesnt Load the belongsTo Picture
		*		$objPicture = $this->getObject('Picture');
	**/
	function getObject($modelName){
		
		if(!is_object($this->$modelName) || !$this->$modelName->getID()){
			if(array_key_exists($modelName , $this->belongsTo)){
				
				$$modelName = $this->loadModel($modelName);
				
				$fk = $this->belongsTo[$modelName]['foreignKey'];
				
				if(strlen($this->getAttr($fk)) !== 0){
					$this->$modelName = $this->$modelName->findById($this->getAttr($fk),array(),0);
				}else{
					$this->$modelName = $this->$modelName;
				}
			}
		}
		
		if(is_object($this->$modelName)){
			return $this->$modelName;
		}
	}
	
	/**
	 * 
	 * Loads the Obj pass as parameters. The loaded Object must be : belongsTo
	 * 
	 * @param Obj $modelName
	 */
	public function &loadObject($modelName){
		$this->getObject($modelName);
		return $this;
	}
	
	public function savePersist($data = null, $validate = true, $fieldList = array()){	
		$tmpObj = clone $this;
	
		$data = $tmpObj->save($data,$validate,$fieldList);
		if($data){
			$pk = $tmpObj->primaryKey;
			$this->$pk = $data[$tmpObj->alias][$pk];
		}
		return $data;
	}
	
}
