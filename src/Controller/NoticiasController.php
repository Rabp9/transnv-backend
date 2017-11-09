<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Filesystem\File;

/**
 * Noticias Controller
 *
 * @property \App\Model\Table\NoticiasTable $Noticias
 *
 * @method \App\Model\Entity\Noticia[] paginate($object = null, array $settings = [])
 */
class NoticiasController extends AppController
{
    
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['getSome', 'index']);
    }
    
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index() {
        $noticias = $this->Noticias->find()
            ->where(['estado_id' => 1]);
        
        $this->set(compact('noticias'));
        $this->set('_serialize', ['noticias']);
    }
    
    /**
     * Get Admin method
     *
     * @return \Cake\Network\Response|null
     */
    public function getAdmin() {        
        $noticias = $this->Noticias->find()
            ->select(['id', 'titulo', 'subtitulo', 'estado_id']);
                
        $this->set(compact('noticias'));
        $this->set('_serialize', ['noticias']);
    }
    
    public function view($id) {
        $noticia = $this->Noticias->get($id);
        
        $this->set(compact('noticia'));
        $this->set('_serialize', ['noticia']);
    }
    
    public function add() {
        $noticia = $this->Noticias->newEntity();
        
        if ($this->request->is('post')) {
            $noticia = $this->Noticias->patchEntity($noticia, $this->request->data);
            
            if ($noticia->portada) {
                $path_src = WWW_ROOT . "tmp" . DS;
                $file_src = new File($path_src . $noticia->portada);
             
                $path_dst = WWW_ROOT . 'img' . DS . 'noticias' . DS;
                $noticia->portada = $this->Random->randomFileName($path_dst, 'noticia-', $file_src->ext());
                
                $file_src->copy($path_dst . $noticia->portada);
            }
            
            if ($this->Noticias->save($noticia)) {
                $code = 200;
                $message = 'El noticia fue guardado correctamente';
            } else {
                $message = 'El noticia no fue guardado correctamente';
            }
        }
        
        $this->set(compact('noticia', 'message', 'code'));
        $this->set('_serialize', ['noticia', 'message', 'code']);
    }
    
    public function previewPortada() {
        if ($this->request->is("post")) {
            $portada = $this->request->data["file"];
            
            $path_dst = WWW_ROOT . "tmp" . DS;
            $ext = pathinfo($portada['name'], PATHINFO_EXTENSION);
            $filename = 'noticia-' . $this->Random->randomString() . '.' . $ext;
           
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
            
            $path_dst = WWW_ROOT . "img" . DS . "noticias" . DS . "pages" . DS;
            $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
            $filename = 'noticia-' . $this->Random->randomString() . '.' . $ext;
           
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
        $noticias = $this->Noticias->find()
            ->select(['id', 'titulo', 'resumen', 'portada'])
            ->where(['estado_id' => 1])
            ->order('rand()')
            ->limit($amount);
                
        $this->set(compact('noticias'));
        $this->set('_serialize', ['noticias']);
    }
}