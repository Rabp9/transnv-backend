<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;

/**
 * Clientes Controller
 *
 * @property \App\Model\Table\ClientesTable $Clientes
 *
 * @method \App\Model\Entity\Cliente[] paginate($object = null, array $settings = [])
 */
class ClientesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $clientes = $this->Clientes->find()
            ->where(['estado_id' => 1]);
        
        $this->set(compact('clientes'));
        $this->set('_serialize', ['clientes']);
    }
    
    /**
     * Get Admin method
     *
     * @return \Cake\Network\Response|null
     */
    public function getAdmin() {        
        $clientes = $this->Clientes->find();
                
        $this->set(compact('clientes'));
        $this->set('_serialize', ['clientes']);
    }
    
    public function view($id) {
        $cliente = $this->Clientes->get($id);
        
        $this->set(compact('cliente'));
        $this->set('_serialize', ['cliente']);
    }
    
    public function add() {
        $cliente = $this->Clientes->newEntity();
        
        if ($this->request->is('post')) {
            $cliente = $this->Clientes->patchEntity($cliente, $this->request->data);
            
            if ($cliente->imagen) {
                $path_src = WWW_ROOT . "tmp" . DS;
                $file_src = new File($path_src . $cliente->imagen);
             
                $path_dst = WWW_ROOT . 'img' . DS . 'clientes' . DS;
                $cliente->imagen = $this->Random->randomFileName($path_dst, 'cliente-', $file_src->ext());
                
                $file_src->copy($path_dst . $cliente->imagen);
            }
            
            if ($this->Clientes->save($cliente)) {
                $code = 200;
                $message = 'El cliente fue guardado correctamente';
            } else {
                $message = 'El cliente no fue guardado correctamente';
            }
        }
        
        $this->set(compact('cliente', 'message', 'code'));
        $this->set('_serialize', ['cliente', 'message', 'code']);
    }
    
    public function previewImagen() {
        if ($this->request->is("post")) {
            $imagen = $this->request->data["file"];
            
            $path_dst = WWW_ROOT . "tmp" . DS;
            $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
            $filename = 'cliente-' . $this->Random->randomString() . '.' . $ext;
           
            $filename_src = $imagen["tmp_name"];
            $file_src = new File($filename_src);

            if ($file_src->copy($path_dst . $filename)) {
                $code = 200;
                $message = 'La imagen fue subida correctamente';
            } else {
                $message = "La imagen no fue subida con éxito";
            }
            
            $this->set(compact("code", "message", "filename"));
            $this->set("_serialize", ["message", "filename"]);
        }
    }
}