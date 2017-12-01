<?php
namespace MicroConfig;

class ConfigController {

   final protected static function _camelToSnake(string $input) : string {
      /*
       * refactored from https://stackoverflow.com/questions/1993721/how-to-convert-camelcase-to-camel-case
       */
      preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
      $ret = $matches[0];
      foreach ($ret as &$match) {
         $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
      }
      return implode('_', $ret);
   }
   
   final protected static function _namespaceToSub(string $namespace) : array {
      $ns = $settingNamespace;
      
      $ns = str_replace('\\', '/', $ns);
      
      $ns = self::_camelToSnake($ns);
      
      $ns = str_replace('_',"-", $ns);
      
      return explode('/',$ns);
      
   }
   
   private $_configSettingVal = [];
   
   public function enumSettings(string $configNamespace) : array {
      
      if (empty($configNamespace)) {
         throw new ConfigNamespaceInvalid("cannot be empty",$configNamespace);
      }
      
      $ns = $configNamespace;
      
      $ns = str_replace('\\', '/', $ns);
      
      $ns = self::_camelToSnake($ns);
      
      $ns = str_replace('_',"-", $ns);
      
      $sub = explode('/',$ns);
      
      $configNsPrefix = implode('/',$sub);
      
      if (!isset($this->_configSettingVal[$configNsPrefix])) {
         
         $configPath =  "{$this->_configRoot}/$configNsPrefix.php";
         
         $configPath = str_replace('/',\DIRECTORY_SEPARATOR,$configPath);
         
         if (!is_file($configPath) && is_readable($configPath)) {
            
            if ($fallbackValue===null) {
               throw new ConfigNamespaceNotFound("missing corresponding config file", $configNamespace);
            }
            
            return $fallbackValue;
         }
         
         $configVal = (function() use($configPath) {
            return require $configPath;
         })();
         
         if (!is_array($configVal)) {
            throw new ConfigFileInvalid("does not return an array value", $configPath, $configNamespace);
         }
         
         $this->_configSettingVal[$configNsPrefix] = [];
         
         foreach($configVal as $ck=>$v) {
            
            $sk = $ck;
            
            $sk = self::_camelToSnake($sk);
            
            $sk = str_replace('_',"-", $sk);
            
            $this->_configSettingVal[$configNsPrefix][$sk] = $v;
            
         }
         unset($k);
         unset($v);
         unset($sk);
         
      }
      
      return $this->_configSettingVal[$configNsPrefix];
   }

   
   /**
    * Provides a config setting value
    * 
    * @param string $settingNamespace
    * @param mixed $fallbackValue optional fallback value if setting is not found
    * 
    * @return mixed
    */
   public function getSettingValue(string $settingNamespace, $fallbackValue=null) {
      
      if (empty($settingNamespace)) {
         throw new ConfigNamespaceInvalid("cannot be empty",$settingNamespace);
      }
      
      $sub = self::_namespaceToSub($settingNamespace);
      
      $settingKey = array_pop($sub);
      
      $configNamespace = implode('/',$sub);
      
      $this->enumSettings($configNamespace);
      
      if (!isset($this->_configSettingVal[$configNamespace][$settingKey])) {
         
         if ($fallbackValue===null) {
            throw new ConfigNamespaceNotFound("setting does not exist in corresponding config file", $settingNamespace);
         }
         
         return $fallbackValue;
         
      }
   }
   
   /**
    * @var string
    */
   private $_configRoot;
   
   /**
    * @param string $configRoot path to the configuration root directory
    * 
    * @throws \MicroConfig\ConfigRootInvalid
    */
   public function __construct(string $configRoot) {
      
      if (!is_dir($configRoot) || !is_readable($configRoot)) {
         throw new ConfigRootInvalid('configRoot is not a readable directory', $configRoot);
      }
      
      $this->_configRoot = $configRoot;
      
   }
   
}