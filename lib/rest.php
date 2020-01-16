<?php
    require_once(dirname(__FILE__).'/../config.php');
    require_once(dirname(__FILE__).'/error.php');

    class REST{
        private $methode,
                $user,
                $password,
                $json,
                $error,
                $files  = array();

        function __construct(){
            $this->methode    = $_SERVER['REQUEST_METHOD'];
            switch ($this->methode) {
                case 'POST':
                    $this->usePost();
                    break;  

                default:
                    $this->setError(405, "Method not found.");
                    break;
            }
        }

        /*
        *   Use the post methode
        */
        private function usePost(){
            $this->setUserData();
            if($this->isAllowed() == true){
                if($this->uploadFile() == true){
                    $text       = "Files are uploaded";
                    http_response_code(201);
                    $this->setJson(array("text" => $text, "files" => $this->files));
                    $this->setLog($text);
                }
            }
        }

        /*
        *   Upload the file from the stream
        */
        private function uploadFile(){
            $return = false;   
            //is request set 
            if(isset($_FILES) && count($_FILES) >= 1){
                foreach ($_FILES as $key => $file) {
                    //is file type is allowed to upload
                    if(isset(ALLOWED_FILES[$file['type']])){
                        $fileName   = $this->getNewFileName($file['name'], $file['type']);
                        $data       = file_get_contents($file['tmp_name']);
                        if (!is_dir(FILE_DIR)) {
                            // dir doesn't exist, make it
                            mkdir(FILE_DIR, 0777, true);
                        }
                        if(file_put_contents(FILE_DIR.$fileName, $data ) !== false){
                            $this->files[] = $fileName;
                            $return = true;
                        }else{
                            $this->setError(500, "The File '".$fileName."' can not be created");
                        }
                    }else{
                        $this->setError(415, "File typ '".$file['type']."' is not allowed (".$_FILES['file']['name'].")");
                    }
                }
            }else{
                $this->setError(406, "Request is not acceptable");
            }
            return $return;
        }

        /*
        *   Check if user is allowed to use the rest
        */
        private function isAllowed(){
            $allowed        = false;
            if($this->user == LOGIN_USER && password_verify($this->password, LOGIN_PASSWORD)){
                $allowed    = true;
            }else{
                $this->setError(401, "User or password is wrong");
            }
            return $allowed;
        }

        /*
        *   Get new file name
        */
        private function getNewFileName($fileName, $typ){
            $typ        = ALLOWED_FILES[$typ];
            $counter    = 0;
            $notExist   = true;
            //Check if file name already exist
            do {
                $tmpFile    = $fileName;
                $tmpFile    .= ($counter == 0)?('.'):('_'.$counter.'.');
                $tmpFile    .= $typ;
                if(file_exists(FILE_DIR.$tmpFile) == false){
                    $notExist   = false;
                    $fileName   = $tmpFile;
                }
                $counter++;
            } while($notExist == true);
            return $fileName;
        }

        /*
        *   Set the user data
        */
        private function setUserData(){
            $this->user     = (isset($_SERVER['PHP_AUTH_USER']) == true)?($_SERVER['PHP_AUTH_USER']):(NULL);
            $this->password = (isset($_SERVER['PHP_AUTH_PW']) == true)?($_SERVER['PHP_AUTH_PW']):(NULL);
        }

        /*
        *   If something went wrong than this function create a log file
        */
        private function setError($http_code, $text){
            // $files will be a copy off $_FILES without the tmp_name value
            $files          = array();
            foreach($_FILES as $key => $value){
                $tmpFile = array(
                    'key'   => $key,
                    'name'  => $value['name'],
                    'type'  => $value['type']
                );
                $files[]  = $tmpFile;
            }
            $this->setJson(
                array(
                    'text'          => $text,
                    'your_post'     => json_encode($_POST),
                    'your_files'    => json_encode($files)
                )
            );
            $this->setLog($text);
            $this->error    = new ErrorLog('REST');
            $this->error->errorLog($text, $http_code);
        }

        /*
        *   Write a Log
        */
        private function setLog($text){
            $log    = date('G:i:s').":\t".$text."\n";
            $path   = LOG_FOLDER.'Log-'.date('Y-m-d',time()).'.txt';
            if (!is_dir(LOG_FOLDER)) {
                // dir doesn't exist, make it
                mkdir(LOG_FOLDER, 0777, true);
              }
            file_put_contents($path, $log, FILE_APPEND);
        }

        /*
        *   Set json
        */
        public function setJson($array){
            $this->json = json_encode($array);
        }

        /*
        *   Return json
        */
        public function getJson(){
            return $this->json;
        }

    }
?>
