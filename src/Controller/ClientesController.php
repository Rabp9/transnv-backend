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
    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['getRandom', 'index', 'view', 'download']);
    }

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
        $this->viewBuilder()->layout(false);
        
        $clientes = $this->Clientes->find();
                
        $this->set(compact('clientes'));
        $this->set('_serialize', ['clientes']);
    }
    
    public function view($id) {
        $cliente = $this->Clientes->get($id);
        
        $this->set(compact('cliente'));
        $this->set('_serialize', ['cliente']);
    }
    /*
    public function getRandom($num = null) {
        $num = $this->request->param('num');
        
        $productos = $this->Productos->find()
            ->where(['estado_id' => 1])
            ->limit($num)
            ->order('rand()');
        
        $this->set(compact('productos'));
        $this->set('_serialize', ['productos']);
    }
    */
    
    public function add() {
        $cliente = $this->Clientes->newEntity();
        
        if ($this->request->is('post')) {
            $cliente = $this->Clientes->patchEntity($cliente, $this->request->data);
            $cliente->estado_id = 1;
            
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
    /*
    public function preview() {
        $this->viewBuilder()->layout(false);
        
        if ($this->request->is("post")) {
            $filenames = array();
            $images = $this->request->data["files"];
            
            foreach ($images as $image) {
                $path_dst = WWW_ROOT . "tmp" . DS;
                $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
                $filename = 'producto-' . $this->Random->randomString() . '.' . $ext;

                $filename_src = $image["tmp_name"];
                $file_src = new File($filename_src);

                if ($file_src->copy($path_dst . $filename)) {
                    $filenames[] = $filename;
                } else {
                    $message = 'Algunas imágenes no pudieron ser cargadas';
                }
            }
            $message = 'Todas las imágenes fueron cargadas';
            $this->set(compact("message", "filenames"));
            $this->set("_serialize", ["message", "filenames"]);
        }
    }
    
    private function randomString($length = 6) {
        $str = "";
        $characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
        $max = count($characters) - 1;
        for ($i = 0; $i < $length; $i++) {
            $rand = mt_rand(0, $max);
            $str .= $characters[$rand];
        }
        return $str;
    }
    
    public function deleteImage() {
        $id = $this->request->getData()['id'];
        
        $producto_image = $this->Productos->ProductoImages->get($id);
        if ($this->Productos->ProductoImages->delete($producto_image)) {
            $message =  [
                'text' => __('La imagen fue eliminada correctamente'),
                'type' => 'success',
            ];
        } else {
            $message =  [
                'text' => __('La imagen no fue eliminada correctamente'),
                'type' => 'error',
            ];
        }
        $this->set(compact("message"));
        $this->set("_serialize", ["message"]);
    }
    
    public function previewBrochure() {
        $this->viewBuilder()->layout(false);
        
        if ($this->request->is("post")) {
            $brochure = $this->request->data["file"];
            
            $filename = "doc-" . $this->randomString();
            $url = WWW_ROOT . "tmp" . DS . $filename;
            $dst_final = WWW_ROOT . "files". DS . 'brochures' . DS . $filename;
                        
            while (file_exists($dst_final)) {
                $filename = "doc-" . $this->randomString();
                $url = WWW_ROOT . "tmp" . DS . $filename;
                $dst_final = WWW_ROOT . "files". DS . 'brochures' . DS . $filename;
            }
            
            if (move_uploaded_file($brochure["tmp_name"], $url)) {
                $message = [
                    "type" => "success",
                    "text" => "El brochure fue subida con éxito"
                ];
            } else {
                $message = [
                    "type" => "error",
                    "text" => "El brochure no fue subida con éxito",
                ];
            }
            
            $this->set(compact("message", "filename"));
            $this->set("_serialize", ["message", "filename"]);
        }
    }
    */
    
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
    
    /*
    public function download($id) {
        $producto = $this->Productos->get($id);
        $file = WWW_ROOT . "files". DS . 'brochures' . DS . $producto->brochure;
        $response = $this->response->withFile(
            $file,
            ['download' => true, 'name' => $producto->title . '.pdf']
        );
        return $response;
    }
    
    public function remove() {
        $producto = $this->Productos->get($this->request->getData('id'));
        
        if ($this->Productos->delete($producto)) {
            $message = [
                "type" => "success",
                "text" => "El producto fue eliminado con éxito"
            ];
        } else {
            $message = [
                "type" => "error",
                "text" => "El producto no fue eliminado con éxito",
            ];
        }
        
        $this->set(compact("message"));
    }
    */
    
    public function remove() {
        $cliente = $this->Clientes->get($this->request->getData('id'));
        
        if ($this->Servicios->delete($servicio)) {
            $message = [
                "type" => "success",
                "text" => "El servicio fue eliminado con éxito"
            ];
        } else {
            $message = [
                "type" => "error",
                "text" => "El servicio no fue eliminado con éxito",
            ];
        }
        
        $this->set(compact("message"));
    }
}