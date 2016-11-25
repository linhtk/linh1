<?php
namespace App\Http\Controllers;

use App\ApiServices\ApiConnection;
use App\Helpers\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Monolog\Formatter\LineFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ApiController extends Controller
{
    public $field = ['advertiser_id', 'promotion_id', 'advertiser_name',
        'promotion_name', 'category_id', 'detail_media', 'detail_enduser',
        'certificate_condition', 'condition_reward',
        'banner_id','image_filename',
        'start_time', 'end_time', 'delete_flag',
        'updated_at', 'created_at'];

    public $fieldThanks = ['campaign_id', 'promotion_id', 'thanks_id',
        'thanks_name', 'thanks_type', 'normal_price', 'special_price',
        'delete_flag', 'updated_at', 'created_at'];

    public $uniqueTime;

    public $error = array();

    public function index(){
        $data = Utils::getConfigCBM();
        print_r($data);
        die;
    }

    public function import(){
        $this->uniqueTime = uniqid('import_');
        $prepare_directory = storage_path().'/civi_data/download/';
        $process_directory = storage_path().'/civi_data/process/';
        $complete_directory = storage_path().'/civi_data/imported/';

        // check file json
        $listDirectories = File::directories($prepare_directory);

        $this->writeLog('============= Start Import =============');
        // if empty release job
        if(empty($listDirectories)){
            $this->writeLog('No Folder Data Campaign Found');
        }else{
            // get file name
            $workingDir = end($listDirectories);

            $split_name = explode("/", $workingDir);
            $folder_name = end($split_name);

            $this->writeLog('Catch '.$folder_name);

            $this->writeLog('Move File To Process');
            // move folder must import to process folder
            File::copyDirectory($prepare_directory.$folder_name, $process_directory.$folder_name);

            // images folder
            $images_directory = $process_directory.$folder_name.'/image/';
            // read content file
            $json_file = File::get($process_directory.$folder_name.'/campaign_data.json'); // string
            $data_json = json_decode($json_file, true);

            if(!empty($data_json)){
                foreach ($data_json as $one_campaign){
                    $thanks_insert = array();
                    $data_campaigns = $one_campaign['Promotion'];
                    //print_r($data_campaigns);
                    $query = array();
                    $image_copy = $data_campaigns['image_filename'];
                    foreach($this->field as $value){
                        // pass created_at and update_at
                        if($value == 'updated_at' || $value ==  'created_at'){
                            $query[] = "NOW()";
                        }else if($value == 'advertiser_name'){
                            $value_to_sql = isset($data_campaigns['company_adver_name']) ? addslashes($data_campaigns['company_adver_name']) : "";
                            $query[] = "'{$value_to_sql}'";
                        }else if($value == 'start_time' || $value == 'end_time'){
                            $value_to_sql = isset($data_campaigns[$value])&& $data_campaigns[$value] != 0 ? date('Y-m-d H:i:s', $data_campaigns[$value]) : null;
                            if($value_to_sql == null){
                                $query[] = "NULL";
                            }else{
                                $query[] = "'{$value_to_sql}'";
                            }
                        }else if($value == 'banner_id'){
                            $value_to_sql = isset($data_campaigns['banner_id']) ? ($data_campaigns['banner_id']) : 0;
                            $query[] = "{$value_to_sql}";
                        }else{
                            $value_to_sql = isset($data_campaigns[$value]) ? addslashes($data_campaigns[$value]) : "";
                            $query[] = "'{$value_to_sql}'";
                        }
                    }

                    $query = '('.implode(',', $query).')';
                    $insertCampaigns = $this->insertOrUpdateData($query, 1);
                    $this->writeLog("Inser/Update promotion id {$data_campaigns['promotion_id']} return id: {$insertCampaigns['data']}");
                    if($insertCampaigns['status'] == 1){
                        // move images
                        $this->moveImages($images_directory, $image_copy);
                        // write query insert thanks
                        if(is_array($data_campaigns['thanks'])){
                            foreach($data_campaigns['thanks'] as $oneThank){
                                $dataThank = $oneThank['Thank'];
                                $thank_query = [];
                                $thank_query['campaign_id'] = "'{$insertCampaigns['data']}'";
                                $thank_query['promotion_id'] = "'{$data_campaigns['promotion_id']}'";
                                $thank_query['thanks_id'] = "'{$dataThank['thanks_id']}'";
                                $thank_query['thank_name'] = "'{$dataThank['thanks_name']}'";
                                $thank_query['thanks_type'] = "'{$dataThank['thanks_type']}'";
                                $thank_query['normal_price'] = "'{$dataThank['normal_price']}'";
                                $thank_query['special_price'] = "'{$dataThank['special_price']}'";
                                $thank_query['delete_flag'] = "'{$dataThank['delete_flag']}'";
                                $thank_query['updated_at'] = "NOW()";
                                $thank_query['created_at'] = "NOW()";

                                $thank_query_sql = '('.implode(',', $thank_query).')';
                                // writing to sql query
                                $thanks_insert[] = $thank_query_sql;
                            }

                            $thanks_insert = implode(',', $thanks_insert);
                            $insertThanks = $this->insertOrUpdateData($thanks_insert);
                            $this->writeLog("Inser/Update THANKS for promotion id {$data_campaigns['promotion_id']} return : {$insertThanks['data']}");
                            if($insertThanks['status'] == 0){
                                $this->error[] = "Fail Thank :".($thanks_insert);
                            }
                        }
                    }else{
                        $this->error[] = "Fail Campaign :".json_encode($data_campaigns);
                    }
                }

            }else{
                $this->writeLog('Can not read json content');
            }

            $this->writeLog('Move File To Imported');
            // move file to imported folder
            File::move($process_directory.$folder_name, $complete_directory.$folder_name);

            // send Email fail
            if(!empty($this->error)){
                \Mail::queue('emails.import_error',
                    array(
                        'error' => $this->error
                    ), function($message)
                    {
                        $message->to(config('import.email'), config('import.name'))->subject(config('import.subject'));
                    });
            }
        }

        $this->writeLog('============= End Import =============');
        die();
    }

    /**
     * @param $folder
     * @param $image_copy
     */
    private function moveImages($folder, $image_copy){
        $banner_folder = public_path().'/banner/';
        if(!empty($image_copy) && File::exists($folder.$image_copy)){
            File::copy($folder.$image_copy, $banner_folder.$image_copy);
        }
        $this->writeLog('Move Images Banner file');
    }

    /**
     * insert or update data/bulk data
     * @param $query_insert
     * @param int $type
     * @return array
     */
    private function insertOrUpdateData($query_insert, $type = 0){
        $dup_values = '';

        if($type == 1){
            $objectColumn = $this->field;
            $table = 'campaigns';
        }else{
            $objectColumn = $this->fieldThanks;
            $table = 'thanks';
        }

        foreach($objectColumn as $value){
            if(!in_array($value, ['advertiser_id', 'promotion_id', 'created_at']))
                $dup_values .= "{$value} = values({$value}),";
        }
        $dup_values = rtrim($dup_values, ",");
        $field_insert = implode(',', $objectColumn);

        $sql = "INSERT INTO `{$table}` ({$field_insert}) VALUES {$query_insert} ON DUPLICATE KEY UPDATE {$dup_values}";

        DB::beginTransaction();
        try {
            DB::insert($sql);
            if($type == 1){
                $dataReturn = DB::getPdo()->lastInsertId();
            }else{
                $dataReturn = '0k';
            }
            DB::commit();
            // all good
            return ['status' => 1, 'data' => $dataReturn];
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $this->writeLog(serialize($query_insert), Logger::ERROR);
            return ['status' => 0, 'data' => $e->getMessage()];
        }
    }

    /**
     * @param $message
     * @param int $flagLevel
     */
    private function writeLog($message, $flagLevel = Logger::INFO){
        $file = date('d').'_import_info.log';
        $level = Logger::INFO;

        if($flagLevel == Logger::ERROR){
            $file = date('d').'_import_error.log';
            $level = Logger::ERROR;
        }

        $structure = storage_path().'/logs/import/'.date('Y').'/'.date('m').'/';

        // the default date format is "Y-m-d H:i:s"
        $dateFormat = "Y-m-d H:i:s";
        // the default output format is "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n"
        $output = "%datetime% > %level_name% > %message% %context% %extra%\n";
        // finally, create a formatter
        $formatter = new LineFormatter($output, $dateFormat);

        // Create a handler
        $stream = new StreamHandler($structure.$file, $level);
        $stream->setFormatter($formatter);
        // bind it to a logger object
        $securityLogger = new Logger('ImportData');
        $securityLogger->pushHandler($stream);

        // add records to the log
        if($level == Logger::ERROR) {
            $securityLogger->error($this->uniqueTime.' >> '.$message);
        }else{
            $securityLogger->info($this->uniqueTime.' >> '.$message);
        }
    }


}
