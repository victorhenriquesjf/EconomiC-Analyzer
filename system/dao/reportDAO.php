<?php
class reportDAO
{
    public function findAllBeneficiaries()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT id_beneficiaries, str_nis,str_name_person 
                                                  FROM tb_beneficiaries ORDER BY str_name_person');
            if ($statement->execute()) {
                $listBeneficiaries= $statement->fetchAll(PDO::FETCH_OBJ);
                return $listBeneficiaries;
            }else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function findAllBeneficiariesCity()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT id_beneficiaries, str_name_person, str_nis, id_city, str_name_city, str_cod_siafi_city, tb_state_id_state 
                                                  FROM db_eca.tb_payments, db_eca.tb_city, db_eca.tb_beneficiaries 
                                                  WHERE tb_beneficiaries.id_beneficiaries = tb_payments.tb_beneficiaries_id_beneficiaries 
                                                  AND tb_payments.tb_city_id_city = tb_city.id_city 
                                                  ORDER BY tb_city.str_name_city, tb_beneficiaries.str_name_person;');
            if ($statement->execute()) {
                $listBeneficiariesCity = $statement->fetchAll(PDO::FETCH_OBJ);
                return $listBeneficiariesCity;
            }else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function findAllPayments()
    {
       global $pdo;
        try {
            $statement = $pdo->prepare('SELECT tb_payments.id_payment, tb_city.str_name_city, tb_functions.str_name_function, tb_subfunctions.str_name_subfunction, tb_program.str_name_program, tb_action.str_name_action, tb_beneficiaries.str_name_person, tb_source.str_goal, tb_files.str_name_file 
                                                  FROM tb_payments, tb_city, tb_functions, tb_beneficiaries, tb_action, tb_program, tb_subfunctions, tb_source, tb_files 
                                                  WHERE tb_payments.tb_city_id_city = tb_city.id_city 
                                                  AND tb_payments.tb_beneficiaries_id_beneficiaries = tb_beneficiaries.id_beneficiaries 
                                                  AND tb_payments.tb_action_id_action = tb_action.id_action
                                                  AND tb_payments.tb_program_id_program = tb_program.id_program 
                                                  AND tb_payments.tb_subfunctions_id_subfunction = tb_subfunctions.id_subfunction 
                                                  AND tb_payments.tb_source_id_source = tb_source.id_source 
                                                  AND tb_payments.tb_functions_id_function = tb_functions.id_function 
                                                  AND tb_payments.tb_files_id_file = tb_files.id_file;');
            if ($statement->execute()) {
                $listPayments = $statement->fetchAll(PDO::FETCH_OBJ);
                return $listPayments;
            }else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }

    }

    public function findAllPaymentsCity()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT SUM(db_value) AS valuesSum, tb_city.str_name_city , 
                                                  COUNT(DISTINCT tb_payments.tb_beneficiaries_id_beneficiaries) AS counter 
                                                  FROM tb_payments, tb_city 
                                                  WHERE tb_payments.id_payment = tb_city.id_city 
                                                  GROUP BY tb_payments.tb_city_id_city 
                                                  ORDER BY SUM(db_value) DESC;');
            if ($statement->execute()) {
                $listPaymentsCity = $statement->fetchAll(PDO::FETCH_OBJ);
                return $listPaymentsCity;
            }else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function findAllPaymentsState()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT SUM(db_value) valuesSum, str_name 
                                                  FROM db_eca.tb_payments, tb_city, tb_state 
                                                  WHERE tb_payments.id_payment = tb_city.id_city 
                                                  AND tb_city.tb_state_id_state = tb_state.id_state 
                                                  GROUP BY tb_state.id_state 
                                                  ORDER BY tb_state.str_name;');
            if ($statement->execute()) {
                $listPaymentsState = $statement->fetchAll(PDO::FETCH_OBJ);
                return $listPaymentsState;
            }else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function findAllPaymentsRegion()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare('SELECT SUM(db_value) valuesSum, str_name_region 
                                                  FROM db_eca.tb_payments, tb_city, tb_state, tb_region 
                                                  WHERE tb_payments.id_payment = tb_city.id_city 
                                                  AND tb_city.tb_state_id_state = tb_state.id_state 
                                                  AND tb_state.tb_region_id_region = tb_region.id_region 
                                                  GROUP BY tb_region.id_region 
                                                  ORDER BY tb_state.str_name;');
            if ($statement->execute()) {
                $listPaymentsRegion = $statement->fetchAll(PDO::FETCH_OBJ);
                return $listPaymentsRegion;
            }else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function findByMesAno()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT DISTINCT(B.str_name_person) AS tb_beneficiaries,
                                                  COUNT(P.tb_beneficiaries_id_beneficiaries) AS QTD,
                                                  SUM(P.db_value) AS SOMA,P.int_month,P.int_year  
                                                  FROM tb_payments P 
                                                  INNER JOIN tb_beneficiaries B 
                                                  ON tb_beneficiaries_id_beneficiaries = id_beneficiaries 
                                                  GROUP BY P.tb_beneficiaries_id_beneficiaries,P.int_month,P.int_year");
            if ($statement->execute()) {
                $lista = $statement->fetchAll(PDO::FETCH_OBJ);
                return $lista;
            }else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }

    public function sumBeneficiariesHelp()
    {
        global $pdo;
        try {
            $statement = $pdo->prepare("SELECT DISTINCT(B.str_name_person) AS tb_beneficiaries,
                                                  COUNT(P.tb_beneficiaries_id_beneficiaries) AS qnt,
                                                  SUM(P.db_value) AS valuesSum,P.int_month,P.int_year  
                                                  FROM tb_payments P 
                                                  INNER JOIN tb_beneficiaries B ON tb_beneficiaries_id_beneficiaries = id_beneficiaries 
                                                  GROUP BY P.tb_beneficiaries_id_beneficiaries,P.int_month,P.int_year");
            if ($statement->execute()) {
                $listBeneficiariesHelp = $statement->fetchAll(PDO::FETCH_OBJ);
                return $listBeneficiariesHelp;
            }else {
                throw new PDOException("<script> alert('Erro na declaração SQL !'); </script>");
            }
        }catch (PDOException $erro) {
            return "Erro: " . $erro->getMessage();
        }
    }
}