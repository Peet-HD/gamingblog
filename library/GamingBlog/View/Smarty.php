<?php

/**
 * The view-class encapsulating the smarty-class for viewing templates
 * 
 * @author TH<>
 */
class GamingBlog_View_Smarty
{
    /**
     * The original smarty-object, which is encapsulated by this class
     * 
     * @var Smarty 
     */
    protected $_smarty = null;
    
    /**
     * The config-array, which should hold smarty-relevant configuration-data
     * @var array 
     */
    protected $_config = null;
    
    /**
     * The cache-id for the current rendering
     * 
     * @var string
     */
    protected $_cacheId = '';
    
    public function __construct($pConfigArr) {
        $this->_config = $pConfigArr;
        
        require_once('Smarty\Smarty.class.php');
        $this->_smarty = new Smarty();
        
        if (($this->_config !== null) &&
            (isset($this->_config['caching'])) &&
            (isset($this->_config['cache_lifetime'])) &&
            (isset($this->_config['template_dir'])) &&
            (isset($this->_config['compile_dir'])) &&
            (isset($this->_config['cache_dir'])) &&
            (isset($this->_config['left_delimiter'])) &&
            (isset($this->_config['right_delimiter'])))
        {
            $this->_smarty->setCaching($this->_config['caching']);
            $this->_smarty->setCacheLifetime($this->_config['cache_lifetime']);
            $this->_smarty->setTemplateDir($this->_config['template_dir']);
            $this->_smarty->setCompileDir($this->_config['compile_dir']);
            $this->_smarty->setCacheDir($this->_config['cache_dir']);
            $this->_smarty->setLeftDelimiter($this->_config['left_delimiter']);
            $this->_smarty->setRightDelimiter($this->_config['right_delimiter']);
            
            //$this->_smarty->debugging = $this->_config['debugging'];

            $this->assign('this', $this);
        } else {
            throw new Zend_View_Exception("Not enough config-data for smarty");
        }
    }
    
    public function prepareCacheId($controller, $action, $params)
    {
        $cacheId = '/' . $controller . '/' . $action;
        
        if (isset($params['controller']))
        {
            unset($params['controller']);
        }
        if (isset($params['action']))
        {
            unset($params['action']);
        }
        if (isset($params['module']))
        {
            unset($params['module']);
        }
        
        if (!empty($params))
        {
            $cacheId .= '?';
            $first = true;
            foreach ($params as $key => $val)
            {
                if (!$first)
                {
                    $cacheId = '&';
                } else {
                    $first = false;
                }
                $cacheId .= $key . '=' . $val;
            }
        }
        
        $this->_cacheId = md5($cacheId);
    }
    
    /**
     * Assigns a variable to the view
     * 
     * @param string $keyName
     * @param mixed $value
     */
    public function __set($keyName, $value) {
       $this->assign($keyName, $value);
    }
    
    /**
     * Returns a given key-value if set
     * 
     * @param string $key
     * @return mixed
     */
    public function __get($key)
    {
        $smarty_var = $this->_smarty->getVariable($key);

        return $smarty_var->value;
    }
    
    /**
     * Checks, whether a key is set in the view or not
     * 
     * @param string $key
     * @return mixed
     */
    public function __isset($key)
    {
        return (null !== $this->_smarty->getTemplateVars($key));
    }
    
    /**
     * Unsets the given key, if set in the smarty-view
     * 
     * @param string $key
     */
    public function __unset($key)
    {
        $this->_smarty->clearAssign($key);
    }
    
    /**
     * Assigns a value with the given key to the smarty-view
     * 
     * @param string $key
     * @param mixed $value
     */
    public function assign($key, $value = null)
    {
        if (is_array($key)) {
            $this->_smarty->assign($key);
            return;
        }
        $this->_smarty->assign($key, $value);
    }
    
    /**
     * Clears all assigned variables from the smarty-view
     */
    public function clearVariables()
    {
        $this->_smarty->clearAllAssign();
    }
    
    /**
     * Renders the given template and stops the php-code
     * 
     * @param string $path
     */
    public function render($path)
    {
        if ($this->_smarty->caching && !empty($this->_cacheId))
        {
            print $this->_smarty->fetch($path, $this->_cacheId);
        } else {
            print $this->_smarty->fetch($path);
        }
        exit();
    }
}