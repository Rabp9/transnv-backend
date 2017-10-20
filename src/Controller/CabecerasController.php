<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;

/**
 * Cabeceras Controller
 *
 * @property \App\Model\Table\CabecerasTable $Cabeceras
 *
 * @method \App\Model\Entity\Cabecera[] paginate($object = null, array $settings = [])
 */
class CabecerasController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['getDataMany', 'getData', 'getDataByData', 'add']);
    }
    /**
     * Add method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() {
        $cabecera = $this->Cabeceras->newEntity();
        
        if ($this->request->is('post')) {
            $cabecera = $this->Cabeceras->patchEntity($cabecera, $this->request->data);
            
            if ($cabecera->imagen) {
                $path_src = WWW_ROOT . "tmp" . DS;
                $file_src = new File($path_src . $cabecera->imagen);
             
                $path_dst = WWW_ROOT . 'img' . DS . 'cabeceras' . DS;
                $cabecera->imagen = $this->Random->randomFileName($path_dst, 'cabecera-', $file_src->ext());
                
                $file_src->copy($path_dst . $cabecera->imagen);
            }
            
            if ($this->Cabeceras->save($cabecera)) {       
                $code = 200;
                $message = 'La cabecera fue guardada correctamente';
            } else {
                $message = 'La cabecera no fue guardada correctamente';
            }
        }
        $this->set(compact('cabecera', 'message', 'code'));
        $this->set('_serialize', ['cabecera', 'message', 'code']);
    }
    
    /**
     * Save Many method
     *
     * @return \Cake\Network\Response|null Redirects on successful add, renders view otherwise.
     */
    public function saveMany() {
        if ($this->request->is('post')) {
            $cabeceras = $this->request->data;
            foreach ($cabeceras as $descripcion => $imagen) {
                $cabecera = $this->Cabeceras->find()->where(['descripcion' => $descripcion])->first();
                $cabecera->imagen = $imagen;
                $this->Cabeceras->save($cabecera);
            }
        }
        $code = 200;
        $message = 'La cabecera fue guardado correctamente';
        $this->set(compact('message', 'code'));
        $this->set('_serialize', ['message', 'code']);
    }

    /**
     * GetData method
     *
     * @param string|null $data.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function getData($descripcion = null) {
        $descripcion = $this->request->params['data'];
        
        $imagen = $this->Cabeceras->find()
            ->where(['descripcion' => $descripcion])
            ->first()->value;
        
        $this->set(compact('imagen'));
        $this->set('_serialize', ['imagen']);
    }
    
    /**
     * GetDataMany method
     *
     * @param string|null $data.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function getDataMany($data = null) {
        $descripciones = $this->request->data;
        $cabeceras = array();
        
        if ($this->request->is('post')) {
            foreach ($descripciones as $descripcion) {
                $value = $this->Cabeceras->find()
                    ->where(['descripcion' => $descripcion])
                    ->first()->imagen;
                $cabeceras[$descripcion] = $imagen;
            }
        }
        
        $this->set(compact('cabeceras'));
        $this->set('_serialize', ['cabeceras']);
    }
    
    public function getDataByData ($search = null) {
        $search = $this->request->data;
        
        $cabeceras = $this->Cabeceras->find()
            ->where(['Cabeceras.descripcion in ' => $search]);
        
        $this->set(compact('cabeceras'));
        $this->set('_serialize', ['cabeceras']);
    }
    
    public function previewImagen() {
        if ($this->request->is("post")) {
            $imagen = $this->request->data["file"];
            
            $path_dst = WWW_ROOT . "tmp" . DS;
            $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
            $filename = 'cabecera-' . $this->Random->randomString() . '.' . $ext;
           
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
