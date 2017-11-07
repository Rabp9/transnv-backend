<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;

/**
 * Servicios Controller
 *
 * @property \App\Model\Table\ServiciosTable $Servicios
 *
 * @method \App\Model\Entity\Servicio[] paginate($object = null, array $settings = [])
 */
class ServiciosController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['getSome', 'getIndex']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $servicios = $this->Servicios->find()
            ->where(['estado_id' => 1]);
        
        $this->set(compact('servicios'));
        $this->set('_serialize', ['servicios']);
    }
    
    public function getIndex() {
        $servicios = $this->Servicios->find()
            ->where(['estado_id' => 1])
            ->limit(2);
        
        $this->set(compact('servicios'));
        $this->set('_serialize', ['servicios']);
    }
    /**
     * Get Admin method
     *
     * @return \Cake\Network\Response|null
     */
    public function getAdmin() {        
        $servicios = $this->Servicios->find()
            ->select(['id', 'titulo', 'subtitulo', 'estado_id']);
                
        $this->set(compact('servicios'));
        $this->set('_serialize', ['servicios']);
    }
    
    public function view($id) {
        $servicio = $this->Servicios->get($id);
        
        $this->set(compact('servicio'));
        $this->set('_serialize', ['servicio']);
    }
    
    public function add() {
        $servicio = $this->Servicios->newEntity();
        
        if ($this->request->is('post')) {
            $servicio = $this->Servicios->patchEntity($servicio, $this->request->data);
            
            if ($servicio->portada) {
                $path_src = WWW_ROOT . "tmp" . DS;
                $file_src = new File($path_src . $servicio->portada);
             
                $path_dst = WWW_ROOT . 'img' . DS . 'servicios' . DS;
                $servicio->portada = $this->Random->randomFileName($path_dst, 'servicio-', $file_src->ext());
                
                $file_src->copy($path_dst . $servicio->portada);
            }
            
            if ($this->Servicios->save($servicio)) {
                $code = 200;
                $message = 'El servicio fue guardado correctamente';
            } else {
                $message = 'El servicio no fue guardado correctamente';
            }
        }
        
        $this->set(compact('servicio', 'message', 'code'));
        $this->set('_serialize', ['servicio', 'message', 'code']);
    }
    
    public function previewPortada() {
        if ($this->request->is("post")) {
            $portada = $this->request->data["file"];
            
            $path_dst = WWW_ROOT . "tmp" . DS;
            $ext = pathinfo($portada['name'], PATHINFO_EXTENSION);
            $filename = 'servicio-' . $this->Random->randomString() . '.' . $ext;
           
            $filename_src = $portada["tmp_name"];
            $file_src = new File($filename_src);

            if ($file_src->copy($path_dst . $filename)) {
                $code = 200;
                $message = 'La portada fue subida correctamente';
            } else {
                $message = "La portada no fue subida con éxito";
            }
            
            $this->set(compact("code", "message", "filename"));
            $this->set("_serialize", ["message", "filename"]);
        }
    }
    
    public function upload() { 
        if ($this->request->is("post")) {
            $imagen = $this->request->data["file"];
            
            $path_dst = WWW_ROOT . "img" . DS . "servicios" . DS . "pages" . DS;
            $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
            $filename = 'servicio-' . $this->Random->randomString() . '.' . $ext;
           
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
    
    /**
     * Get Some method
     *
     * @return \Cake\Network\Response|null
     */
    public function getSome($amount = 0) {
        $amount = $this->request->getParam('amount');
        $servicios = $this->Servicios->find()
            ->select(['id', 'titulo', 'resumen', 'portada'])
            ->where(['estado_id' => 1])
            ->order('rand()')
            ->limit($amount);
                
        $this->set(compact('servicios'));
        $this->set('_serialize', ['servicios']);
    }
}