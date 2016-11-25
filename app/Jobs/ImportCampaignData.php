<?php

namespace App\Jobs;

use App\Models\Campaigns;
use App\Models\Thanks;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Helpers\CBMLog;

class ImportCampaignData implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public $uniqueTime;
    public $structure;

    protected $folderName;
    protected $prepare_directory;
    protected $process_directory;
    protected $complete_directory;
    protected $banner_directory;
    protected $image_folder;

    public $error = array();

    /**
     * ImportCampaignData constructor.
     * @param $folderName
     */
    public function __construct( $folderName ){
        $this->folderName = $folderName;
        $this->prepare_directory = storage_path().'/civi_data/download/';
        $this->process_directory = storage_path().'/civi_data/process/';
        $this->complete_directory = storage_path().'/civi_data/imported/';
        $this->banner_directory = public_path().'/banner/';

        $this->uniqueTime = uniqid('import_');
        $this->structure = 'import';
    }

    public function handle(){
       $this->writeLog('============= Start Import =============');

        try{
            // move to Process
            $this->moveToProcess();

            // read data
            $dataJson = $this->readData();

            // process data
            foreach ( $dataJson as $oneData ){
                $data_campaigns = $oneData['Promotion'];
                $image_copy = $data_campaigns['image_filename'];

                // if empty image or not exist image in folder => continue
                if(empty($image_copy) || !File::exists($this->image_folder.$image_copy)){
                    $this->writeLog("=== Empty Image in campaign {$data_campaigns['promotion_id']} ");
                    $this->error[] = "Empty Image in campaign {$data_campaigns['promotion_id']} ";
                    continue;
                }

                // import Campaign - if fail continue;
                $idCampaign = $this->processCampaign($data_campaigns);
                if(empty($idCampaign)){
                    continue;
                }

                // import Thanks - if fail continue;
                $processThanks = $this->processThanks($data_campaigns, $idCampaign, $data_campaigns['promotion_id']);
                if(!$processThanks){
                    continue;
                }
            }

            // move file to imported folder
            $this->moveToImported();

        }catch ( Exception $e) {
            $this->writeLog(' = CATCH EXCEPTION = ');
            $this->writeLog($e->getMessage());
            $this->error[] = $e->getMessage();
        }

        $this->writeLog('============= End Import =============');

        $this->sendEmail();

        $this->delete();
    }

    /**
     * Send email
     */
    private function sendEmail(){
        try{
            if(!empty($this->error)){
                Mail::queue('emails.import_error',
                    array(
                        'error' => $this->error
                    ), function($message)
                    {
                        $message->to(config('import.email'), config('import.name'))->subject(config('import.subject'));
                    });
            }
        }catch ( Exception $e) {
            $this->writeLog(' = Cannot send Email = '.$e->getMessage());
        }
        return true;
    }

    /**
     * @return bool
     * @throws Exception
     */
    private function moveToImported(){
        // get file name
        $folder_name = $this->folderName;

        try{
            if(!File::exists($this->complete_directory.$folder_name)){

                $this->writeLog('= Move Folder To Imported');
                File::moveDirectory($this->process_directory.$folder_name, $this->complete_directory.$folder_name);
            }else{
                $this->writeLog('= Folder already exists in imported folder');
            }

        }catch ( Exception $e ){
            $this->error[] = $e->getMessage();
            throw new Exception($e->getMessage());
        }

        return true;
    }

    /**
     * @param $data_campaigns
     * @param $idCampaign
     * @param $promotion_id
     * @return bool
     */
    private function processThanks( $data_campaigns, $idCampaign, $promotion_id ){
        if (!is_array($data_campaigns['thanks'])) {
            return false;
        }

        $thanks_id = 0;

        DB::beginTransaction();
        try{

            foreach ($data_campaigns['thanks'] as $oneThank) {
                $dataThank = $oneThank['Thank'];
                $thanks_id = !empty($dataThank['thanks_id']) ? intval($dataThank['thanks_id']) : null;
                $thanks_name = !empty($dataThank['thanks_name']) ? $dataThank['thanks_name'] : null;
                $thanks_type = intval($dataThank['thanks_type']) == 3 || intval($dataThank['thanks_type']) == 4 ? intval($dataThank['thanks_type']) : null;
                $normal_price = !empty($dataThank['normal_price']) ? $dataThank['normal_price'] : null;
                $special_price = !empty($dataThank['special_price']) ? $dataThank['special_price'] : null;
                $delete_flag = !empty($dataThank['delete_flag']) ? intval($dataThank['delete_flag']) : 0;

                Thanks::updateOrCreate(
                // duplicate data
                    [
                        'promotion_id' => $promotion_id,
                        'thanks_id' => $thanks_id
                    ],
                    // insert data
                    [
                        'campaign_id' => $idCampaign,
                        'thanks_name' => $thanks_name,
                        'thanks_type' => $thanks_type,
                        'normal_price' => $normal_price,
                        'special_price' => $special_price,
                        'delete_flag' => $delete_flag
                    ]
                );

                $this->writeLog("Update/Insert Promotion ID {$promotion_id} and Thanks Id {$thanks_id} : Ok");
            }

            DB::commit();
        }catch ( Exception $exception){
            DB::rollback();
            $this->error[] = "Fail Promotion ID {$promotion_id} and Thanks Id {$thanks_id}";
            $this->writeLog("Fail Promotion ID {$promotion_id} and Thanks Id {$thanks_id} :".$exception->getMessage());
            return false;
        }

        return true;
    }

    /**
     * @param $data_campaign
     * @return int
     */
    private function processCampaign ( $data_campaign ){
        $advertiser_id = !empty($data_campaign['advertiser_id']) ? $data_campaign['advertiser_id'] : null;
        $promotion_id = !empty($data_campaign['promotion_id']) ? intval($data_campaign['promotion_id']) : null;
        $advertiser_name = !empty($data_campaign['advertiser_name']) ? $data_campaign['advertiser_name'] : null;
        $promotion_name = !empty($data_campaign['promotion_name']) ? $data_campaign['promotion_name'] : null;
        $category_id = !empty($data_campaign['category_id']) ? intval($data_campaign['category_id']) : null;
        $detail_media = !empty($data_campaign['detail_media']) ? base64_decode($data_campaign['detail_media']) : null;
        $detail_enduser = !empty($data_campaign['detail_enduser']) ? base64_decode($data_campaign['detail_enduser']) : null;
        $certificate_condition = !empty($data_campaign['certificate_condition']) ? base64_decode($data_campaign['certificate_condition']) : null;
        $condition_reward = !empty($data_campaign['condition_reward']) ? base64_decode($data_campaign['condition_reward']) : null;
        $banner_id = isset($data_campaign['banner_id']) ? intval($data_campaign['banner_id']) : 0;
        $image_filename = !empty($data_campaign['image_filename']) ? $data_campaign['image_filename'] : null;
        $start_time = !empty($data_campaign['start_time']) ? date('Y-m-d H:i:s', $data_campaign['start_time']) : null;
        $end_time = intval($data_campaign['end_time'])!= 0 ? date('Y-m-d H:i:s', $data_campaign['end_time']) : null;
        $delete_flag = isset($data_campaign['delete_flag']) ? intval($data_campaign['delete_flag']) : 0;

        DB::beginTransaction();
        try{
            $idCampaign = Campaigns::updateOrCreate(
            // duplicate data
                [
                    'promotion_id' => $promotion_id,
                    'advertiser_id' => $advertiser_id
                ],
                // insert data
                [
                    'advertiser_name' => $advertiser_name,
                    'promotion_name' => $promotion_name,
                    'category_id' => $category_id,
                    'detail_media' => $detail_media,
                    'detail_enduser' => $detail_enduser,
                    'certificate_condition' => $certificate_condition,
                    'condition_reward' => $condition_reward,
                    'banner_id' => $banner_id,
                    'image_filename' => $image_filename,
                    'start_time' => $start_time,
                    'end_time' => $end_time,
                    'delete_flag' => $delete_flag
                ]
            );

            $this->writeLog("Update/Insert Promotion ID {$promotion_id} and Advertiser Id {$advertiser_id} : Ok");

            DB::commit();

            $this->moveImages($this->image_folder, $image_filename);
            // return ID;
            return $idCampaign->id;
        }catch ( Exception $exception){
            DB::rollback();
            $this->error[] = "Fail Promotion ID {$promotion_id} and Advertiser Id {$advertiser_id}";
            $this->writeLog("Fail Promotion ID {$promotion_id} and Advertiser Id {$advertiser_id} :".$exception->getMessage());
            return 0;
        }

    }

    /**
     * @return mixed
     * @throws Exception
     */
    private function readData(){
        try{
            // images folder
            $this->image_folder = $this->process_directory.$this->folderName.'/image/';
            // read content file
            $json_file = File::get($this->process_directory.$this->folderName.'/campaign_data.json'); // string
            $data_json = json_decode($json_file, true);
            if(!empty($data_json)){
                return $data_json;
            }else{
                throw new Exception('json data null');
            }

        }catch ( Exception $e) {
            $this->error[] = $e->getMessage();
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @return bool
     * @throws Exception
     */
    private function moveToProcess(){
        // get file name
        $folder_name = $this->folderName;
        $this->writeLog('===== Catch Folder :'.$folder_name);

        try{
            if(!File::exists($this->process_directory.$folder_name)
                && !File::exists($this->complete_directory.$folder_name)){
                $this->writeLog('= Copy Folder To Process');
                File::copyDirectory($this->prepare_directory.$folder_name, $this->process_directory.$folder_name);
            }else{
                $this->writeLog('= Folder already exists in process or imported folder');
            }

        }catch ( Exception $e ){
            $this->error[] = $e->getMessage();
            throw new Exception($e->getMessage());
        }

        return true;
    }


    /**
     * @param $folder
     * @param $image_copy
     */
    private function moveImages($folder, $image_copy){
        if(!empty($image_copy) && File::exists($folder.$image_copy)){
            File::copy($folder.$image_copy, $this->banner_directory.$image_copy);
        }
        $this->writeLog('= Move Images To Banner file =');
    }

    /**
     * Write Log function
     * @param $message
     */
    public function writeLog($message){
        CBMLog::writeLog($message, $this->uniqueTime, $this->structure);
    }

    public function failed(Exception $exception)
    {
        // Send user notification of failure, etc...
    }
}
