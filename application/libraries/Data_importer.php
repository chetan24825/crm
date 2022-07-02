<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Library to import data from .csv files
 */
class Data_importer {

    function __construct()
    {
        include (APPPATH.'third_party'.'/'.'PhpExcel'.'/'.'PHPExcel'.'/'.'IOFactory.php');
    }



    /**
	 * Import data from .csv file to a single table.
	 * Reference: http://csv.thephpleague.com/
	 * 
	 * Sample usage:
	 * 	$fields = array('name', 'email', 'age', 'active');
	 *  $this->load->library('data_importer');
	 *  $this->data_importer->csv_import('data.csv', 'users', $fields, TRUE);
	 */
	public function csv_import($file, $table, $fields, $clear_table = FALSE, $delimiter = ',', $skip_header = TRUE)
	{
		$CI =& get_instance();
		$CI->load->database();

		// prepend file path with project directory
		$reader = League\Csv\Reader::createFromPath(FCPATH.$file);
		$reader->setDelimiter($delimiter);

		// (optional) skip header row
		if ($skip_header)
			$reader->setOffset(1);

		// prepare array to be imported
		$data = array();
		$count_fields = count($fields);
		$query_result = $reader->query();
		foreach ($query_result as $idx => $row)
		{
			// skip empty rows
			if ( !empty($row[0]) )
			{
				$temp = array();
				for ($i=0; $i<$count_fields; $i++)
				{
					$name = $fields[$i];
					$value = $row[$i];
					$temp[$name] = $value;
				}
				$data[] = $temp;
			}
		}

		// (optional) empty existing table
		if ($clear_table)
			$CI->db->truncate($table);

		// confirm import (return number of records inserted)
		return $CI->db->insert_batch($table, $data);
	}

	/**
	 * Import data from Excel file to a single table.
	 * Reference: https://phpexcel.codeplex.com/
	 *
	 * TODO: complete feature
	 */

    //===========================================================
    // Product CSV Import
    //===========================================================

    public function product_excel_import($file)
    {
        $CI =& get_instance();
        $CI->load->database();

        // prepend file path with project directory
        $excel = PHPExcel_IOFactory::load($file);
        foreach ($excel->getWorksheetIterator() as $worksheet)
        {
            $highestRow = $worksheet->getHighestRow();
            for($row=2; $row<=$highestRow; $row++)
            {
                $name           = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $category_id    = (int)$worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $sales_cost     = (float)$worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $buying_cost    = (float)$worksheet->getCellByColumnAndRow(3, $row)->getValue();

                $data[] = array(
                    'name'              => $name,
                    'category_id'       => $category_id,
                    'sales_cost'        => $sales_cost,
                    'buying_cost'       => $buying_cost,
                    'type'              => 'service',
                );

            }
        }

        $CI->db->trans_start();
        $CI->db->insert_batch('product', $data);
        $CI->db->trans_complete();

        if ($CI->db->trans_status() === FALSE)
        {
            $CI->message->custom_error_msg('admin/product/importProduct', lang('failed_to_import_data'));
        }else{
            $CI->message->custom_success_msg('admin/product/importProduct', lang('import_data_successfully'));
        }
    }

	//===========================================================
    // Customer CSV Import
    //===========================================================

	public function customer_excel_import($file)
	{
        $CI =& get_instance();
        $CI->load->database();

		// prepend file path with project directory
		$excel = PHPExcel_IOFactory::load($file);
		foreach ($excel->getWorksheetIterator() as $worksheet)
		{
            $highestRow = $worksheet->getHighestRow();
            for($row=2; $row<=$highestRow; $row++)
            {
                $name           = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $company_name   = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                $phone1          = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                $phone2         = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                $email          = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                $website        = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                $address      = $worksheet->getCellByColumnAndRow(6, $row)->getValue();

                $data[] = array(
                      'name'            => $name,
                      'company_name'    => $company_name,
                      'phone_1'           => $phone1,
                      'phone_2'           => $phone2,
                      'email'           => $email,
                      'website'         => $website,
                      'address'       => $address,
                );

            }
		}

        $CI->db->trans_start();
        $CI->db->insert_batch('customer', $data);
        $CI->db->trans_complete();

        if ($CI->db->trans_status() === FALSE)
        {
            $CI->message->custom_error_msg('admin/customer/importCustomer', lang('failed_to_import_data'));
        }else{
            $CI->message->custom_success_msg('admin/customer/importCustomer', lang('import_data_successfully'));
        }
	}
	
	//===========================================================
    // Franchise CSV Import
    //===========================================================

    public function franchise_excel_import($file)
    {
        $CI =& get_instance();
        $CI->load->database();

        $prefix = FRANCHISE_ID_PREFIX;



        // prepend file path with project directory
        $excel = PHPExcel_IOFactory::load($file);
        foreach ($excel->getWorksheetIterator() as $worksheet)
        {
            $highestRow = $worksheet->getHighestRow();
            for($row=2; $row<=$highestRow; $row++)
            {
                $first_name         = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                $last_name          = $worksheet->getCellByColumnAndRow(1, $row)->getValue();

                $data= array(
                    'first_name'     => $first_name,
                    'last_name'      => $last_name,
                );

                $CI->db->trans_start();
                $CI->db->insert('franchise', $data);
                $id = $CI->db->insert_id();
                $CI->db->trans_complete();

                if ($CI->db->trans_status() === TRUE){
                    $franchise_id = $prefix+$id;
                    $data= array(
                        'franchise_id'   => $franchise_id,
                    );

                    $CI->db->where('id', $id);
                    $CI->db->update('franchise', $data);
                }
            }
        }

        $CI->message->custom_success_msg('admin/franchise/importFranchise', lang('import_data_successfully'));
    }
}