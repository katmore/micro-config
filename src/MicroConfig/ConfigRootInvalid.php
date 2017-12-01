<?php
namespace MicroConfig;

class ConfigRootInvalid extends ConfigError {
   
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
    * Provides the configuration root directory path having the invalid configuration
    * 
    * @return string
    */
   public function getConfigRoot() : string {
      return $this->_configRoot;
   }
   
   /**
    * @var string
    */
   private $_configRoot;
   
   /**
    * @param string $reason indicate reason for invalid configuration
    * @param string $configRoot configuration root directory path having the invalid configuration
    */
   public function __construct(string $reason, string $configRoot) {
      
      $this->_reason = $reason;
      
      $this->_configRoot = $configRoot;
      
      parent::__construct("invalid configuration: ".$reason);
      
   }
   
}