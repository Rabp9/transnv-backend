<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;

/**
 * Contactos Controller
 *
 * @property \App\Model\Table\ClientesTable $Contactos
 *
 * @method \App\Model\Entity\Contacto[] paginate($object = null, array $settings = [])
 */
class ContactosController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $contactos = $this->Contactos->find()
            ->where(['estado_id' => 1]);
        
        $this->set(compact('contactos'));
        $this->set('_serialize', ['contactos']);
    }
    
    /**
     * Get Admin method
     *
     * @return \Cake\Network\Response|null
     */
    public function getAdmin() {        
        $contactos = $this->Contactos->find();
                
        $this->set(compact('contactos'));
        $this->set('_serialize', ['contactos']);
    }
    
    public function view($id) {
        $contacto = $this->Contactos->get($id);
        
        $this->set(compact('contacto'));
        $this->set('_serialize', ['contacto']);
    }
    
    public function add() {
        $contacto = $this->Contactos->newEntity();
        
        if ($this->request->is('post')) {
            $contacto = $this->Contactos->patchEntity($contacto, $this->request->data);
            
            if ($contacto->imagen) {
                $path_src = WWW_ROOT . "tmp" . DS;
                $file_src = new File($path_src . $contacto->imagen);
             
                $path_dst = WWW_ROOT . 'img' . DS . 'contactos' . DS;
                $contacto->imagen = $this->Random->randomFileName($path_dst, 'contacto-', $file_src->ext());
                
                $file_src->copy($path_dst . $contacto->imagen);
            }
            
            if ($this->Contactos->save($contacto)) {
                $code = 200;
                $message = 'El contacto fue guardado correctamente';
            } else {
                $message = 'El contacto no fue guardado correctamente';
            }
        }
        
        $this->set(compact('contacto', 'message', 'code'));
        $this->set('_serialize', ['contacto', 'message', 'code']);
    }
    
    public function previewImagen() {        
        if ($this->request->is("post")) {
            $imagen = $this->request->data["file"];
            
            $path_dst = WWW_ROOT . "tmp" . DS;
            $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
            $filename = 'contacto-' . $this->Random->randomString() . '.' . $ext;
           
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