<?php
class payments
{
    private $id_payment;
    private $tb_city_id_city;
    private $tb_functions_id_function;
    private $tb_subfunctions_id_subfunction;
    private $tb_program_id_program;
    private $tb_action_id_action;
    private $tb_beneficiaries_id_beneficiaries;
    private $tb_source_id_source;
    private $tb_files_id_file;
    private $int_month;
    private $int_year;
    private $db_value;

    public function __construct($id_payment, $tb_city_id_city, $tb_functions_id_function, $tb_subfunctions_id_subfunction, $tb_program_id_program, $tb_action_id_action, $tb_beneficiaries_id_beneficiaries, $tb_source_id_source, $tb_files_id_file, $int_month, $int_year, $db_value)
    {
        $this->id_payment = $id_payment;
        $this->tb_city_id_city = $tb_city_id_city;
        $this->tb_functions_id_function = $tb_functions_id_function;
        $this->tb_subfunctions_id_subfunction = $tb_subfunctions_id_subfunction;
        $this->tb_program_id_program = $tb_program_id_program;
        $this->tb_action_id_action = $tb_action_id_action;
        $this->tb_beneficiaries_id_beneficiaries = $tb_beneficiaries_id_beneficiaries;
        $this->tb_source_id_source = $tb_source_id_source;
        $this->tb_files_id_file = $tb_files_id_file;
        $this->int_month = $int_month;
        $this->int_year = $int_year;
        $this->db_value = $db_value;
    }

    /**
     * @return mixed
     */
    public function getIdPayment()
    {
        return $this->id_payment;
    }

    /**
     * @param mixed $id_payment
     */
    public function setIdPayment($id_payment)
    {
        $this->id_payment = $id_payment;
    }

    /**
     * @return mixed
     */
    public function getTbCityIdCity()
    {
        return $this->tb_city_id_city;
    }

    /**
     * @param mixed $tb_city_id_city
     */
    public function setTbCityIdCity($tb_city_id_city)
    {
        $this->tb_city_id_city = $tb_city_id_city;
    }

    /**
     * @return mixed
     */
    public function getTbFunctionsIdFunction()
    {
        return $this->tb_functions_id_function;
    }

    /**
     * @param mixed $tb_functions_id_function
     */
    public function setTbFunctionsIdFunction($tb_functions_id_function)
    {
        $this->tb_functions_id_function = $tb_functions_id_function;
    }

    /**
     * @return mixed
     */
    public function getTbSubfunctionsIdSubfunction()
    {
        return $this->tb_subfunctions_id_subfunction;
    }

    /**
     * @param mixed $tb_subfunctions_id_subfunction
     */
    public function setTbSubfunctionsIdSubfunction($tb_subfunctions_id_subfunction)
    {
        $this->tb_subfunctions_id_subfunction = $tb_subfunctions_id_subfunction;
    }

    /**
     * @return mixed
     */
    public function getTbProgramIdProgram()
    {
        return $this->tb_program_id_program;
    }

    /**
     * @param mixed $tb_program_id_program
     */
    public function setTbProgramIdProgram($tb_program_id_program)
    {
        $this->tb_program_id_program = $tb_program_id_program;
    }

    /**
     * @return mixed
     */
    public function getTbActionIdAction()
    {
        return $this->tb_action_id_action;
    }

    /**
     * @param mixed $tb_action_id_action
     */
    public function setTbActionIdAction($tb_action_id_action)
    {
        $this->tb_action_id_action = $tb_action_id_action;
    }

    /**
     * @return mixed
     */
    public function getTbBeneficiariesIdBeneficiaries()
    {
        return $this->tb_beneficiaries_id_beneficiaries;
    }

    /**
     * @param mixed $tb_beneficiaries_id_beneficiaries
     */
    public function setTbBeneficiariesIdBeneficiaries($tb_beneficiaries_id_beneficiaries)
    {
        $this->tb_beneficiaries_id_beneficiaries = $tb_beneficiaries_id_beneficiaries;
    }

    /**
     * @return mixed
     */
    public function getTbSourceIdSource()
    {
        return $this->tb_source_id_source;
    }

    /**
     * @param mixed $tb_source_id_source
     */
    public function setTbSourceIdSource($tb_source_id_source)
    {
        $this->tb_source_id_source = $tb_source_id_source;
    }

    /**
     * @return mixed
     */
    public function getTbFilesIdFile()
    {
        return $this->tb_files_id_file;
    }

    /**
     * @param mixed $tb_files_id_file
     */
    public function setTbFilesIdFile($tb_files_id_file)
    {
        $this->tb_files_id_file = $tb_files_id_file;
    }

    /**
     * @return mixed
     */
    public function getIntMonth()
    {
        return $this->int_month;
    }

    /**
     * @param mixed $int_month
     */
    public function setIntMonth($int_month)
    {
        $this->int_month = $int_month;
    }

    /**
     * @return mixed
     */
    public function getIntYear()
    {
        return $this->int_year;
    }

    /**
     * @param mixed $int_year
     */
    public function setIntYear($int_year)
    {
        $this->int_year = $int_year;
    }

    /**
     * @return mixed
     */
    public function getDbValue()
    {
        return $this->db_value;
    }

    /**
     * @param mixed $db_value
     */
    public function setDbValue($db_value)
    {
        $this->db_value = $db_value;
    }



}