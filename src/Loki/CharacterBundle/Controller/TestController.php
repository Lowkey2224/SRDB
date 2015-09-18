<?php
/**
 * Created by Marcus "Loki" Jenz 
 * Date: 07.05.14
 * Time: 10:47
 */

namespace Loki\CharacterBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class TestController
 * @package Loki\CharacterBundle\Controller
 */
class TestController extends Controller{

    /**
     * @Route("/index" ,name="test_index")
     * @Template("LokiCharacterBundle:Test:index.html.php")
     */
    public function indexAction()
    {
        $s = $this->get('session');
        return array();
    }

    /**
     * @Route("/todo" ,name="test_todo")
     * @Template("LokiCharacterBundle:Test:todo.html.php")
     */
    public function todoAction()
    {

        return array();
    }

} 