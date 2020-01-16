<?php
    require_once(dirname(__FILE__).'/../config.php');
    class ErrorLog{
        private $errorText,
                $filename,
                $isError;

        function __construct($filename) {
            $this->errorText    = "ERROR LOG ".date('Y-m-d H:i:s', time());
            $this->filename     = LOG_FOLDER.date('Y-m-d',time()).'-'.$filename.'.txt';
            $this->isError      = false;
            if (!is_dir(LOG_FOLDER)) {
                // dir doesn't exist, make it
                mkdir(LOG_FOLDER, 0777, true);
            }
        }

        public function errorLog($text, $http_code){
            $this->isError  = true;
            $newFile        = false;
            $errorText      = "Time: ".date('H:i:s',time())."\n".$text;
            $errorText      .= "\nPOST/GET Var:".json_encode(array($_POST,$_GET));            
            if(file_exists($this->filename) == false){
                file_put_contents($this->filename,"");
                $newFile = true;
            }
            $fileData   = file_get_contents($this->filename);
            file_put_contents($this->filename, $errorText."\n\n".$fileData);

            if($newFile == true){
                $this->sendErrorMail();
            }
            http_response_code($http_code);
        }
        public function isError(){
            return $this->isError;
        }
        private function sendErrorMail(){
            //  ERROR_MAIL
            $text   = "<h1>Es ist ein Fehler aufgetreten!</h1>";
            $text   .="<p>File:\t".$this->filename."</p>";
            $text   .="<p>Folder:\t".dirname(__FILE__)."</p>";
            $text   .="<p>Server:\t".SERVER_NAME."</p>";
            $from   = "From: LTE-REST <".MAIL_FROM.">\r\n";
            $from   .= "Content-Type: text/html; charset=utf-8\r\n";
            mail(ERROR_MAIL, 'FEHLERMELDUNG', $text, $from);
        }

    }

?>
