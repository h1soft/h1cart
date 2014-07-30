<?php

namespace Module\Component;

/**
 * 数据库备份
 *
 * @author Allen Niu <h@h1soft.net>
 */
class Database extends \H1Soft\H\Singleton {

    public function backup() {
        $db = \H1Soft\H\Db\Db::getConnection();
        
        $tables = $db->tables();
        $handle = fopen(\H1Soft\H\Web\Application::$varPath .'/backup/db-backup-' . date('Ymd-His')  . '.sql', 'w+');
        foreach ($tables as $table) {
            $return = '';
            $result = mysqli_query($db->getLink(), 'SELECT * FROM ' . $table);
            $num_fields = mysqli_num_fields($result);            
            $return.= 'DROP TABLE ' . $table . ";";
            $row = $db->getRow('SHOW CREATE TABLE ' . $table);
            $return.= "\n\n" . $row['Create Table'] . ";\n\n";
            fwrite($handle, $return);
            $return = '';
            for ($i = 0; $i < $num_fields; $i++) {
                while ($row = mysqli_fetch_row($result)) {
                    $return.= 'INSERT INTO ' . $table . ' VALUES(';
                    for ($j = 0; $j < $num_fields; $j++) {
                        $row[$j] = addslashes($row[$j]);
//                        $row[$j] = ereg_replace("\n", "\\n", $row[$j]);
                        if (isset($row[$j])) {
                            $return.= '"' . $row[$j] . '"';
                        } else {
                            $return.= '""';
                        }
                        if ($j < ($num_fields - 1)) {
                            $return.= ',';
                        }
                    }
                    $return.= ");\n";
                }
                fwrite($handle, $return);
                $return = '';
            }
            fwrite($handle, "\n");
        }
        fclose($handle);
    }
    
    public function getBackupList(){
        
        return \H1Soft\H\Utils\File::getFileNames(\H1Soft\H\Web\Application::$varPath .'/backup/');
        
    }

}
