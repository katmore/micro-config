<?php
namespace MicroConfig;

class ConfigNamespaceInvalid extends ConfigError {
   
   /**
    * Provides the indicated reason for invalid configuration
    *
    * @return string
    */
   public function getReason() : string {
      return $this->_reason;
   }
   
   
   /**
    * @var string
    */
   private $_reason;
  
   /**
    * Provides the value of the invalid namespace
    *
    * @return string
    */
   public function getNamespace() : string {
      return $this->_namespace;
   }
   
   /**
    * @var string
    */
   private $_namespace;
   
   /**
    * @param string $reason indicate reason for invalid namespace
    * @param string $namespace value of the invalid namespace 
    */
   public function __construct(string $reason, string $namespace) {
      
      $this->_reason = $reason;
      
      $this->_namespace = $namespace;
      
      parent::__construct("invalid configuration namespace specified: ".$reason);
      
   }
   
}