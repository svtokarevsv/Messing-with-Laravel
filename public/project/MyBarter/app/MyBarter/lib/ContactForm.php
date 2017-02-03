<?php
namespace MyBarter\lib;

class ContactForm
{
    protected $from_name;
    protected $from_id;
    protected $message;
    protected $ad_id;
    protected $ad_title;
    protected $to_id;
    protected $model;


    /**
     * @param array $data
     */
    function __construct(Array $data, $model, $ad_id,$ad_title,$from_id,$to_id)
    {
        $this->from_id=$from_id;
        $this->to_id = $to_id;
        $this->ad_id = $ad_id;
        $this->ad_title = $ad_title;
        $this->message = isset($data['message']) ? $data['message'] : null;
        $this->model = $model;
        $data ? $this->send() : null;
    }

    public function send()
    {
        if ($this->validate()) {
            $from_id = (int)$this->from_id;
            $to_id = (int)$this->to_id;
            $message = (nl2br($this->message));
            $ad_id = (int)$this->model->getDb()->escape($this->ad_id);
            $ad_title = $this->model->getDb()->escape($this->ad_title);
            if($this->model->save_message($to_id, $from_id,$message, $ad_id,$ad_title))
            Session::setFlash('Ваше сообщение по объявлению '.$ad_title.' успешно отправлено.');
            else Session::setErrorFlash('Ваше сообщение не отправлено, попробуйте еще раз');
        } else {
            Session::setErrorFlash('Заполнены не все поля');

        }
    }

    public function validate()
    {
        return !empty($this->from_id) &&  !empty($this->message);
    }

}
