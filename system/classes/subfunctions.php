<?php
class subfunctions
{
    private $id_subfunction;
    private $str_cod_subfunction;
    private $str_name_subfunction;


    public function __construct($id_subfunction, $str_cod_subfunction, $str_name_subfunction)
    {
        $this->id_subfunction = $id_subfunction;
        $this->str_cod_subfunction = $str_cod_subfunction;
        $this->str_name_subfunction = $str_name_subfunction;
    }

    /**
     * @return mixed
     */
    public function getIdSubfunction()
    {
        return $this->id_subfunction;
    }

    /**
     * @param mixed $id_subfunction
     */
    public function setIdSubfunction($id_subfunction)
    {
        $this->id_subfunction = $id_subfunction;
    }

    /**
     * @return mixed
     */
    public function getStrCodSubfunction()
    {
        return $this->str_cod_subfunction;
    }

    /**
     * @param mixed $str_cod_subfunction
     */
    public function setStrCodSubfunction($str_cod_subfunction)
    {
        $this->str_cod_subfunction = $str_cod_subfunction;
    }

    /**
     * @return mixed
     */
    public function getStrNameSubfunction()
    {
        return $this->str_name_subfunction;
    }

    /**
     * @param mixed $str_name_subfunction
     */
    public function setStrNameSubfunction($str_name_subfunction)
    {
        $this->str_name_subfunction = $str_name_subfunction;
    }




}