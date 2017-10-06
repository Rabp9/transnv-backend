<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ControllerRoles Controller
 *
 * @property \App\Model\Table\ControllerRolesTable $ControllerRoles
 *
 * @method \App\Model\Entity\ControllerRole[] paginate($object = null, array $settings = [])
 */
class ControllerRolesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Controllers', 'Roles']
        ];
        $controllerRoles = $this->paginate($this->ControllerRoles);

        $this->set(compact('controllerRoles'));
        $this->set('_serialize', ['controllerRoles']);
    }

    /**
     * View method
     *
     * @param string|null $id Controller Role id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $controllerRole = $this->ControllerRoles->get($id, [
            'contain' => ['Controllers', 'Roles']
        ]);

        $this->set('controllerRole', $controllerRole);
        $this->set('_serialize', ['controllerRole']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $controllerRole = $this->ControllerRoles->newEntity();
        if ($this->request->is('post')) {
            $controllerRole = $this->ControllerRoles->patchEntity($controllerRole, $this->request->getData());
            if ($this->ControllerRoles->save($controllerRole)) {
                $this->Flash->success(__('The controller role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The controller role could not be saved. Please, try again.'));
        }
        $controllers = $this->ControllerRoles->Controllers->find('list', ['limit' => 200]);
        $roles = $this->ControllerRoles->Roles->find('list', ['limit' => 200]);
        $this->set(compact('controllerRole', 'controllers', 'roles'));
        $this->set('_serialize', ['controllerRole']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Controller Role id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $controllerRole = $this->ControllerRoles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $controllerRole = $this->ControllerRoles->patchEntity($controllerRole, $this->request->getData());
            if ($this->ControllerRoles->save($controllerRole)) {
                $this->Flash->success(__('The controller role has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The controller role could not be saved. Please, try again.'));
        }
        $controllers = $this->ControllerRoles->Controllers->find('list', ['limit' => 200]);
        $roles = $this->ControllerRoles->Roles->find('list', ['limit' => 200]);
        $this->set(compact('controllerRole', 'controllers', 'roles'));
        $this->set('_serialize', ['controllerRole']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Controller Role id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $controllerRole = $this->ControllerRoles->get($id);
        if ($this->ControllerRoles->delete($controllerRole)) {
            $this->Flash->success(__('The controller role has been deleted.'));
        } else {
            $this->Flash->error(__('The controller role could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
