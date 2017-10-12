<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/6
 * Time: 15:02
 */

namespace EShine\Servers;
require __DIR__ . '/../vendor/autoload.php';

use Workerman\MySQL\Connection;


abstract class Office implements BaseInterface
{
    public function excelOut()
    {
        $db = new Connection('localhost', '', 'root', '', 'eshine');

        $massages = $db->select('*')->from($this->collectName())->query();

        if ($massages !== false) {
            $objPHPExcel = new \PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getActiveSheet()->setTitle($this->collectName());

            $data = $this->getSelfVar();
            foreach ($massages as $y => $massage) {
                if ($y == 0) {
                  $this->setExcelTitle($objPHPExcel);
                }
                $x = 0;
                foreach ($data as $key => $value) {
                    $objPHPExcel->getActiveSheet()->setCellValue(chr($x+65).($y+2), (isset($massage[$key])?$massage[$key].' ':''));
                    $x++;
                }
            }

            $objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
            header("Content-Type:application/force-download");
            header("Content-Type:application/vnd.ms-execl");
            header("Content-Type:application/octet-stream");
            header("Content-Type:application/download");;
            header('Content-Disposition:attachment;filename="'.$this->collectName().'.xls"');
            header("Content-Transfer-Encoding:binary");
            $objWriter->save('php://output');
        } else {
            throw new \Exception("数据获取失败");
        }

    }

    /**
     * @param \PHPExcel $objPHPExcel
     */
    public function setExcelTitle($objPHPExcel)
    {
        $x = 0;
        $data = $this->getSelfVar();
        foreach ($data as $key => $value) {
            $objPHPExcel->getActiveSheet()->setCellValue(chr($x+65).'1', $this->getPropertyDesc($key));
            $x++;
        }
        $objPHPExcel->getActiveSheet()->freezePane('A2');
    }

}