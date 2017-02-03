<?php
namespace MyBarter\lib;

class AdForm extends Form
{
    protected $title;
    protected $category;
    protected $description;
    protected $price;
    protected $file = array();
    protected $region;

    /**
     * @param array $data
     */
    function __construct(Array $data, $model, $old_data = false)
    {
        parent::__construct($data, $model);
        $this->title = isset($data['title']) ? $data['title'] : null;
        $this->category = isset($data['category']) ? $data['category'] : null;
        $this->description = isset($data['description']) ? nl2br($data['description']) : null;
        $this->price = isset($data['price']) ? $data['price'] : null;
        $this->file = isset($data['file[]']) ? $data['file[]'] : null;
        $this->region = isset($data['region']) ? $data['region'] : null;
        $_POST ? $this->post_ad($old_data) : null;
    }

    public function post_ad($old_data)
    {
        if ($this->validate()) {
            $img = !empty($old_data['img'])?$old_data['img']:$this->model->getDb()->escape();
            $img_other = !empty($old_data['img_other'])?$old_data['img_other']:$this->model->getDb()->escape();
            $img_other2 = !empty($old_data['img_other2'])?$old_data['img_other2']:$this->model->getDb()->escape();
            $title = $this->title;
            $category = $this->category;
            $id_user = Session::get('id');
            $text = $this->description;
            $price =$this->price;
            $image_path = $this->add_files($id_user, $title);
            if (!empty($image_path[0])) {
                $img = $image_path[0];
            }
            if (!empty($image_path[1])) {
                $img_other = $image_path[1];
            }
            if (!empty($image_path[2])) {
                $img_other2 = $image_path[2];
            }

//            $file = $this->model->getDb()->escape($this->email);
            $region = intval($this->region);

            if ($old_data === false)
                $this->model->new_ad($title, $text, $id_user, $category, $region, $price, $img, $img_other, $img_other2);
            else
                $this->model->update_ad($old_data['id'], $title, $text, $category, $region, $price, $img, $img_other, $img_other2);


        }

    }

    public function add_files($id, $title)
    {
        $count = 0;
        $img_path = null;
//        die(var_dump($_FILES));
        foreach ($_FILES['files']['name'] as $k => $name) {
//            if($_FILES['filenames']['size'][$k]<5*1024){
            if (!empty($_FILES['files']['tmp_name'][$k]) and getimagesize($_FILES['files']['tmp_name'][$k])) {
                $time = time();
                $dir_path = 'uploads/' . $id . "/" . View::NormalizeStringToLatin($title) . $time;
                $img_p = $dir_path . "/" . $time . '_' . $name;
                if (!file_exists($dir_path)) {
                    mkdir($dir_path, 0700, true);
                }
                move_uploaded_file($_FILES['files']['tmp_name'][$k], $img_p);
                $count++;
                $img_path[$k] = $img_p;
                if ($count == 3) break;

            }

        }
        return $img_path;
    }


    public function validate()
    {
        $message = null;
        if (is_string($this->title)) null; else $message = 'Неверный формат названия объявления<br/>';
        if (in_array((int)$this->category, range(1, 16))) null; else $message .= 'Неверный формат категории<br/>';
        if (is_string($this->description)) null; else $message .= 'Неверный формат описания объявления<br/>';
        if (is_float((float)$this->price)) null; else $message .= 'Неверный формат цены<br/>';
        if (in_array((int)$this->region, range(1, 25))) null; else $message .= 'Неверный формат региона<br/>';

        if (!empty($message)) Session::setErrorFlash($message); else return true;
    }

    public
    function passwordsMatch()
    {
        return $this->password == $this->passwordConfirm;
    }
}
