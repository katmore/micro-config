<?php
namespace MicroConfig;

class ConfigFileInvalid extends ConfigError {
   
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
    * Provides the configuration path that was found to be invalid
    * 
    * @return string
    */
   public function getConfigPath() : string {
      return $this->_configPath;
   }
   
   /**
    * @var string
    */
   private $_configPath;
   
   /**
    * Provides the namespace having the invalid configuration file
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
    * @param string $reason indicate reason for invalid configuration
    * @param string $configPath configuration path that was found to be invalid
    * @param string $namespace namespace having the invalid configuration file
    */
   public function __construct(string $reason, string $configPath, string $namespace) {
      
      $this->_reason = $reason;
      
      $this->_configPath = $configPath;
      
      $this->_namespace = $namespace;
      
      parent::__construct("invalid configuration file: ".$reason);
      
   }
   
}