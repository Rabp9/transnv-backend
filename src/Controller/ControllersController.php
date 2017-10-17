<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Controllers Controller
 *
 * @property \App\Model\Table\ControllersTable $Controllers
 *
 * @method \App\Model\Entity\Controller[] paginate($object = null, array $settings = [])
 */
class ControllersController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $controllers = $this->Controllers->find();

        $this->set(compact('controllers'));
        $this->set('_serialize', ['controllers']);
    }
}
