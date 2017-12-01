<?php
namespace MicroConfig;

class ConfigNamespaceNotFound extends ConfigError {
  
   /**
    * Provides the indicated reason that the namespace was not found
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
    * Provides the namespace that was not found
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
    * @param string $reason indicate reason that the namespace was not found
    * @param string $namespace namespace that was not found
    */
   public function __construct(string $reason, string $namespace) {
      
      $this->_reason = $reason;
      
      $this->_namespace = $namespace;
      
      parent::__construct("configuration namespace not found: ".$reason);
      
   }
   
}