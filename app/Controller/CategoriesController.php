<?
class CategoriesController extends AppController {

    public function index() {
        $data = $this->Category->generateTreeList();
        debug($data); die;
    }
}