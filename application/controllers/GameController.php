<?php

/**
 * The Game-Controller contains actions to show content about the developed game
 * 
 * @author TH<>
 */
class GameController extends GamingBlog_Controller_Action
{
    protected $_defaultAction = 'about';
    
    /**
     * The about-action shows general information about the developed game
     * 
     * @author TH<>
     */
    public function aboutAction()
    {
        $this->_view->render('game/about.tpl');
    }
}

